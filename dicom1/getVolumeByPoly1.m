function vol=getVolumeByPoly1(dcminfo,im,iur)
   k = 8.776;
   b = 11.76;
   try
       temp = dcminfo.ActualFrameDuration;
   catch
        warning('dcminfo ActualFrameDuration lost!');
        info_error = fopen('dcminfo_error.txt','a+');
        fprintf(info_error, 'getVolumeByPoly1 function dcminfo ActualFrameDuration lost!');
        fclose(info_error);
        vol = 0;
        return;
   end
   x = sum(im(:))/iur / dcminfo.ActualFrameDuration; % BQ / time
   vol = k*x + b;

