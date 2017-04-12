function called = chg_called_json( json_str )
%CHG_CALLED_JSON : change called json params to matlab structs
%   json_str will have {dicomid,tiur,coord,url}

called = loadjson(json_str);

called.coord = str2num(called.coord);
called.left_density = str2num(called.left_density);
called.right_density = str2num(called.right_density);
called.raiu_2h = str2num(called.raiu_2h);
called.raiu_24h = str2num(called.raiu_24h);
called.AIU = str2num(called.AIU);

end

