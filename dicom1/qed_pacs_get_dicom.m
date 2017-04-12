function [ret,retinfo] = qed_pacs_get_dicom( dicom_url )
%QED_PACS_GETDICOM : get a dicm file from web
%   and save to dcm format in local disk
%
%   dicom_url : an URL sting ('http://192.168.1.125:8042/.../' e.g.)
%   ret : 0 - success, with temp file name info
%         1 - error, with error info

ret = 1;
retinfo = 'unknown';

%% open dicom file from url
try
    filedata = webread(dicom_url);
    
    
catch ME
    retinfo = ['Open URL err : ', dicom_url];
    info_error = fopen('dcminfo_error.txt','a+');
    fprintf(info_error, 'Open URL err: ');
    fclose(info_error);
    return;
end;

%% save dicom file to current dir with fixed temp-filename
try
    temp = './temp.dcm';
    f = fopen(temp,'w');
    fwrite(f, filedata);
    fclose(f);
    
catch ME
    retinfo = ['Write temp file err : ', temp];
    return;
end;

%% successful
ret = 0;

