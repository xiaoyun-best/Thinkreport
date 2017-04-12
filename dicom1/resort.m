function [ rect] = resort( xmin, ymin, xmax, ymax )

width = xmax - xmin;
height = ymax - ymin;
rect(1) = xmin;
rect(2) = ymin;
rect(3) = width;
rect(4) = height;


end

