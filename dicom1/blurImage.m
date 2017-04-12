% blur image
function blurIm = blurImage(im)
    num_iter = 10;
    delta_t = 1/8;
    kappa = 20;
    option = 1;
    blurIm = anisodiff(im,num_iter,delta_t,kappa,option);

