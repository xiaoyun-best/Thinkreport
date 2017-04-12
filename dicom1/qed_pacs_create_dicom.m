function [ ret,retinfo ] = qed_pacs_create_dicom( data,file_struct, Old_dicominfo)
%QED_PACS_crerateDICOM : create data into dicom format file
%   data : image pure data, uint8 or uint16
%   file_struct : some dicom header infor to be changed (can be empty)
%       .dcmname : dicom file name with path
%       [.PatientID]
%       [.PatientName] : (for FamilyName)
%       [.StudyID]

ret = 1;
retinfo = 'unknown';

%% check data tyep
if ~isa(data,'uint16') && ~isa(data,'uint8')
    retinfo = 'data must be uint8 or uint16';
    disp(retinfo);
    return;
end;

imgsize = size(data);
if length(imgsize) ~= 2 
    if length(imgsize) ~= 3
        retinfo = 'data must be 2D or 2D-rgb matrix';
        disp(retinfo);
        return;
    elseif imgsize(3) ~= 3
        retinfo = 'Dim 3 must be rgb series';
        disp(retinfo);
        return;
    end;
end;
    
if ~exist('file_struct','var')
    retinfo = 'file_struct.dcmname must be inputed';
    disp(retinfo);
    return;
elseif ~isfield(file_struct,'dcmname')
    retinfo = 'file_struct.dcmname must be inputed';
    disp(retinfo);
    return;
end;

%% create dicom file
try
        dicomwrite(data, file_struct.dcmname,'CreateMode','Create');
        dcminfo = dicominfo(file_struct.dcmname);
        
        %Manufacturer
        dcminfo.SecondaryCaptureDeviceManufacturer = 'QED';
        dcminfo.SecondaryCaptureDeviceManufacturerModelName='BIONALYX';
        dcminfo.StationName = 'BIONALYX';
        dcminfo.Manufacturer = 'QED';
        
        %Image
        tm = fix(clock);
        dcminfo.StudyDate = sprintf('%4d%02d%02d',tm(1),tm(2),tm(3));
        dcminfo.SeriesDate = dcminfo.StudyDate;
        dcminfo.StudyTime = sprintf('%02d%02d%02d',tm(4),tm(5),tm(6));
        dcminfo.SeriesTime = dcminfo.StudyTime;
        
        if isfield(file_struct,'PatientID')
            dcminfo.PatientID = file_struct.PatientID;
        end;
        if isfield(file_struct,'StudyID')
            dcminfo.StudyID = file_struct.StudyID;
        end;
        if isfield(file_struct,'PatientName')
            dcminfo.PatientName.FamilyName = file_struct.PatientName;
        end;
        dcminfo.StudyID = Old_dicominfo.StudyID;
        dcminfo.StudyInstanceUID = Old_dicominfo.StudyInstanceUID;
        dcminfo.SeriesInstanceUID = Old_dicominfo.StudyInstanceUID;
        

        dcm = dicomread(dcminfo);
        dicomwrite(dcm, file_struct.dcmname, dcminfo, 'CreateMode','Copy');

catch ME
    retinfo = ['create dicom err : ', file_struct.dcmname];
    disp(retinfo);
    return;
end;

ret = 0;

