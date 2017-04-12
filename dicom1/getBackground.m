% calc Volume of SPECT PS image with  p00 + p10*x + p01*y + p20*x^2 + p11*x*y + p02*y^2
function bg=getBackground(im,rect,svmmask)
    rectSvmmask = svmmask(rect(1):(rect(3)+rect(1)-1),rect(2):(rect(4)+rect(2)-1));
    rectMask = ones(rect(3),rect(4));
    rectMask = xor(rectSvmmask,rectMask);

    rectData = im(rect(1):(rect(3)+rect(1)-1),rect(2):(rect(4)+rect(2)-1));
    rectData = rectData .* rectMask;
    
    bg = max(rectData(:)) * 0.30;

