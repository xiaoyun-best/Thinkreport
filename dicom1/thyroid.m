%function [area, vol,weight] = thyroid(json_str, ReleaseVersion,handles,dcmname)
function [area, vol,weight,therapy_bq,aquization_duration] = thyroid(json_str)
% calc Volume of thyroid, by BQ and a
% filename : dicom file name
% iur : iodine update rate (2-h RAIU)
% types : 'Hyperthyroidism' or 'remnant mass'

vol = 0;
area = 0;
weight = 0;
log0 = fopen('logfile0.txt','w');
fprintf(log0, '%s\n','position 0');
fprintf(log0, '%s\n', json_str);
fclose(log0);

if exist('dcminfo_error.txt','file')==2
    delete('dcminfo_error.txt');
end;
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%params
types = 'Hyperthyroidism';
called = chg_called_json(json_str);

ReleaseVersion = 1;
isDebug = ~ReleaseVersion;
dicom_url = called.url;
out_url = called.url2;
corner = called.coord;
sid = called.id;
urlChar = called.url3;
left_density = called.left_density;
right_density = called.right_density;

RAIU_2h = called.raiu_2h;
RAIU_24h = called.raiu_24h;
AIU = called.AIU;

[ret, retinfo] = qed_pacs_get_dicom(dicom_url); % get a dicom figture from web
dcmname = './temp.dcm';

% if isDebug
%     if(~exist('dcmname','var'))
%         [dcmname,pathname] = uigetfile( ...
%             { '*.dcm;*.IMA','dicom file(*.dcm,*.IMA)'; ...
%             '*.*',  'All Files (*.*)'}, ...
%             'Pick a file','MultiSelect','off', ...
%             'E:\\pictures\\patient');%'../../_thyroid/patient');
%         
%         if dcmname ==0, return; end;
%         dcmname = [pathname dcmname];
%     end;
% end
%[strPath,strName] = fileparts(dcmname);

% default 3hour iur

if ~exist('types','var')
    disp('types must be input: ''Hyperthyroidism'' or ''Remnant mass''');
    return;
end;



% debug or release version
log1 = fopen('logfile1.txt','w');
fprintf(log1, '%s\n','position 1');
fprintf(log1, '%s\n', dicom_url);
fprintf(log1, '%s\n', out_url);
fprintf(log1, '%s\n', urlChar);
fprintf(log1, 'sid is %s\n', sid);
fprintf(log1, 'corner 1 is %f', corner(1));
fclose(log1);

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% open dicom file
dcminfo=dicominfo(dcmname);
dcmfile=double(dicomread(dcmname));
if length(size(dcmfile))>2
 dcmfile = (dcmfile(:, :, 1)+dcmfile(:, :, 2) + dcmfile(:, :, 3))/3;
end;



% show image
if isDebug
    %     fig=figure(1);
    %     subplot (2,2,1,'Position'); 
    axes(handles.axes1);
    imshow(dcmfile,[]);title(dcminfo.PatientName.FamilyName);
end;



% get rect by mouse drawing
switch types
    case 'Remnant mass'
        if isDebug
            rect = uint16(getrect); %rect(xmin,ymin,width,height)
            rectangle('Position',rect,'EdgeColor','y');
        else
            rect  = resort(corner(1), corner(2), corner(3), corner(4));
        end
    case 'Hyperthyroidism'
        if sum(corner) == 0
            rect = getValidImgRect(dcmfile);
        else
            rect = resort(corner(1), corner(2), corner(3), corner(4));
        end
    otherwise
        disp('type not ''Hyperthyroidism'' or ''Remnant mass''');
        return;
end;

log2 = fopen('logfile2.txt','w');
fprintf(log2, '%s\n','position 2');
fprintf(log2, 'rect 1 is %s\n', rect(1));
fclose(log2);

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% calc image params

t_begin = clock;

% remove background by rect
[rows,cols]=size(dcmfile);
mask=zeros(rows,cols);
mask(rect(2):(rect(2)+rect(4)), rect(1):(rect(1)+rect(3)))=1;

% blur image to layers
%dcmfileBlur = filter2(fspecial('average',5),dcmfile);
dcmfileBlur = medfilt2(dcmfile,[7,7]);
dcmfileBlur = blurImage(dcmfileBlur);

dcmfileBlur = mask .* dcmfileBlur;
a = dcmfileBlur(dcmfileBlur>0);
delta = std(a(:));
dcmfileBlur = dcmfileBlur.^(1+(5/delta));
%dcmfileBlur = exp(dcmfileBlur );

m2 = 255/max(dcmfileBlur(:));
dcmfileBlur = dcmfileBlur .* m2;

%subplot (2,2,2,'Position');
if isDebug
    axes(handles.axes2);
    imshow(dcmfileBlur,[]);title('Filter');
end

%segment and get masked image data
svmmask = svm(dcmfileBlur, mask, 1000, 0.1, false); %-- Run segmentation
svmmask0 = svmmask;

[leftmask0, rightmask0, spx] = SeperationLR(svmmask0); %Divide thyroid into left part and right part
%get background threshold
bgThreshold = getBackground(dcmfile,rect,svmmask); 
dcmfileMasked = dcmfile - bgThreshold;
svmmask = (dcmfileMasked)>=0;
dcmfileMasked = dcmfileMasked .* svmmask .* mask;
right_dcmfilemask = zeros(size(dcmfileMasked));
left_dcmfilemask = zeros(size(dcmfileMasked));
for i = 1: size(dcmfileMasked, 2)
    if(i <= spx)
        right_dcmfilemask(:, i) = dcmfileMasked(:, i);
    end
    if(i > spx)
        left_dcmfilemask(:, i) = dcmfileMasked(:, i);
    end
