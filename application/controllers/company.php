<?php
class Company extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('company_model','company');
    }

    /*
     * 显示企业信息
     * @param
     */
//    public function index($page = 1){
//        $company = array_shift($this->company->select_company(array()));
//         if ($company){
//         	$data =array(
//         		'companyname' => $company['companyname'],
//         		'contact' => $company['contact'],
//	         	'description' => strip_tags($company['description']),
//	         	'tel' => unserialize($company['tel']),
//	         	'qq_account' => $company['qq_account'],
//	         	'wechat_account' => $company['wechat_account'],
//	         	'micro_account' => $company['micro_account'],
//	         	'url' => $company['url'],
//	         	'logo' => $company['logo'],
//         	);
//         }
//       
//        $this->load->view('header');
//        $this->load->view('company',$data);
//    }
	
    public function editcompany($id = ''){
    	$company = array_pop($this->company->select_company(array()));
    	$data = array(
    		'cid' => $company['cid'],
    		'companyname' => $company['companyname'],
    		'description' => $company['description'],
    		'url' => $company['url']
    	);
    	$this->load->view('header');
    	$this->load->view('editcompany',$data);
    }
    /*
     * 添加修改企业信息
     */
    public function edit($id = ''){
    	
    	//print_r($this->input->post('tel'));exit;
    	$data['companyname'] = $this->input->post('companyname');
    	if (!$data['companyname']){
    		$this->session->set_flashdata('flashmessage', '请填写企业名');
            redirect('company/editcompany');
    		exit;
    	}
    	$data['description'] = $this->input->post('description');
    	$data['url'] = $this->input->post('url');
    	$data['create_time'] = date('Y-m-d H:i:s');
    	
    	if(isset($_FILES['logo']) && $_FILES['logo']['name'] != '') { //上传图片
            $config = array(
            	'upload_path' => 'uploads/company',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => time(),
            );
            $this->load->library('upload', $config);
           if (!$this->upload->do_upload('logo')) {
               $this->session->set_flashdata('flashmessage', '图片上传失败');
               redirect('company/editcompany');
               exit;
            }
             isset($config) && $data['logo'] = 'company/'.$config['file_name'].'.'.$this->upload->get_ext();
        }
       
        $data['cid'] = $this->input->post('cid');
        if ($this->company->edit_company($data,$data['cid'])){
        	if ($data['cid']){
        		$this->session->set_flashdata('flashmessage', '企业信息修改成功');
	            redirect('index');
	    		exit;
        	}else{
        		$this->session->set_flashdata('flashmessage', '企业添加成功');
	            redirect('index');
	    		exit;
        	}
        	
        }
    	
    }

    

    /*
     * 删除类别
     */
    public function delete($id){
         $this->company->delete($id);
         $this->session->set_flashdata('flashmessage', '删除成功');
         redirect('company/index');
    }

	/*
     * 手机端返回企业信息
     */

	public function getcompany(){
         $company = array_shift($this->company->select_company(array()));
         if ($company){
         	$data =array(
         		'companyname' => $company['companyname'],
         		'contact' => $company['contact'],
	         	'description' => $company['description'],
	         	'tel' => unserialize($company['tel']),
         		'address' => $company['address'],
	         	'qq_account' => unserialize($company['qq_account']),
	         	'wechat_account' => $company['wechat_account'],
	         	'micro_account' => $company['micro_account'],
	         	'url' => $company['url'],
	         	'logo' => $company['logo'],
         	);
         	$result = new Ret('ok',$data);
          	echo json_encode($result);
         }
    }


//获取企业概况
	public function summary($id = 1){
		//echo $id;exit;
		$this->load->model('article_category_model','category');
       	$this->load->model('article_model','article');
		if ($id == 1){
			$aid = $this->category->get_id('企业文化');
       	 	$article = array_pop($this->article->get_article(array('cat_id' => $aid[0]['id'])));
		}elseif ($id == 2){
			$aid = $this->category->get_id('企业优势');
       	 	$article = array_pop($this->article->get_article(array('cat_id' => $aid[0]['id'])));
		}elseif ($id == 3){
			 $aid = $this->category->get_id('企业荣誉');
       	 	 $article = array_pop($this->article->get_article(array('cat_id' => $aid[0]['id'])));
		}elseif ($id == 4){
			$aid = $this->category->get_id('发展历程');
       	    $article = array_pop($this->article->get_article(array('cat_id' => $aid[0]['id'])));
		}
		if ($article){
	       	 $result = new Ret('ok',$article);
	       	 echo json_encode($result);
       	 }else{
       	 	$result = new Ret('ok',array());
	       	 echo json_encode($result);
       	 }
	}




}





?>