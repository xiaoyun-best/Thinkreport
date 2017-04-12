function [leftmask, rightmask, spx]=SeperationLR(svmmask0);

rightmask = zeros(size(svmmask0));
leftmask = zeros(size(svmmask0));
    for i = 1: size(svmmask0, 2)
        if isempty(find(svmmask0(i, :)==1) )
            indexy(i) = 0;
        else
            indexx(i) = mean(find(svmmask0(i, :)==1));
            indexx1_max(i) = max(find(svmmask0(i, :)==1));
            indexx1_min(i) =   min(find(svmmask0(i, :)==1));
        end
    end
    for i = 1: size(svmmask0, 1)
        if isempty(find(svmmask0(:, i)==1) )
            indexy(i) = 0;
        else
            indexy(i) = mean(find(svmmask0(:, i)==1));
            indexy1_max(i) = max(find(svmmask0(:, i)==1));
            indexy1_min(i) =   min(find(svmmask0(:, i)==1));
        end
    end
    tempx(1) = mean(indexx(find(indexx)));
    tempy(1) = mean(indexy(find(indexy)));
    tempx(2) = (max(indexx1_max(find(indexx1_max))) + min(indexx1_min(find(indexx1_min))))/2.0;
    tempy(2) = (max(indexy1_max(find(indexy1_max))) + min(indexy1_min(find(indexy1_min))))/2.0;
    minimum = 100;
    for i = round(tempx(1)) - 10 : 1 : round(tempx(1)) + 10
        length = sum(svmmask0(:, i));
        if(minimum > length)
            minimum = length;
            tempx(3) = i;
            tempy(3) = tempy(1);
        end
    end
    
%    imagesc(svmmask0); colormap(gray);  
%    scatter(tempx(1), tempy(1), 'ro')
%    scatter(tempx(2), tempy(2), 'bo')
%    scatter(tempx(3), tempy(3), 'rd')
    spx = round(mean(tempx)); spy = round(mean(tempy));
    
    
    for i = 1: size(svmmask0, 2)
        if(i < spx)
            rightmask(:, i) = svmmask0(:, i);
        end
        if(i > spx)
            leftmask(:, i) = svmmask0(:, i);
        end
    end
    
end