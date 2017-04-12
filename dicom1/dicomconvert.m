function ret = dicomconvert(filename)

%/disp(filename);

%fileID = fopen('exp.txt','w');
%fprintf(fileID,'s%',filename);
%fclose(fileID);  

if isequal(filename, 0)
    disp('Image input canceled.');  
else
[X,MAP]=dicomread(filename);
image8 = uint8(255 * mat2gray(X));
imwrite(image8,'myfile.png', 'png');% Save Image as png format
end;

ret = 11
end