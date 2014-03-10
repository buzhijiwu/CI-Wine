<?php
class Welife extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('Share_model','share');
		$this->load->model('user_model','user');
    }
    public function index($page = 1){
    	$n = $this->input->post('name');
    	$this->load->helper('form');
    	$this->load->library('pagination');
    	if ($n){
    		$res = $this->share->select_share(array(),'','',$n);
    	}else{
        	$res = $this->share->select_share(array());
    	}
        $config['base_url'] = site_url('welife/index');
		$config['total_rows'] = count($res);
		$config['per_page'] = '10';
		$config['use_page_numbers']=TRUE;		
		$this->pagination->initialize($config); 
		$limit = '10';
		$offset = $limit *($page-1);
		if($n){
			$result['list'] = $this->share->select_share(array(),$limit,$offset,$n);
		}else{
			$result['list'] = $this->share->select_share(array(),$limit,$offset);
		}
		
        $this->load->view('header');
        $this->load->view('share',$result);
    }
   
   
    public function  showedit($id = ''){
    	$this->load->helper('form');   		
   		$data = array();
   		$share = array_pop($this->share->select_share(array('share_id' => $id))); 
   		
   		$data = array(
   			'share_id' => $share['share_id'],
   			'share_title' => $share['share_title'],
   			'share_content' => $share['share_content'],
   			'user_id' => $share['user_id']?$share['user_id']:$this->session->userdata("user_id"),
   		);
   		$this->load->view('header');
   		$this->load->view('editshare',$data);
    }
    public function edit($id = ''){
    	$data['share_id'] = $this->input->post('share_id');
        $data['share_title'] = $this->input->post('share_title');
        $data['share_content'] = $this->input->post('share_content');
        $data['user_id'] = $this->session->userdata("user_id");
        if (!$id){
        	$data['create_time'] = date('Y.n.j',time());
        }else{
        	$data['create_time'] = date('Y.n.j',time());
        }
        //上传缩略图
    	if(isset($_FILES['share_pic']) && $_FILES['share_pic']['name'] != '') { //上传图片
            $config = array(
                'upload_path' => 'uploads/share_pic',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => time(),
            );
            $this->load->library('upload', $config);
        	if (!$this->upload->do_upload('share_pic')) {
        		$this->session->set_flashdata('flashmessage', '缩略图上传失败');
                redirect('welife');
                exit;
            }
            $data['share_pic'] = 'share_pic/'.$config['file_name'].'.'.$this->upload->get_ext();
        }else{
        	$data['share_pic'] = 'share_pic/default/default.jpg';
        }

        if($this->share->edit_share($data, $data['share_id'])){
            if (isset($data['share_id'])){
                $this->session->set_flashdata('flashmessage', '分享编辑成功');
            }else{
                $this->session->set_flashdata('flashmessage', '分享添加成功');
            }
            redirect('welife');
        }else{
            $this->session->set_flashdata('flashmessage', '操作失败');
            redirect('welife');
        }
    }
    //删除分享
 	public function delete($id){
         $this->share->delete_share($id);
         $this->session->set_flashdata('flashmessage', '删除成功');
         redirect('welife');
    }
    
    //app添加分享
    public function app_edit_share($id = ''){
    	$uid = $this->session->userdata('user_id');
    	if ($uid){
    		$u = $this->user->getInfoById($uid);
    		if ($u['user_type'] == '会所负责人'){
	    	$data['share_title'] = $this->input->post('share_title'); //$all->share_title;
	    	if (empty($data['share_title'])){
	    		echo json_encode(new Ret('-1','标题不能为空'));
	    		exit();
	    	}
	    	$data['share_content'] = $this->input->post('share_content'); //$all->share_content;
	    	if (empty($data['share_content'])){
	    		echo json_encode(new Ret('-1','分享内容不能为空'));
	    		exit();
	    	}
	    	$data['create_time'] = date('Y.n.j',time());
	    	$radom = $this->input->post('random'); //$all->random;
	        $baseurl = base_url();
	        $rand = time();
	    	$newfilename = ROOT.'uploads/share_pic/'.$rand;
	        if (file_exists(ROOT.'uploads/share_pic/'.$radom.'.jpg')) {
	        	rename(ROOT.'uploads/share_pic/'.$radom.'.jpg',$newfilename.'.jpg') ;
	        	$data['share_pic'] = 'share_pic/'.$rand.'.jpg';
	        }elseif (file_exists(ROOT.'uploads/share_pic/'.$radom.'.png')){
	        	rename(ROOT.'uploads/share_pic/'.$radom.'.png',$newfilename.'.png');
	        	$data['share_pic'] = 'share_pic/'.$rand.'.png';
	        }elseif (file_exists(ROOT.'uploads/share_pic/'.$radom.'.gif')){
	        	rename(ROOT.'uploads/share_pic/'.$radom.'.gif',$newfilename.'.gif') ;
	        	$data['share_pic'] ='share_pic/'.$rand.'.gif';
	        }else{
	        	$data['share_pic'] = 'share_pic/default/default.jpg';
	        }
	        $data['user_id'] = $this->session->userdata("user_id");
	        
		        if ($id){
		        	$this->share->edit_share($data,$id);
		        }else{
		        	$this->share->edit_share($data);
		        }
		        echo json_encode(new Ret('ok'));
        
    		}else{
    			header('http/1.0 401');
         		exit;
    		}
    	}else{
    		header('http/1.0 401');
         	exit;
    	}
        
    }
 /*
     * upload profile
     */ 
	public function uploadimg($rand){
     	$file= $_FILES['filename'];
     	if (isset($file)){
     		 $config = array(
                'upload_path' => 'uploads/share_pic',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => $rand
            );
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('filename')) {
                header('http/1.0 401');
         		exit;
            }
     	}
     }
     
     //app获取分享
	 public function get_shares($page = 1,$limit = 5){
	 	if($this->session->userdata('user_id')){
		 	$offset = $limit *($page-1);
			$result = $this->share->select_share(array(),$limit,$offset);
			if ($result){
				$return = new Ret('ok',$result);
			}else{
				$return = new Ret('ok',array());
			}
			
			echo json_encode($return);
	 	}else{
	 		//$return = new Ret('no',array('msg'=> '请先登录'));
	 		header('http/1.0 401');
            exit;
	 	}
	 	
    }
    
    //app 获取单条分享
    public function get_share($id){
    	$share = array_pop($this->share->select_share(array('share_id' =>$id)));
    	
    	$return = new Ret('ok',$share);
    	echo json_encode($return);
    	exit;
    }
    
}
