<?php
namespace app\admin\controller;
use app\admin\model\ManageUser;
use app\admin\controller\Base;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;

class Login extends Controller
{
	public function index()
    {
    	if(!Session::has('username')){
    		// dump(session('username'));
			echo "session null";
			// die;
		}
        return $this->fetch();
    }
	
	public function checkLogin($username='',$password='')	//登陆检测
	{
		// dump(input('post.'));
		$result = Manageuser::where('username', $username)->find();
		$passok = password_verify($password,$result["password"]);
		if($result){
			
			if($passok == true){
				
				if($result["status"]=="y"){
					$msg["status"] = "true";
					//如果管理员ID=1则设置以下Session
					if ($result['id'] == 1) 
					{
					Session::set('id',$result["id"]);
                    Session::set('username',$result["username"]);
					Session::set('logintime',time());	//设置session开始时间
					Session::set('last_login_ip',$this->request->ip());
					// Session::delete('username',$result["username"]);
					// $this->success('Session设置成功');
					$msg["message"] = "登录成功"; 
					// $this->success("登录成功",U('Index/index'));
					// 保存登录信息
					$username = $_POST['username'];
					$update['username'] = $username;
					$update['content'] = "管理员后台登录账户";
			        $update['last_login_time'] = time();
			        $update['last_login_ip'] = $this->request->ip();
			        $update['login_status'] = "1";
			        $time['last_login_time'] = time();
			        //保存登录信息
			        Db::name("ManageUser")->where('username','=',$username)->update($time);
			        //保存登录日志
			        Db::name("SystemLog")->insert($update);
			        //登录成功后跳转到后台首页
					$this->redirect('./admin/index');
                	}

				}else{
					$msg["status"] = "false";  
					$msg["message"] = "账号被锁定，请联系管理员！";  
				}
				
			}else{
				$msg["status"] = "false"; 
				$msg["message"] = "密码错误"; 
				$update['username'] = $_POST['username'];
				$update['content'] = "密码" .$_POST['password']. "错误";
		        $update['last_login_time'] = time();
		        $update['last_login_ip'] = $this->request->ip();
		        $update['login_status'] = "2";
		        Db::name("SystemLog")->insert($update);
			}

		}else{
			$msg["status"] = "false";  
            $msg["message"] = "账号不存在，请联系管理员";
            $update['username'] = $_POST['username'];
			$update['content'] = "密码" .$_POST['password']. "错误";
	        $update['last_login_time'] = time();
	        $update['last_login_ip'] = $this->request->ip();
	        $update['login_status'] = "3";
	        Db::name("SystemLog")->insert($update);
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);  
		// die();
		// session('username',null); // 删除session
	}
	
	public function logout(){
		// 取值并删除Session
        // Session::pull('username');
        // 设置session为null
        $del = Session::delete('username');
        $del = Session::delete('id');
        $nul = Session('username',null);
        $nul = Session('id',null);
        if ($del) {
        	$this->redirect('../../');
        	// echo "1";
        }elseif ($nul) {
        	$this->redirect('../../');
        }
        echo "2";
        // die;
        // dump(session('username'));
        // session('username',null);
        // Session::delete('username');
        //跳转到后台首页
        // $this->redirect('.');
        //跳转到网站首页
        $this->redirect('../../');
    }


	
	//视图显示
    public function Login($username='',$password='')
	{
		echo Session::get('username');
		echo "</br>";
		echo "密码";
		echo "</br>";
		// $result = Manageuser::get([
		// 'username'=>$username,
		// 'password'=>$password
		// ]);
		$hash = password_hash($password, PASSWORD_BCRYPT);
		echo "$hash";
		
		// $PHPASS = new password_hash(8, true);
		$password = $PHPASS->password_hash($password);
		$userData['password'] = $password;
		
		if (password_verify($password,'$2y$10$rH5nwLWoGo/mSWwQZS0gH.9ic2UDaMTgmPe.ac3BP5BownWAkGdp6')) 
		{ 
			echo "密码正确";
			echo '</br>';
			echo $hash;
		} else {  
			// return $this->error('登录失败');
			echo $hash;
		}

	
		
    }
	// $hash = password_hash($password, PASSWORD_BCRYPT);
	// password_verify (string $password , string $hash)
	// 
	// echo $hash;
	
	
	
	
	/**
     * 登录验证
     */
    // public function Check_Login(){
        ////验证码检测
       // $names=$_POST['Captcha'];
        // if($this->check_verify($names)==false){
            // $data['error']=1;
            // $data['msg']="验证码错误";
            // $this->ajaxReturn($data);
        // }
        ////用户检测
        // $uname=I('post.username');
        // $upasswd=I('post.password');
        // $map['uname']=$uname;
        // $map['state']=1;
        // $logins=M('login')->where($map)->find();
        // if($logins)
        // {
            // if($logins['upasswd']!=$upasswd)
            // {
                // $data['error']=1;
                // $data['msg']="密码错误";
                // $this->ajaxReturn($data);
            // }
            // session("admin",$logins);
 
            // var_dump($logins);
           // redirect(U('Index/index'));
        // }
    // }
 
    /**
     * 验证码生成
     */
    public function Verifys()
    {
        $config=array(
            'fontSzie'	=>30,	//验证码字体大小
            'length'	=>3,	//验证码位数
            'useImgBg'	=>true, //验证码背景
			'useNoise'  =>false //验证码杂点
 
        );
 
        $captcha=new Captcha();
        $captcha->useZh=true;
 
        $captcha->zhSet="梦起软件工作室";
		$captcha->fontttf = '5.ttf'; 
        $captcha->entry();
 
    }
 
    /**
     * 验证码检测
     */
    public function check_verify($code,$id="")
    {
		$captcha = new Captcha();
		return $captcha->check($code, $id);
    }
    /**
     * 退出登录
     */
    // public function out_login(){
        // session("admin",null);
        // redirect(U('Login/login'));
    // }
}