function [ ret,retinfo ] = qed_pacs_upload_dicom( dicom_filename,url )
%QED_PACS_UPLOADDICOM : upload a dicom file
%   dicom_filename : a dicom file name string
%   url : upload url ('http://192.168.1.125:8042/instances' e.g.)

ret = 1;
retinfo = 'unknown';

%% upload dicom file to url
try
    f = fopen(dicom_filename,'r');
    dcm = fread(f,Inf,'*uint8');
    fclose(f);
    
    retinfo = urlreadpost(url,{'file',dcm});
    disp(retinfo);
    
catch ME
    retinfo = ['Upload URL err : ', url, ...
               ' with filename : ', dicom_filename];
    disp(retinfo);
    return;
end;

ret = 0;
