<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function  _initialize(){
    	if($_SESSION['qedLogin'] != 1){
            $this->redirect('Public/login');exit;
        }
    }

   function alert($msg,$url){
	echo "<script>alert('".$msg."');window.location.href='".$url."'</script>";exit;
   }
}