end
bgfig = dcmfile - dcmfileMasked;
area = getArea(dcminfo,dcmfileMasked);
left_area = getArea(dcminfo, left_dcmfilemask);
right_area = getArea(dcminfo, right_dcmfilemask);

% iur caculation
Bq= sum(dcmfileMasked(:));
left_Bq = sum(left_dcmfilemask(:));
right_Bq = sum(right_dcmfilemask(:));

bg = (sum(dcmfile(:)) - Bq);

if RAIU_2h>0
    iur =  RAIU_2h * 1.5;
    if iur>0.40, iur = 0.4; end;
    left_iur = iur * (left_Bq/Bq);
    right_iur = iur * (right_Bq/Bq);
else
    iur =  Bq/sum(dcmfile(:));
    RAIU_2h = iur / 1.5;
    if iur>0.40, iur = 0.4; end;
    left_iur = left_Bq/sum(dcmfile(:));
    right_iur = right_Bq/sum(dcmfile(:));
end;

if RAIU_24h==0
    RAIU_24h = RAIU_2h * 3.0;
    if RAIU_24h>0.8, RAIU_24h = 0.8; end;
end;

maxvalue = max(dcmfile(:));
[ret,retinfo, mix_img]  = qed_img_mask2contour( svmmask0, dcmfile, maxvalue);

try
    file_struct.PatientID = dcminfo.PatientID;
    file_struct.PatientName = dcminfo.PatientName.FamilyName;
    file_struct.StudyID = dcminfo.StudyID;
catch
    info_error = fopen('dcminfo_error.txt','a+');
    fprintf(info_error, 'dcminfo error!');
    fclose(info_error);
end

mix_img = uint8(mix_img);
%dicom file uploading
file_struct.dcmname = './temp_out.dcm';
[ ret,retinfo ] =qed_pacs_create_dicom( mix_img,file_struct, dcminfo);
[ ret,retinfo ] = qed_pacs_upload_dicom( file_struct.dcmname,out_url );



tempjson = loadjson(retinfo);


%urlreadpost(urlChar,params);


% show area,Bq,Duration in titles=sprintf('a=%.1f %.1fk %.0fs',area/100,Bq/1000,dcminfo.ActualFrameDuration/1000);
if isDebug
    axes(handles.axes3);
    %clipedImage = subplot (2,2,3,'Position');
    imshow(dcmfileMasked,[]);title(s);
end
%imwrite(uint8(dcmfileMasked),'masked.png','png');

%calc volume
vol = getVolumeByPoly1(dcminfo,dcmfileMasked,iur);
left_vol = vol * (sum(left_dcmfilemask(:)))/sum(dcmfileMasked(:));
right_vol = vol * sum(right_dcmfilemask(:))/sum(dcmfileMasked(:));

left_depth = left_vol / left_area * 10^3;
right_depth = right_vol / right_area * 10^3;


%weight
%weight = vol * 1.001; % density = 1.001
left_weight = left_vol * left_density;
right_weight = right_vol * right_density;
weight = left_weight + right_weight;

%therapy dose(Bq)
therapy_bq = AIU * weight / RAIU_24h;

%dicom param for check
aquization_duration = dcminfo.ActualFrameDuration/1000;

t_end = clock;

%output infor
result = sprintf('[RAIU=%.2f,%.2f\t] [l,r density=%.2f,%.2f]',iur,RAIU_24h,left_density,right_density);
fprintf('%s\n',result);
result = sprintf('[%s]\t [vol=%.2fml]',dcminfo.PatientName.FamilyName,vol);
fprintf('%s\n',result);

% - histogram
histogram = imgHistogram(dcmfile.*mask);
if isDebug
%    subplot(2,2,4);
    axes(handles.axes4);
    bar(histogram,0.8);
    title(result);
end

if ret ==0
data = ['ndicomid=',tempjson.ID,'&id=', sid, '&area=', num2str(area),'&left_area=', num2str(left_area), '&right_area=',num2str(right_area), '&vol=',...
    num2str(vol),'&left_vol=', num2str(left_vol), '&right_vol=', num2str(right_vol), '&weight=', num2str(weight), '&left_weight=',...
    num2str(left_weight), '&right_weight=', num2str(right_weight), '&left_depth=', num2str(left_depth), '&right_depth=', num2str(right_depth),...
    '&left_tiur=', num2str(left_iur), '&right_tiur=',num2str(right_iur),'&therapy_bq=',num2str(therapy_bq),'&aquization_duration=',num2str(aquization_duration),...
    '&raiu_2h=',num2str(RAIU_2h),'&raiu_24h=',num2str(RAIU_24h)];
else
    disp('return = 1')
end

log3 = fopen('logfile3.txt','w');
fprintf(log3, '%s\n','position 3');
fprintf(log3, 'tempjson ID is %s\n', tempjson.ID);
fprintf(log3, '%s\n', data);
fclose(log3);

response = webwrite(urlChar, data);


log4 = fopen('logfile4.txt','w');
fprintf(log4, '%s\n','position 4');
tempjson = loadjson(response);
fprintf(log4, '%s\n', tempjson.status);
fprintf(log4, '%s\n', tempjson.msg);
fprintf(log4, 'area is %s\n', num2str(area));
fprintf(log4, 'volume is %s\n',num2str(vol));
fprintf(log4, 'weight is %s\n',num2str(weight));
fclose(log4);
disp(response);

%write figure1 to image
%imgsc = [dcmname '_fg.jpg'];
%print(fig,imgsc,'-djpeg');


fprintf('duration=%.2fs\n------ finished ------\n ',etime(t_end,t_begin));

  


   




