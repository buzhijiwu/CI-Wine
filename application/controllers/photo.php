<?php
class Photo extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('photo_model','photo');

    }



    /*
     * 后台获取所有的photo
     */
    public function index(){
        $res = $this->photo->select_photo();
        $data['list'] = $res;
        //获取所有的分类
        $this->load->model('photo_category_model','cat');
        $cat_list = $this->cat->select_categories(array());
        $data['cat_list'] = $cat_list;
        $this->load->view('header.php');
        $this->load->view('photo.php',$data);

    }


    /*
     * 前台获取吃。。。
     *
     */
    public function getEat(){
        $this->load->model('photo_category_model','cat');
        $id = $this->cat->get_id('吃');
        $res = $this->photo->get_photo(array('cid'=>$id['id']),100);
        foreach($res as &$value){
            $value['is_full'] = $this->tran($value['is_full']);
        }
        return $res;

    }

    /*
     * 前台获取穿。。
     */
    public function getWear(){
        $this->load->model('photo_category_model','cat');
        $id = $this->cat->get_id('衣');
        $res = $this->photo->get_photo(array('cid'=>$id['id']),100);
        foreach($res as &$value){
            $value['is_full'] = $this->tran($value['is_full']);
        }
        return $res;
    }

    /*
     *前台获取文。。
     */
    public function getCult(){
        $this->load->model('photo_category_model','cat');
        $id = $this->cat->get_id('文');
        $res = $this->photo->get_photo(array('cid'=>$id['id']),100);
        foreach($res as &$value){
            $value['is_full'] = $this->tran($value['is_full']);
        }
        return $res;
    }

    /*
     * 前台获取葡萄树。。
     */
    public function getPts(){
        $this->load->model('photo_category_model','cat');
        $id = $this->cat->get_id('葡萄树');
        $res = $this->photo->get_photo(array('cid'=>$id['id']),100);
        foreach($res as &$value){
            $value['is_full'] = $this->tran($value['is_full']);
        }
        return  $res;
    }


    /*
     * 前台吃，衣，文，葡萄树。。
     */
    public function getAll($cat){
        switch($cat){
            case 'eat':{
                $ret = $this->getEat();
                break;
            }
            case 'wear':{
                $ret = $this->getWear();
                break;
            }
            case 'cult':{
                $ret = $this->getCult();
                break;
            }
            case 'tree':{
                $ret = $this->getPts();
                break;
            }
            default:{
            $ret = json_encode(new Ret('no','非法操作'));
            }
        }
        echo json_encode(new Ret('ok',$ret));
    }

/*
 * 0,1 转ture,false
 */
    public function tran($var){
        if($var == 1 || $var == '1'){
            $var = TRUE;
        }elseif($var == 0 || $var == '0'){
            $var = FALSE;
        }
        return $var;

    }

/*
 * 后台下拉表单搜索
 */
    public function search(){
        //获取所有的分类
        $this->load->model('photo_category_model','cat');
        $cat_list = $this->cat->select_categories(array());
        $data['cat_list'] = $cat_list;
        $cid = $this->input->post("cid");
        $res = $this->photo->search($cid);
        $data['list'] = $res;
        $this->load->view('header.php');
        $this->load->view('photo.php',$data);
    }

   /*
    * 后台删除
    */
    public function delete($id){
        if($this->photo->delete_photo($id)){
            alert_location('删除成功',site_url('photo'));
        }else{
            alert_location('删除失败',site_url("photo"));
        }
    }


    /*
     * add_edit
     */
    public function add_edit_show($id=''){
        //获取所有的分类
        $this->load->model('photo_category_model','cat');
        $cat_list = $this->cat->select_categories(array());
        $data['cat_list'] = $cat_list;
        $this->load->view('header.php');
        if(empty($id)){
            //add
            $this->load->view('photo_add.php',$data);
        }else{
            //edit
            $info = $this->photo->get_detail($id);
            $data['info'] = $info;
            $this->load->view('photo_edit.php',$data);
        }

    }

    public function admin_add_edit($id=''){
        $id = $this->input->post("id");
        if(!empty($_FILES['photo_img']['name'])){
            $config['upload_path'] = 'uploads/photo/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name'] = date('Ymd').mt_rand(1000,9999);
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo_img')) {
                //success
                $info['img'] = 'photo/'.$config['file_name'].'.'.$this->upload->get_ext();
            }else{
                //error
                $error = array('error' => $this->upload->display_errors());
                alert_back(strip_tags($error['error']));
                exit;
            }

        }

        $info['cid'] = $this->input->post('photo_cat');
        $info['title'] = $this->input->post('photo_title');
        $info['intro'] = $this->input->post('photo_content');
        $info['is_full'] = $this->input->post('is_full');
        $info['create_time'] = date('Y-m-d H:i:s');

        if($this->photo->edit_product($info,$id)){
            alert_location('操作成功',site_url('photo'));
        }else{
            alert_location('操作失败',site_url('photo'));
        }
    }














}

?>
