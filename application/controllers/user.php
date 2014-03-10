<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 第三方登入
 * @author lgm
 */
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');

    }

    public function index(){
        $post_username = $this->input->post("user_name");
        $this->load->view('header.php');
        if(!$post_username){
            $all = $this->user->select_all(array());
        }else{
            $this->db->like('user_name',$post_username);
            $all = $this->user->select_all(array());
        }
        for($i=0;$i<count($all);$i++) {          //获取会所名称
            $this->load->model('club_model', 'club');
            $res = array_pop($this->club->select_club(array('club_id' => $all[$i]['club_id'])));
            if($res){
                $all[$i]['club_name'] = $res['club_name'];
            }else{
                $all[$i]['club_name'] = '无';
            }

        }
        $data['list'] = $all;
        $this->load->view("user.php",$data);

    }


    /*
     * 普通登入
     */
    public function login(){
        if(!$this->input->post("user_name")){
            echo json_encode(new Ret('no','用户名不能为空'));
            exit;
        }

        if(!$this->input->post('user_password')){
            echo json_encode(new Ret('no','密码不能为空'));
            exit;
        }

        $user_info = array(
            'user_name'=>$this->input->post('user_name'),
            'user_password'=>md5($this->input->post('user_password'))
        );
        if($return_info = $this->user->login($user_info)){
            //生成session
            $this->session->set_userdata('user_id',$return_info['id']);
           echo json_encode(new Ret('ok',$return_info));
        }else{
           echo json_encode(new Ret('no','登入失败'));
        }

    }





    /**
     * 普通注册用户
     */
    public function register() {


        if(!$this->input->post('user_name')) {
            echo json_encode(new Ret('no','用户名不能为空'));
            exit;
        }

        if($this->user->is_exists($this->input->post('user_name'))){
            echo json_encode(new Ret('no','用户名已经存在'));
            exit;
        }

        if(!$this->input->post('user_password')) {
            echo json_encode(new Ret('no','密码不能为空'));
            exit;

        }

        if($this->input->post('user_password') !== $this->input->post('confirm_psw')){
           echo json_encode(new Ret('no','密码不一致'));
            exit;
        }
        $data['user_name'] = $this->input->post('user_name');
        $data['user_password'] = md5($this->input->post('user_password'));
        $data['contact'] = $this->input->post('contact');
        $data['user_type'] = $this->input->post('user_type');
        $data['is_admin'] = '0';
        $data['create_time'] = date('Y-m-d H:i:s');
        $radom = $this->input->post('random');
        $baseurl = base_url();
        $rand = time();
    	$newfilename = ROOT.'uploads/userhead/'.$rand;
        if (file_exists(ROOT.'uploads/userhead/'.$radom.'.jpg')) {
        	rename(ROOT.'uploads/userhead/'.$radom.'.jpg',$newfilename.'.jpg') ;
        	$data['user_head'] = 'userhead/'.$rand.'.jpg';
        }elseif (file_exists(ROOT.'uploads/userhead/'.$radom.'.png')){
        	rename(ROOT.'uploads/userhead/'.$radom.'.png',$newfilename.'.png');
        	$data['user_head'] = 'userhead/'.$rand.'.png';
        }elseif (file_exists(ROOT.'uploads/userhead/'.$radom.'.gif')){
        	rename(ROOT.'uploads/userhead/'.$radom.'.gif',$newfilename.'.gif') ;
        	$data['user_head'] = 'userhead/'.$rand.'.gif';
        }else{
        	$data['user_head'] = 'userhead/default.jpg';
        }

        echo $this->user->register_user($data)?json_encode(new Ret('ok','注册成功')):json_encode(new Ret('no','注册失败'));
    }


    /*
     * 会所负责人
     * */
    public function club_register($id=''){
        $this->load->model('club_model','club');

        if(!$id) {
            echo json_encode(new Ret('no','请首先选择会所'));
            exit;
        }

        if(!$this->input->post('user_name')) {
            echo json_encode(new Ret('no','用户名不能为空'));
            exit;
        }

        if($this->user->is_exists($this->input->post('user_name'))){
            echo json_encode(new Ret('no','用户名已经存在'));
            exit;
        }

        if(!$this->input->post('user_password')) {
            echo json_encode(new Ret('no','密码不能为空'));
            exit;

        }
        if(!$this->input->post('phone')) {
            echo json_encode(new Ret('no','联系电话不能为空'));
            exit;

        }

        $true_name = $this->input->post('true_name');
        $phone = $this->input->post('phone');
        if(!$this->input->post('true_name')) {
            echo json_encode(new Ret('no','真是姓名不能为空'));
            exit;

        }


        if($this->input->post('user_password') !== $this->input->post('confirm_psw')){
            echo json_encode(new Ret('no','密码不一致'));
            exit;
        }


        if(!$this->club->select_club(array('club_manager'=>$true_name,'club_id'=>$id,'manager_phone'=>$phone))){
            echo json_encode(new Ret('no','与会所信息不符，请重新注册'));
            exit;
        }



        $data['user_name'] = $this->input->post('user_name');
        $data['user_password'] = md5($this->input->post('user_password'));
        $data['contact'] = $this->input->post('contact');
        $data['phone'] = $this->input->post('phone');
        $data['true_name'] = $this->input->post('true_name');
        $data['user_type'] = $this->input->post('user_type');
        $data['is_admin'] = '0';
        $data['club_id'] = $id;
        $data['create_time'] = date('Y-m-d H:i:s');
        $radom = $this->input->post('random');
        $baseurl = base_url();
        $rand = time();
        $newfilename = ROOT.'uploads/userhead/'.$rand;
        if (file_exists(ROOT.'uploads/userhead/'.$radom.'.jpg')) {
            rename(ROOT.'uploads/userhead/'.$radom.'.jpg',$newfilename.'.jpg') ;
            $data['user_head'] = 'userhead/'.$rand.'.jpg';
        }elseif (file_exists(ROOT.'uploads/userhead/'.$radom.'.png')){
            rename(ROOT.'uploads/userhead/'.$radom.'.png',$newfilename.'.png');
            $data['user_head'] = 'userhead/'.$rand.'.png';
        }elseif (file_exists(ROOT.'uploads/userhead/'.$radom.'.gif')){
            rename(ROOT.'uploads/userhead/'.$radom.'.gif',$newfilename.'.gif') ;
            $data['user_head'] = 'userhead/'.$rand.'.gif';
        }else{
            $data['user_head'] = 'userhead/default.jpg';
        }

        echo $this->user->register_user($data)?json_encode(new Ret('ok','注册成功')):json_encode(new Ret('no','注册失败'));
    }


    //json 修改密码
    public function new_pwd(){
        $uid = $this->input->post('uid');
        $user_password = $this->input->post('userpassword');
        if(!$this->user->select_all(array('id'=>$uid,'user_password'=>md5($user_password)))){
            echo json_encode(new Ret('no','密码不正确'));
            exit;
        }
        $data['user_password'] =md5( $this->input->post('newpassword'));
        if($this->user->update_user($data,$uid)){
            echo json_encode(new Ret('ok','修改成功'));
        }else{
            echo json_encode(new Ret('no','修改失败'));
        }

    }


    /*
     * logout
     */
    public function logout(){
        $this->session->unset_userdata("user_id");
        echo $this->session->userdata("user_id")?json_encode(new Ret('no','退出失败')):json_encode(new Ret('ok','退出成功'));

    }

    //添加管理员 show
    public function add_show(){
        $this->load->view("header.php");
        $this->load->view('edituser.php');
    }

    //添加管理员
    public function add_user(){
     if(!empty($_FILES['userhead']['name'])) { //上传图片
            $config = array(
                'upload_path' => 'uploads/userhead',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => time(),
                'max_size' => '500',
                'max_width' => '1024',
                'max_height' => '768',
            );
            $this->load->library('upload', $config);
        	if (!$this->upload->do_upload('userhead')) {
        		$this->session->set_flashdata('flashmessage', '头像上传失败');
                redirect('user');
                exit;
            }
            $data['user_head'] = 'userhead/'.$config['file_name'].'.'.$this->upload->get_ext();
        }
        $data['user_name'] = $this->input->post('username');
        $data['user_password'] = md5($this->input->post('userpassword'));
        $data['create_time'] = date('Y:m:d H-i-s',time());
        $data['is_admin'] = $this->input->post('is_admin');

        if($this->user->register_user($data)){
            $this->session->set_flashdata('flashmessage', '创建成功');
            redirect('user');
        }else{
            $this->session->set_flashdata('flashmessage', '操作失败');
            redirect('user');
        }
    }
    

    //会员人数
    public function user_count(){
        $all = $this->user->select_all(array());
        echo json_encode(new Ret('ok',count($all)));
    }

   /*
    * 后台管理，用户列表
    */
    public function getList(){
        echo json_encode($this->user->select_all(array('from' => 'general')));
    }

    /*
     * 某个会员的信息
     * @param $id
     */
    public function getOneInfo($id){
       echo json_encode($this->user->getInfoById($id));
    }
    /*
     * 修改管理员
     */
    public function update($id){
        $res = $this->user->getInfoById($id);
        $is_admin = $res['is_admin'];
        if($is_admin == '0'){
            $is_admin = '1';
        }else{
            $is_admin = '0';
        }
        $data['is_admin'] = $is_admin;
        echo $this->user->update_user($data, $id) ? true : false;

    }
    public function update_admin($id){
       $data['is_admin'] = $_POST['is_admin']; 
       if ($this->session->userdata('user_id') == $this->root_admin()){
	       	if ( $id != $this->session->userdata('user_id'))  {
		       if ($this->user->update_user($data, $id)){
		          $this->session->set_flashdata('flashmessage', '管理员更改成功');
		      	  redirect('Admin/user');
	       		}
	       }else{
	       		$this->session->set_flashdata('flashmessage', '您没有权限');
		      	redirect('Admin/user');
	       }
       }else{
       		$this->session->set_flashdata('flashmessage', '您没有权限');
	      	redirect('Admin/user');
       }
    }

    /*
     * 删除用户
     */
    public function delete($id){
       if($this->user->deleteById($id)==1){
            alert_location('删除成功',site_url('user'));
       }else{
           alert_location('删除失败',site_url('user'));
       }
    }

    public function delete_0($id){
        $data['id'] = $id;
        if ($this->session->userdata('user_id') == $this->root_admin()){
            if ( $id != $this->session->userdata('user_id'))  {
                $this->user->deleteById($id);
                $this->session->set_flashdata('flashmessage', '删除成功');
                redirect('Admin/user');
            }else{
                $this->session->set_flashdata('flashmessage', '您没有权限');
                redirect('Admin/user');
            }
        }else{
            $this->session->set_flashdata('flashmessage', '您没有权限');
            redirect('Admin/user');
        }
    }

    /*
     * 判断是否登入
     */
    public function is_login(){
        if($this->session->userdata('user_id')){
           $ret_ob = new ret('ok',
           array(
               "user_id"=>$this->session->userdata("user_id"),
               "user_name"=>$this->session->userdata("user_name"),
               "user_head"=>$this->session->userdata("user_head")
           )
           );
        }else{
            $ret_ob = new ret('no',
                array(
                )
            );
        }
        echo json_encode($ret_ob);
    }

    /*
    get_session
    */
    public function get_session($name){
        if($this->session->userdata($name)){
            echo $this->session->userdata($name);
        }
    }


    /*
     * upload profile
     */ 
	public function uploadimg($rand){    	
     	$file= $_FILES['filename'];    	
     	if (isset($file)){     		
     		 $config = array(
                'upload_path' => 'uploads/userhead',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => $rand,
                'max_size' => '500',
                'max_width' => '1024',
                'max_height' => '768',
            );
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('filename')) {
                echo '上传失败';
                exit;
            }
     	}
     }

    public function get_info_by_name($name){
        $this->user->get_info_by_name($name);
    }


    public function get_info_by_id($id){
        return $this->user->getInfoById($id);
    }


    //管理员登录验证
    public function admin_login(){
        $user_name = $_POST['username'];
        $user_password = $_POST['password'];
        $res = array_pop($this->user->select_all(array('user_name' => $user_name,'user_password' =>md5($user_password))));
        if($res['is_admin'] == '1'){
            $this->session->set_userdata('user_id', $res['id']);
            redirect('index/index');
        }else{
        	$this->session->set_flashdata('flashmessage', '登陆失败');
            $this->load->view('login');
        }
    }

    public function admin_login_return(){
        $this->load->view('login');
    }

    //管理员退出
    public function admin_logout(){
        $this->session->unset_userdata("user_id");
        if($this->session->userdata('user_id')){
            $this->session->set_flashdata('flashmessage', '退出失败');
        }else{
            $this->load->view('login');
        }

    }

    //超级管理员
    public function root_admin(){
    	$admin = array_pop($this->user->select_all(array('id' =>'1')));
    	return $admin['id'];
    }
    //创建管理员
	public function add_admin($id = ''){
		$this->load->helper('form');
        $admin =array_pop($this->user->select_all(array('id' => '1')));
        $data = array(
            'id' => $admin['id'],
            'user_name' => $admin['user_name'],
            'user_real_name' => $admin['user_real_name'],
            'user_email' => $admin['shop_relation'],
            'user_head' => $admin['imgurl']
        );
        $this->load->view('head');
    	 $this->load->view('adduser',$data);
    }

    //改变管理员
    public function makeadmin($id){
        $data['is_admin'] = $this->input->post('is_admin');
        if($this->user->update_user($data, $id)){
            $this->session->set_flashdata('flashmessage', '操作成功');
        }else{
            $this->session->set_flashdata('flashmessage', '操作成功');
        }
        redirect('user/index');
    }

    //修改密码
    public function edit_password($id = ''){
        if ($id){
            $user = $this->user->getInfoById($id);

        }
        $this->load->view('header');
        $this->load->view('editpassword',$user);
    }
    public function update_password(){
        $uid = $this->input->post('uid');
        $data['user_password'] =md5( $this->input->post('userpassword'));
        $this->user->update_user($data,$uid);
        $this->session->set_flashdata('flashmessage', '修改成功');
        redirect('user/index');

    }



}
