<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * create by Nobup
 * e-mail mail@vekwu.com
*/
class RbacController extends CommonController {

    public function listUser(){
        $page = I('get.page',1);
        if(!is_numeric($page))
            $this->error("分页请求错误!");
        $page = intval($page);
        $users = M('user_member');
        $user_count = $users->count();
        $result = $users->page($page,10)->select();
        $filter = array();
        $resultFiltered = array();
        if(checkSuperUser()){
            $filter = array('real_name', 'gender', 'email', 'stu_num', 'stu_idcard', 'phone');//phone 字段数据库没有，待添加。
        }else{
            $filter = array('real_name', 'gender', 'email', 'stu_num');
        }
        foreach ($result as $key => $value){
            $resultFiltered[$key] = $this->arrayFilter($value, $filter, false);
        }
        $result = array('count' => $user_count, 'every_page_num' => 10) + $resultFiltered;
        $this->ajaxReturn(json_encode($result));

    }

    /**
     * 取得管理员列表，需要超级管理员权限
     */
    public function listAdminUser(){
        if(!checkSuperUser()){
            $this->error('你不是超级管理员');
            return;
        }
        $page = I('get.page',1);
        if(!is_numeric($page))
            $this->error("分页请求错误!");
        $page = intval($page);
        $users = M('admin_user');
        $user_count = $users->count();
        $result = $users->page($page,10)->select();
        $filter = array();
        $resultFiltered = array();
        $filter = array('real_name', 'gender', 'email', 'stu_num', 'stu_idcard', 'phone');//phone 字段数据库没有，待添加。
        foreach ($result as $key => $value){
            $resultFiltered[$key] = $this->arrayFilter($value, $filter, false);
        }
        $result = array('count' => $user_count, 'every_page_num' => 10) + $resultFiltered;
        $this->ajaxReturn(json_encode($result));
    }

    /**
     * 增加管理员，需要超级管理员权限
     */
    public function addAdminUser(){
		if(!checkSuperUser()){
			$this->error('你不是超级管理员');
			return;
		}
		$data = array('stu_num' => I('post.stu_num'),
						'email' => I('post.email'),
						'real_name' => I('post.real_name'),
						'gender' => I('post.gender')
					);
		//验证提交内容是否为空
		foreach($data as $value){
			if(empty($value)){
				$this->ajaxReturn('null');
				return;
			}
		}

		$user = M('user_member');
		$result = $user->where(array('stu_num' => $data['stu_num']))->find();// 是否需要属于user_member里的数据
		if(!$result){
			$this->ajaxReturn('nouser');
			return;
		}
		$admin_user = M('admin_user');
		$result = $admin_user->add($data);
		if($result){
			$this->ajaxReturn('ok');
		}else{
			$this->ajaxReturn('fail');
		}
    }

    /**
     * 删除管理员，需要超级管理员权限
     */
    public function delAdminUser(){
        if(!checkSuperUser()){
            $this->error('你不是超级管理员');
            return;
        }
        $condition = array('stu_num' => I('post.stu_num'));
        $user = M('admin_user');
        $result = $user->where($condition)->delete();
        if($result){
            $this->ajaxReturn('ok');
        }else{
            $this->ajaxReturn('fail');
        }
    }

	/**
	 * 增加用户，需要超级管理员你权限
 	*/
	public function addUser() {
		if (!checkSuperUser()) {
			$this->ajaxReturn('un_authed');
			return;
		}
		$real_name = I('post.name');
		$gender = I('post.gender');
		$stu_num = I('post.stuid');
		$phone = I('phone');
		$id_card = I('id_card');
		$email = I('e_mail');

		if (empty($stu_num)) {
			$this->ajaxReturn('1');// 学号为空
			return;
		}

		if (empty($real_name)) {
			$this->ajaxReturn('2');// 姓名为空
			return;
		}

		$data = array(
			'stu_num' => $stu_num,
			'real_name' => $real_name,
			'gender' => $gender,
			'stu_idcard' => $id_card,
			//'phone' => $phone, //当前数据表中无此字段
			'email' => $email
		);
		$user = M('user_member');
		$result = $user->add($data);
		if ($result) {
			$this->ajaxReturn('ok');
			return;
		} else {
			$this->ajaxReturn('fail');
			return;
		}
	}

	/**
	 * 编辑用户，需要超级管理员权限
	 */
	public function editUser(){
		if(!checkSuperUser()){
			$this->ajaxReturn('un_authed');
			return;
		}
		$real_name = I('post.name');
		$gender = I('post.gender');
		$stu_num = I('post.stuid');
		$phone = I('phone');
		$id_card = I('id_card');
		$email = I('e_mail');

		if(empty($stu_num)){
			$this->ajaxReturn('1');// 用户名为空
			return;
		}

		$data = array(
			'real_name' => $real_name,
			'gender' => $gender,
			'stu_idcard' => $id_card,
			//'phone' => $phone, //当前数据表中无此字段
			'email' => $email
		);
		$condition = array('stu_num' => $stu_num);

		$user = M('user_member');
		$result = $user->where($condition)->save($data);
		if($result){
			$this->ajaxReturn('2');//更新成功
			return;
		}else{
			$this->ajaxReturn('3');//更新失败
			return;
		}
	}

	/**
	 * 删除用户，需要超级管理员权限
	 */
	public function delUser(){
		if(!checkSuperUser()){
			$this->ajaxReturn('un_authed');
			return;
		}
		$stu_num = I('post.stu_num');
		$user = M('user_member');
		$condition = array('stu_num' => $stu_num);
		//此处两种方法删除用户，推荐第二种软删除，但是数据库需要增加字段.
		$result = $user->where($condition)->delete();
		//$result = $user->where($condition)->save('is_delete=1');
		if($result){
			$this->ajaxReturn('ok');
			return;
		}else{
			$this->ajaxReturn('fail');
			return;
		}

	}

	/**
	 * 搜索用户
	 */
	public function searchUser(){
		$type = I('post.type','name');
		$search_content = I('post.search','');
		if(empty($search_content)){
			$this->ajaxReturn("请输入内容!");
			return;
		}
		$type_array = array('name','stuid','phone','identity');
		if(!in_array($type,$type_array))
			$type = 'name';

		$user = M('user_member');
		switch($type){
			case 'name':
				$type = 'real_name';
				break;
			case 'stuid':
				$type = 'stu_num';
				break;
			case 'phone':
				$type = 'phone';
				break;
            case 'identity':
                $type = 'stu_idcard';
                break;
			default:
				$type = 'name';
				break;
		}

		$condition = array($type => array('like','%'.$search_content.'%'));
		$result = $user->where($condition)->select();
        $filter = array();
        $resultFiltered = array();
        if(checkSuperUser()){
            $filter = array('real_name', 'gender', 'email', 'stu_num', 'stu_idcard', 'phone');//phone 字段数据库没有，待添加。
        }else{
            $filter = array('real_name', 'gender', 'email', 'stu_num');
        }
        foreach ($result as $key => $value){
            $resultFiltered[$key] = $this->arrayFilter($value, $filter, false);
        }
        $this->ajaxReturn($resultFiltered);
	}

    private function arrayFilter($arrayData, $filter, $mode = true){
        $arrayResult = array();
        foreach ($arrayData as $key => $value){
            if(!in_array($key, $filter))
                continue;
            if($mode && empty($value))
                continue;
            $arrayResult[$key] = $value;
        }
        return $arrayResult;
    }

}
?>
