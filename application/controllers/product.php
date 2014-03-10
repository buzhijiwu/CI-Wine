<?php
class Product extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('product_model','product');

    }

    /*
     * 获取所有的商品列表
     * @param
     */
    public function index($page = 1){
        $this->load->model('product_category_model','category');
        //获取分类
        $res = $this->category->select_categories(array());
        if ($res){
            $category[] = '--请选择分类--';
            foreach ($res as $re){
                $category[$re['id']] = $re['name'];
            }
            $result['cats'] = $category;
        }

        $this->load->helper('form');
        $this->load->library('pagination');
        $res = $this->product->select_product(array());
        $cat = $this->input->post('cat_id');
        $config['base_url'] = site_url('product/index');
        $config['total_rows'] = count($res);
        $config['per_page'] = '10';
        $config['use_page_numbers']=TRUE;
        $this->pagination->initialize($config);
        $limit = '10';
        $offset = $limit *($page-1);
        if ($cat){
            $result['catid'] = $cat;
            $result['list'] = $this->product->select_product(array('cat_id' => $cat),$limit,$offset);
        }else{
            $result['catid'] = '';
            $result['list'] = $this->product->select_product(array(),$limit,$offset);
        }

        for($i=0;$i<count($result['list']);$i++) {          //时间戳转换时间格式
            $result['list'][$i]['createtime'] = date('Y-m-d',$result['list'][$i]['createtime']);
            $result['list'][$i]['updatetime'] = date('Y-m-d',$result['list'][$i]['updatetime']);
        }

        $this->load->view('header');
        $this->load->view('product',$result);
    }

    public function showeidt($id = ''){
        $this->load->helper('form');
        $this->load->model('product_category_model','category');
        //获取所有分类
        $categories = $this->category->select_categories(array());
        if ($categories){
            foreach ($categories as $cat){
                $cate[$cat['id']] = $cat['name'];

            }
        }
        $data = array();
        $product = array_pop($this->product->select_product(array('pid' => $id)));
        $data = array(
            'pid' => $product['pid'],
            'pname' => $product['pname'],
            'shortdesc' => $product['shortdesc'],
            'content' => $product['content'],
            'price' => $product['price'],
            'cat_id' => $product['cat_id'],
            'category' => $cate
        );
        $this->load->view('header');
        $this->load->view('editproduct',$data);

    }
    /*
     * 添加修改商品
     */
    public function edit(){
        header("content-type:text/html;charset=utf8");

        if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != '') { //上传图片
            $config = array(
                'upload_path' => 'uploads/product_pic',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => time(),
            );
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $this->session->set_flashdata('flashmessage', '图片上传失败');
                redirect('product/index');
                exit;
            }
        }

        isset($config) && $data['picture'] = 'product_pic/'.$config['file_name'].'.'.$this->upload->get_ext();

        $data['pid'] = $this->input->post('pid');
        $data['pname'] = $this->input->post('pname');
        $data['price'] = $this->input->post('price');
        $data['shortdesc'] = $this->input->post('shortdesc');

        $content = $this->input->post('content');       //过滤HTML标签
        $content = preg_replace( "@<a(.*?)</a>@is", "", $content );
        $data['content'] = $content;

        $data['cat_id'] = $this->input->post('cat_id');
        if (!$this->input->post('pid')){
            $data['createtime'] = time();
        }
        $data['updatetime'] = time();

        if($this->product->edit_product($data, $this->input->post('pid'))){
            if ($data['pid']){
                $this->session->set_flashdata('flashmessage', '商品编辑成功');
            }else{
                $this->session->set_flashdata('flashmessage', '商品添加成功');
            }
            redirect('product/index');
        }else{
            $this->session->set_flashdata('flashmessage', '操作失败');
            redirect('product/index');
        }
    }


    /*
     * 删除商品
     */
    public function delete($id){
        $this->product->delete_product($id);
        $this->session->set_flashdata('flashmessage', '删除成功');
        redirect('product/index');
    }

    /*
     * 手机端获取吃商品
     */
    public function get_eat($page = 1,$limit = 2){
        $offset = $limit *($page-1);
        $this->load->model('product_category_model','category');
        $pid = $this->category->get_id('吃');
        $product = $this->product->select_product(array('cat_id' => $pid[0]['id']),$limit,$offset);
        $final = array();
        foreach($product as $key =>  $r){
            $final[$key]['pid'] = $r['pid'] ;
            $final[$key]['pname'] = $r['pname'] ;
            $final[$key]['picture'] = $r['picture'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

    /*
     * 手机端获取衣商品
     */
    public function get_clothes($page = 1,$limit = 2){
        $offset = $limit *($page-1);
        $this->load->model('product_category_model','category');
        $pid = $this->category->get_id('衣');
        $product = $this->product->select_product(array('cat_id' => $pid[0]['id']),$limit,$offset);
        $final = array();
        foreach($product as $key =>  $r){
            $final[$key]['pid'] = $r['pid'] ;
            $final[$key]['pname'] = $r['pname'] ;
            $final[$key]['picture'] = $r['picture'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

    /*
     * 手机端获取文商品
     */
    public function get_article($page = 1,$limit = 2){
        $offset = $limit *($page-1);
        $this->load->model('product_category_model','category');
        $pid = $this->category->get_id('文');
        $product = $this->product->select_product(array('cat_id' => $pid[0]['id']),$limit,$offset);
        $final = array();
        foreach($product as $key =>  $r){
            $final[$key]['pid'] = $r['pid'] ;
            $final[$key]['pname'] = $r['pname'] ;
            $final[$key]['picture'] = $r['picture'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

    /*
     * 手机端获取其他商品
     */
    public function get_other($page = 1,$limit = 2){
        $offset = $limit *($page-1);
        $this->load->model('product_category_model','category');
        $pid = $this->category->get_id('其他');
        $product = $this->product->select_product(array('cat_id' => $pid[0]['id']),$limit,$offset);
        $final = array();
        foreach($product as $key =>  $r){
            $final[$key]['pid'] = $r['pid'] ;
            $final[$key]['pname'] = $r['pname'] ;
            $final[$key]['picture'] = $r['picture'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

    //显示商品详细
    public function get_product_detail($id){
        if ($id){
            $this->load->model('product_category_model','category');
            $content = $this->product->get_product(array('pid' => $id));
            if ($content[0]['cat_id']){
                $cname = $this->category->get_name($content[0]['cat_id']);
            }
            $final = array();
            foreach($content as $key =>  $r){
                $final[$key]['pid'] = $r['pid'] ;
                $final[$key]['pname'] = $r['pname'] ;
                $final[$key]['price'] = $r['price'] ;
                $final[$key]['shortdesc'] = $r['shortdesc'] ;
                $final[$key]['content'] = $r['content'] ;
                $final[$key]['picture'] = $r['picture'] ;
                $final[$key]['createtime'] = date('Y-m-d',$r['createtime']) ;
            }
            $result = new Ret('ok',$final,$cname[0]['name']);
            echo json_encode($result);
        }
    }

}

?>
