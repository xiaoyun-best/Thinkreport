
% power function regress

clear,clc;

% accumulated Bq value
time=[37933     209494  209494  96138   96206   48144 ...
      48144     85763   85763   64204   63985];
%imageBq
Bq  =[510442    510503  510503  511377  511489  510351 ...
      510351    511771  511771  511222  510643];
%validBq
vBq =[413396    373900  373900  373541  375286  362244  ...
      362244    416119  416119  400485  385712];

% real volume
v=[100 20 20 30 40 60 60 70 70 80 90];           %y:real vol

c = Bq ./ time ./ v;

%a=lsqcurvefit(fun,a0,x,v);

%cftool(time,vBq,v);