<?php
namespace app\admin\controller;

use app\admin\model\User as UserModel;  //载入模型 并设置别名
use app\admin\model\Manageuser;
use app\admin\model\Articlelist;
use app\admin\model\Articlelistsortid;
use think\Controller;
use think\Db;

class Index extends Controller
{
	
	public function index()
    {
        return $this->fetch();
    }
	
	public function index1()
    {
        return $this->fetch();
    }
    
	public function welcome()
    {
        return $this->fetch();
    }
	
	public function picture_list()        //WdatePicker日历控件报错
    {
		$start_time = '';
		$end_time   = '';
		
		$this->assign([
		'start_time' => $start_time,
		'end_time'   => $end_time
		]);
        return $this->fetch();
    }
	
	public function product_brand()
    {
        return $this->fetch();
    }
	
	public function product_category()
    {
        return $this->fetch();
    }
	
	public function product_category_add()
    {
        return $this->fetch();
    }
	
	public function feedback_list()
    {
        return $this->fetch();
    }
	
	public function member_list()
    {
        return $this->fetch();
    }
	
	public function member_del()
    {
        return $this->fetch();
    }
	
	public function member_level()
    {
        return $this->fetch();
    }
	
	public function member_scoreoperation()
    {
        return $this->fetch();
    }
	
	public function member_record_browse()
    {
        return $this->fetch();
    }
	
	public function member_record_download()
    {
        return $this->fetch();
    }
	
	public function member_record_share()
    {
        return $this->fetch();
    }
	
	public function admin_role()
    {
        return $this->fetch();
    }
	
	public function admin_permission()
    {
		$db1 = db('manage_user');
		$result = $db1->select();
		dump($result);
        return $this->fetch();
    }
	
	public function admin_list()   //管理员列表
    {
		$result = Manageuser::all();
		$this->assign('result',collection($result)->append(['role1'])->toArray());
		return $this->fetch();
    }
	
	public function charts_1()
    {
        return $this->fetch();
    }
	
	public function charts_2()
    {
		$user = UserModel::get($id);
		echo $user['id'] . '<br/>';
		echo $user['username'] . '<br/>';
		echo $user['phone'] . '<br/>';
		echo $user['email'] . '<br/>';
		echo $user['role'] . '<br/>';
		echo $user['status'] . '<br/>';
		echo $user['description'] . '<br/>';
		echo date('Y/m/d', $user['last_login_time']) . '<br/>';
        return $this->fetch();
    }
	
	public function charts_3()
    {
        return $this->fetch();
    }
	
	public function charts_4()
    {
        return $this->fetch();
    }
	
	public function charts_5()
    {
        return $this->fetch();
    }
	
	public function charts_6()
    {
        return $this->fetch();
    }
	
	public function charts_7()
    {
        return $this->fetch();
    }
	
	public function system_base()
    {
        return $this->fetch();
    }
	
	public function system_category()
    {
        return $this->fetch();
    }
	
	public function system_data()
    {
        return $this->fetch();
    }
	
	public function system_shielding()
    {
        return $this->fetch();
    }
	
	public function system_log()
    {
        return $this->fetch();
    }
	
	public function product_list()
    {
        return $this->fetch();
    }
	
	public function article_add()
    {
        return $this->fetch();
    }
	
	public function picture_add()
    {
        return $this->fetch();
    }
	
	public function product_add()
    {
        return $this->fetch();
    }
	
	public function member_add()
    {
        return $this->fetch();
    }
	
	public function article_list()	//文章列表页
	{
		$result = Articlelist::where('checked','=','y')->order('id', 'asc')->select();
		$this->assign('result',collection($result)->append(['status1','sortid1'])->toArray());
		// $relation = $result->books;
		// $this->assign('result',collection($relation)->toArray());
		
		//获取分类
		// $user = Articlelistsortid::all();
		 // $books = $user->books;
		 // dump($books);
		// return $this->hasOne('Articlelistsortid','sortid','sid',['title'=>'pid','type'=>'alias']);
		return $this->fetch();
		// dump($result->profile);
	}
	
	public function article_zhang()	//文章详情页
    {
		$data = Db::name('article')->find();
        $this->assign('result', $data);
        return $this->fetch();
		
        // return $this->fetch();
    }

	

}


