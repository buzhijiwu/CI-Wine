<?php
class Club extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('club_model','club');
    }
    public function index($page = 1){
        $n = $this->input->post('name');
        $this->load->helper('form');
        $this->load->library('pagination');
        if ($n){
            $res = $this->club->select_club(array(),'','',$n);
        }else{
            $res = $this->club->select_club(array());
        }
        $config['base_url'] = site_url('club');
        $config['total_rows'] = count($res);
        $config['per_page'] = '10';
        $config['use_page_numbers']=TRUE;
        $this->pagination->initialize($config);
        $limit = '10';
        $offset = $limit *($page-1);
        if($n){
            $result['list'] = $this->club->select_club(array(),$limit,$offset,$n);
        }else{
            $result['list'] = $this->club->select_club(array(),$limit,$offset);
        }

        $this->load->view('header');
        $this->load->view('club',$result);
    }
    public function  showedit($id = ''){
        $this->load->helper('form');
        $data = array();
        $club = array_pop($this->club->select_club(array('club_id' => $id)));

        $data = array(
            'club_id' => $club['club_id'],
            'club_name' => $club['club_name'],
            'club_manager' => $club['club_manager'],
            'manager_phone' => $club['manager_phone'],
            'club_content' => $club['club_content'],
        );
        $this->load->view('header');
        $this->load->view('editclub',$data);
    }
    public function edit($id = ''){
        $data['club_id'] = $this->input->post('club_id');
        $data['club_name'] = $this->input->post('club_name');
        $data['club_manager'] = $this->input->post('club_manager');
        $data['manager_phone'] = $this->input->post('manager_phone');

        $content = $this->input->post('club_content');       //过滤HTML标签
        $content = preg_replace( "@<a(.*?)</a>@is", "", $content );
        $data['club_content'] = $content;

        if (!$id){
            $data['create_time'] = date('y-m-d H:i:s',time());
        }
        //上传缩略图
        if(isset($_FILES['club_pic']) && $_FILES['club_pic']['name'] != '') { //上传图片
            $config = array(
                'upload_path' => 'uploads/club_pic',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => time(),
            );
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('club_pic')) {
                $this->session->set_flashdata('flashmessage', '缩略图上传失败');
                redirect('club');
                exit;
            }
            $data['club_pic'] = 'club_pic/'.$config['file_name'].'.'.$this->upload->get_ext();
        }else{
            if (empty($data['club_pic'])){
                $data['club_pic'] = 'club_pic/default/default.png';
            }
        }

        if($this->club->edit_club($data, $data['club_id'])){
            if (isset($data['club_id'])){
                $this->session->set_flashdata('flashmessage', '主题会所编辑成功');
            }else{
                $this->session->set_flashdata('flashmessage', '主题会所添加成功');
            }
            redirect('club');
        }else{
            $this->session->set_flashdata('flashmessage', '操作失败');
            redirect('club');
        }
    }
    //是否显示会所模块
    public function makeadmin($id){
        $data['is_show'] = $this->input->post('is_show');
        if($this->club->update_club($data, $id)){
            $this->session->set_flashdata('flashmessage', '操作成功');
        }else{
            $this->session->set_flashdata('flashmessage', '操作成功');
        }
        redirect('club/index');
    }

    /*
     * 手机端获取主题会所
     */
    public function get_club($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $club = $this->club->select_club($fetch = array(),$limit,$offset);
        $final = array();
        foreach($club as $key =>  $r){
            $final[$key]['club_id'] = $r['club_id'] ;
            $final[$key]['club_name'] = $r['club_name'] ;
            $final[$key]['club_pic'] = $r['club_pic'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

    /*
     * 手机端获取可添加会所模块列表
     */
    public function get_club_model(){
        $club = $this->club->select_club(array('is_show'=> '1'));
        $final = array();
        foreach($club as $key =>  $r){
            $final[$key]['name'] = $r['club_name'] ;
            $final[$key]['bg'] = '#5FADC6' ;
            $final[$key]['search'] = $r['club_id'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
//        print_r($result);
    }

    /*
 * 注册获取会所下拉列表
 */
    public function reg_club(){
        $res = $this->club->select_club($fetch = array());
        $club = array_reverse($res);
        $final = array();
        foreach($club as $key =>  $r){
            $final[$key]['club_id'] = $r['club_id'] ;
            $final[$key]['club_name'] = $r['club_name'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
//        print_r($result);exit;
    }

    //显示会所详细
    public function get_club_detail($id){
            $content = $this->club->get_club(array('club_id' => $id));
            $final = array();
            $final[0]['club_id'] = $content['club_id'] ;
            $final[0]['club_name'] = $content['club_name'] ;
            $final[0]['club_pic'] = $content['club_pic'] ;
            $final[0]['club_content'] = $content['club_content'] ;
            $result = new Ret('ok',$final);
            echo json_encode($result);
    }

    //删除会所
    public function delete($id){
        $this->club->delete_club($id);
        $this->session->set_flashdata('flashmessage', '删除成功');
        redirect('club');
    }
}
