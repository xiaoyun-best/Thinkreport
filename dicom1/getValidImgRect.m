function rect = getValidImgRect(im)
    histogram = imgHistogram(im);
    len = size(histogram,2);
    
    threshold = 0.25; % experiment is 0.30 ~ 0.35
    maxdata = max(im(:)) * threshold;
    maskimg = im>maxdata;
    
    % get rect margin
    cols = sum(maskimg);
    rows = sum(maskimg');
    
    for i = 1:size(cols,2)
        if cols(i) > 0
            rect(1) = i;
            break;
        end;
    end;

    for i = size(cols,2):-1:1
        if cols(i) > 0
            rect(3) = i - rect(1);
            break;
        end;
    end;

    for i = 1:size(rows,2)
        if rows(i) > 0
            rect(2) = i;
            break;
        end;
    end;

    for i = size(rows,2):-1:1
        if rows(i) > 0
            rect(4) = i - rect(2);
            break;
        end;
    end;