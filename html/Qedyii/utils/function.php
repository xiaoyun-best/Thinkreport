<?php
/**
 * Created by PhpStorm.
 * User: ddxs
 * Date: 17-2-10
 * Time: 上午11:03
 */
//判断是否为json
function is_json($string){
    json_decode($string);
    return (json_last_error()==JSON_ERROR_NONE);
}
//建立日志文件
function mk_log($param,$filename){
    error_log(print_r($param,1).date('Y-m-d H:i:s',time())."\r\n",3,dirname(dirname(__FILE__)).'/'.$filename);
}
/*function execon($modname,$param){
    //执行进程
    $somecontent= "cd /var/www/html/dicom &&";
    $somecontent .="./Midware ".$modname." "." ' ".$param." ' ";
    mk_log($somecontent,'somecontent.txt');
    $re=exec($somecontent,$out,$status);
    $res['out']=$out;
    $res['status']=$status;
    return($res);
}*/
function execon($modname,$param){
    //执行进程
    $somecontent="./Midware ".$modname." "." ' ".$param." ' ";
    mk_log($somecontent,'somecontent.txt');
    $con=chdir('/var/www/dicom');
    $re=shell_exec($somecontent);
    return($re);
}
function exeres($modname,$param){
    //执行进程
    $somecontent="./Midware ".$modname." "." ' ".$param." ' ";
    mk_log($somecontent,'somecontent.txt');
    $con=chdir('/var/www/dicom1');
    $re=shell_exec($somecontent);
    return($re);
}
