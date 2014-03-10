<?php

class Product_category extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('product_category_model','category');
    }

    /*
     * 获取所有的分类
     * @param
     */
    public function index($page = 1){
        $this->load->helper('form');
        $this->load->library('pagination');
        $res = $this->category->select_categories(array());
        $config['base_url'] = site_url('product_category/index');
        $config['total_rows'] = count($res);
        $config['per_page'] = '10';
        $config['use_page_numbers']=TRUE;
        $this->pagination->initialize($config);
        $limit = '10';
        //$page = $sid?$sid:1;
        $offset = $limit *($page-1);
        $result['list'] = $this->category->select_categories(array(),$limit,$offset);
        $this->load->view('header');
        $this->load->view('product_category',$result);
    }

    /*
     * 添加修改类别
     */
    public function edit($id = ''){
        //验证分类同名
        $data['name'] = $this->input->post('name');
        if (!$data['name']){
            $this->session->set_flashdata('flashmessage', '请填写分类名');
            redirect('product_category/index');
            exit;
        }
        //所有分类名
        $cnames = $this->category->getnames();
        if ($cnames){
            foreach ($cnames as $cn){
                $cates[] = $cn['name'];
            }
        }
        if ($id){
            $catname = $this->category->get_name($id);
            if (isset($cates)){
                if (in_array($data['name'], $cates) && $data['name'] != $catname[0]['name'] ){
                    $this->session->set_flashdata('flashmessage', '分类名已存在');
                    redirect('product_category/index');
                    exit;
                }
            }
        }else{
            if (isset($cates)){
                if (in_array($data['name'], $cates)){
                    $this->session->set_flashdata('flashmessage', '分类名已存在');
                    redirect('product_category/index');
                    exit;
                }
            }
        }

        $this->category->edit($data,$id);
        if($id) { //修改
            $this->session->set_flashdata('flashmessage', '修改成功');
            redirect('product_category/index');
        }else { //添加
            $this->session->set_flashdata('flashmessage', '添加成功');
            redirect('product_category/index');
        }
    }

    /*
     * 修改类别
     */
    public function update_category($id){
        //   $this->category->update_category($id);


    }

    /*
     * 删除类别
     */
    public function delete($id){
        $this->category->delete($id);
        $this->session->set_flashdata('flashmessage', '删除成功');
        redirect('product_category/index');
    }

}


?>