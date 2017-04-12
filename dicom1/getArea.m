%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% calc area
function area = getArea(dcminfo,im)
    mask = size(find(im~=0),1);
    try
        temp=dcminfo.PixelSpacing(1);
    catch
        warning('dcminfo pixelspace lost!');
        info_error = fopen('dcminfo_error.txt','a+');
        fprintf(info_error, 'getArea function dcminfo PixelSpace lost!\n');
        fclose(info_error);
        area = 0;
        return;
    end
    area = mask*dcminfo.PixelSpacing(1) * dcminfo.PixelSpacing(2);

