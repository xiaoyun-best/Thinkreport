function histogram = imgHistogram(im)
    maxdata = max(im(:)) - min(im(:));
    histep  = ceil(maxdata/10);
    step    = uint16(maxdata/histep);
    histogram = zeros(1,step+1);

    for i=1:step
        histogram(i) = length(find(im<(maxdata/step*i) & im>=(maxdata/step*(i-1)) & im>0));
    end;
    histogram(step+1) = length(find(im>=maxdata));
end
