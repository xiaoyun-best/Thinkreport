function [ ret,retinfo,mix_img ] = qed_img_mask2contour( mask, img, maxvalue )
%QED_IMG_MASK2CONTOUR Summary of this function goes here
%   mask: 2D mask matrix (full with 0 and max)
%   img : 2D img matrix, must be same size as mask
%   maxvalue : max data value in image (255,65535, e.g.)

ret = 1;
retinfo = '';

masksize = size(mask);
imgsize  = size(img);

if sum(masksize==imgsize)~=2 % 2D (col and row) ara equred
    retinfo = 'matrix not in same size';
    disp(retinfo);
    return;
end;

imgcontour = bwperim(mask,4) .* maxvalue;

mix_img = max(imgcontour, img);
ret = 0;

end

