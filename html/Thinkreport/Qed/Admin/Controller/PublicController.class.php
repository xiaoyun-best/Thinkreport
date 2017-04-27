<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller{
	public function login(){
	       C('LAYOUT_ON',false);	      
	       if($_POST){
	       	$ver=$this->check_verify($_POST['verify']);
	             if(!$ver)$this->error('验证码不正确');
	       	$username = $_POST['username'];
	       	$password  = $_POST['password'];
	       	$user=M('User')->where(" tbluser_loginname='$username' ")->find();
	       	if($user){
	       		if($user['tbluser_password']==md5($password)){
	       		    $menu=D('Rolenode')->getRolenodeMenu($user['tbluser_rid']);
	       		    session('menu',$menu);
                    session('admin',$user['tbluser_loginname']);
	       			session('user',$user);
	       			session('qedLogin',1);
	       			$this->success('登录成功',U('Index/index'));
	       		}else{
	       			$this->error('密码不正确');
	       		}
	       	}else{
	       		$this->error('用户名不正确');
	       	}
	       }else{
	             $this->display();
	       }	       
	 }
    public function verify(){
        ob_clean();
        $Verify = new \Think\Verify();
        $Verify->fontSize =15;
        $Verify->fontttf = '5.ttf';
		$Verify->length   = 4;
		$Verify->useNoise = false;
        $Verify->entry();
	}
	//检测验证码是否正确
	private function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}
	public function loginout(){
		session(null);
		$this->redirect('Public/login');
	}
	public function editpsd(){		
		if($_POST){
			$oldpwd		= trim($_POST['oldpwd']);
			$newpwd		= trim($_POST['newpwd']);
			$renewpwd		= trim($_POST['renewpwd']);
			if($_SESSION['user']['tbluser_password']==md5($oldpwd)){
				if($newpwd==$renewpwd){
					//dump($_SESSION);die;
					$id=$_SESSION['user']['tbluser_id'];
					$pwd=md5($newpwd);
					$re=M('User')->where('tbluser_ID='.$id)->setfield('tbluser_password',$pwd);
					//$data=M('User')->where('tbluser_ID='.$id)->find();
					//dump($data);					
					if($re){
						$_SESSION['user']['tbluser_password']=$pwd;
						$this->success('修改成功！！！');
					}
					
				}else{
				      $this->error('两次新密码不一致');
				}

			}else{
				$this->error('原密码不正确');
			}

		}else{
			$this->display();
		}		
	}
	public function checkpwd(){
		$oldpwd=$_POST['oldpwd'];
		if($_SESSION['user']['tbluser_password']==md5($oldpwd)){
			$data['status']=1;
		}else{
			$data['status']=0;
		}
		//echo json_encode($data);
		$this->ajaxReturn($data);
	}
		
}