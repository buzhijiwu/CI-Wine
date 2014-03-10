<?php
class Video extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('video_model','video');
    }
    public function index($page = 1){
    	$n = $this->input->post('name');
    	$this->load->helper('form');
    	$this->load->library('pagination');
    	if ($n){
    		$res = $this->video->select_video(array(),'','',$n);
    	}else{
        	$res = $this->video->select_video(array());
    	}
        $config['base_url'] = site_url('video/index');
		$config['total_rows'] = count($res);
		$config['per_page'] = '10';
		$config['use_page_numbers']=TRUE;		
		$this->pagination->initialize($config); 
		$limit = '10';
		$offset = $limit *($page-1);
		if($n){
			$result['list'] = $this->video->select_video(array(),$limit,$offset,$n);
		}else{
			$result['list'] = $this->video->select_video(array(),$limit,$offset);
		}
		if ($result['list']){
			foreach ($result['list'] as &$r){
				$r['video_length'] = unserialize($r['video_length']);
                if($r['video_category'] == '1'){
                    $r['video_category'] = "空间社区";
                }else{
                    $r['video_category'] = "我的空间";
                }
			}
		}

        $this->load->view('header');
        $this->load->view('video',$result);
    }
    public function  showedit($id = ''){
    	$this->load->helper('form');   		
   		$data = array();
   		$video = array_pop($this->video->select_video(array('video_id' => $id)));
   		for ($i=0;$i <=12;$i++){
   			if (strlen($i)<2){
   				$hour[] = '0'.$i;
   			}else{
   				$hour[] = $i;
   			}
   		}
   		for ($j=0;$j <=60;$j++){
   			if (strlen($j)<2){
   				$minute[] = '0'.$j;
   			}else{
   				$minute[] = $j;
   			}
   		}
   		
   		$data = array(
   			'video_id' => $video['video_id'],
   			'video_name' => $video['video_name'],
   			'video_length' => unserialize($video['video_length']),
   			'video_url' => $video['video_url'],
            'video_category' => $video['video_category'],
   			'content' => $video['content'],
   			'video_image' => $video['video_image'],
   			'showhour' => $hour,
   			'showminute' => $minute,
   		);
   		$this->load->view('header');
   		$this->load->view('editvideo',$data);
    }
    public function edit($id = ''){
    	$data['video_id'] = $this->input->post('video_id');
        $data['video_name'] = $this->input->post('video_name');
        $data['video_category'] = $this->input->post('video_category');

        if (strlen($data['video_name'])> 45){
        	$this->session->set_flashdata('flashmessage', '视频名称过长！');
        	exit;
        }
        if ($data['video_id']){
        	$data['video_url'] = $this->input->post('video_url');
        }else{
	        $url = $this->input->post('video_url');
	        $u = basename($url);
	        $uname =  substr($u,0,strpos($u,'.'));  
	        $name =  substr($uname,3);  
	       // echo $name;exit();
	        $data['video_url'] = 'http://player.youku.com/embed/'.$name;
        }
        $data['content'] = $this->input->post('content');
        $hour[] = strlen($this->input->post('hour'))<2 ? '0'.$this->input->post('hour') :$this->input->post('hour') ;
        $hour[] = strlen($this->input->post('minute')) <2 ? '0'.$this->input->post('minute') :$this->input->post('minute') ;
        $hour[] = strlen($this->input->post('second')) < 2 ? '0'.$this->input->post('second') :$this->input->post('second') ;
        if ( $hour[0] > 12 || $hour[1] > 60 || $hour[2] > 60){
        	$this->session->set_flashdata('flashmessage', '时间格式填写有误 ');
        	exit;
        }
        $data['video_length'] = serialize($hour);
        $data['create_time'] = date('y-m-d H:i:s',time());
        //上传缩略图
    	if(isset($_FILES['video_image']) && $_FILES['video_image']['name'] != '') { //上传图片
            $config = array(
                'upload_path' => 'uploads/video_pic',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => time(),
            );
            $this->load->library('upload', $config);
        	if (!$this->upload->do_upload('video_image')) {
        		$this->session->set_flashdata('flashmessage', '缩略图上传失败');
                redirect('video');
                exit;
            }
            $data['video_image'] = 'video_pic/'.$config['file_name'].'.'.$this->upload->get_ext();
        }else{
        	if (empty($data['video_id'])){
        	 $data['video_image'] = 'video_pic/default/default.png';
        	}
        }

        if($this->video->edit_video($data, $data['video_id'])){
            if (isset($data['video_id'])){
                $this->session->set_flashdata('flashmessage', '视频编辑成功');
            }else{
                $this->session->set_flashdata('flashmessage', '视频添加成功');
            }
            redirect('video');
        }else{
            $this->session->set_flashdata('flashmessage', '操作失败');
            redirect('video');
        }
    }
    //删除视频
 	public function delete($id){
         $this->video->delete_video($id);
         $this->session->set_flashdata('flashmessage', '删除成功');
         redirect('video');
    }
    //app获取视频
    public function getvideos($page = 1,$limit = 5){
    	if($this->session->userdata('user_id')){
    	$offset = $limit *($page-1);
		$result['list'] = $this->video->select_video(array('video_category' => 1),$limit,$offset);
		if ($result['list']){
			foreach ($result['list'] as &$r){
				$times = unserialize($r['video_length']);
				if(intval($times[0])){
					$m = 60*$times[0];
				}
				if(intval($times[1])){
					if (isset($m)){
						$t[0] = $m+intval($times[1]);
					}else{
						$t[0] = intval($times[1]);
					}
				}
				if(intval($times[2])){
					$t[1] = intval($times[2]);
				}
				//print_r($times);exit;
				$r['video_length'] = $t;
			}
			}
	      	$return = new Ret('ok',$result);
	        echo json_encode($return);
    	}else{
    		header('http/1.0 401');
            exit;
    	}
    }
    //app获取我的空间视频
    public function get_club_videos($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $result['list'] = $this->video->select_video(array('video_category' => 0),$limit,$offset);
        if ($result['list']){
            foreach ($result['list'] as &$r){
                $times = unserialize($r['video_length']);
                if(intval($times[0])){
                    $m = 60*$times[0];
                }
                if(intval($times[1])){
                    if (isset($m)){
                        $t[0] = $m+intval($times[1]);
                    }else{
                        $t[0] = intval($times[1]);
                    }
                }
                if(intval($times[2])){
                    $t[1] = intval($times[2]);
                }
                //print_r($times);exit;
                $r['video_length'] = $t;
            }
        }
        $return = new Ret('ok',$result);
        echo json_encode($return);
    }
}