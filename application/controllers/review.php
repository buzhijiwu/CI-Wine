<?php
class Review extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('review_model','review');
    }

    /*
     * 显示所有评论
     */
    public function index($page = 1){
        $this->load->helper('form');
        $this->load->library('pagination');

        if(isset($_GET['id'])){
            $type = $_GET['id'];
        }
        if(isset($type)){
            $this->session->set_userdata('retype',$type);
            $rid = $type;
        }elseif($this->session->userdata('retype')){
            $rid = $this->session->userdata('retype');
        }else{
            $rid = '1';
        }

        $res = $this->review->select_review1(array('type' => $rid));
        $config['base_url'] = site_url('review/index');
        $config['total_rows'] = count($res);
        $config['per_page'] = '10';
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['use_page_numbers']=TRUE;
        $this->pagination->initialize($config);
        $offset = $config['per_page'] *($page-1);

        if($rid == '1'){
            $result['list'] = $this->review->select_review1(array('type' =>$rid),$config['per_page'],$offset);
        }elseif($rid == '2'){
            $result['list'] = $this->review->select_review2(array('type' => $rid),$config['per_page'],$offset);
        }elseif($rid == '3'){
            $result['list'] = $this->review->select_review3(array('type' => $rid),$config['per_page'],$offset);
        }
        for($i=0;$i<count($result['list']);$i++) {          //时间戳转换时间格式
            $result['list'][$i]['create_time'] = date('Y-m-d H:i:s',$result['list'][$i]['create_time']);
        }
        $result['type'] = $rid;
        $this->load->view('header');
        $this->load->view('review',$result);
    }

    //后台删除评论
    public function delete_review($id){
        $this->review->delete_review($id);
        $this->session->set_flashdata('flashmessage', '删除成功');
        redirect('review/index');
    }

    //app 添加评论
    public function add_review($id){
//        //验证登入
        if($this->session->userdata('user_id')){
            $this->user_id = $this->session->userdata('user_id');
        }else{
            header('http/1.0 401');
            exit;
        }
        $data['uid'] = $this->session->userdata('user_id');
//        $data['uid'] = '28';
        $allposts = file_get_contents("php://input");
        $all = json_decode($allposts);
//        print_r($data);exit;
        //添加并返回评论信息
        if ($data['uid'] ){
            $data['aid'] = $id;
            $data['review_content'] = $all->comment_content;
            $data['type'] = $all->type;
            $data['create_time'] = time();
            if($this->review->add_review($data)){
            	if ($data['type'] == "1"){  //文章
	                $this->load->model('article_model','article');
	                $res = array_pop($this->article->select_article(array('aid'=>$id)));
	                $data1['review_number']=$res['review_number']+1;
	                $this->article->edit_article($data1, $id);
            	}elseif ($data['type'] == "2"){  //视频
            		$this->load->model('video_model','video');
            		$res = $this->video->get_video(array('video_id' => $id));
            		$data2['review_number'] = $res['review_number']+1;
	                $this->video->edit_video($data2, $id);
            	}elseif ($data['type'] == "3"){  //分享
            		$this->load->model('Share_model','share');
            		$res = $this->share->get_share(array('share_id' => $id));
            		$data3['review_number'] = $res['review_number']+1;
	                $this->share->edit_share($data3, $id);
            	}

                $this->load->model('user_model','user');
                $user_detail = array_pop($this->user->select_all(array('id' =>$data['uid'])));
                $add_review[0]['aid'] = $id;
                $add_review[0]['user_name'] = $user_detail['user_name'];
                $add_review[0]['user_head'] = $user_detail['user_head'];
                $add_review[0]['review_content'] = $all->comment_content;
                $add_review[0]['create_time'] = '刚刚';
                $result = new Ret('ok',$add_review,$remark = $res['review_number']+1);
                echo json_encode($result);
            }else{
                $result = new Ret('-1',array('error' => '评论失败'));
                echo json_encode($result);
            }
        }else{
            header('http/1.0 401');
            exit;
        }
    }
    //app获取评论列表
    public function review_list($id,$type = 1,$page = 1,$limit = 5){
        $offset = $limit *($page-1);
        if($type == '1'){
            $res = $this->review->select_review1(array('yk_review.aid' => $id,'type' => '1'),$limit,$offset);
        }elseif($type == '2'){
            $res = $this->review->select_review2(array('yk_review.aid' => $id,'type' => '2'),$limit,$offset);
        }elseif($type == '3'){
            $res = $this->review->select_review3(array('yk_review.aid' => $id,'type' => '3'),$limit,$offset);
        }
        $final = array();
        foreach($res as $key =>  $r){
            $final[$key]['aid'] = $id ;
            $final[$key]['user_name'] = $r['user_name'] ;
            $final[$key]['user_head'] = $r['user_head'] ;
            $final[$key]['review_content'] = $r['review_content'] ;
            $final[$key]['create_time'] = $this->timediff($r['create_time'],time());
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
//        print_r($result);

    }
    //计算时间差
    public function timediff($begin_time,$end_time)
    {
        if($begin_time < $end_time){
            $starttime = $begin_time;
            $endtime = $end_time;
        }
        else{
            $starttime = $end_time;
            $endtime = $begin_time;
        }
        $timediff = $endtime-$starttime;
        $days = intval($timediff/86400);
        $remain = $timediff%86400;
        $hours = intval($remain/3600);
        $remain = $remain%3600;
        $mins = intval($remain/60);
        $secs = $remain%60;
//        $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
        if(!$days){
            if($hours){
                $res = $hours.'小时前';
            }elseif($mins){
                $res = $mins.'分钟前';
            }elseif($secs){
                $res = $secs.'秒前';
            }
        }else{
            $res = date('m-d H:i',$begin_time) ;;
        }
        return $res;
    }


}
?>