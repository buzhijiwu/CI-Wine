<?php
class Article extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('article_model','article');
        
    }

    /*
     * 获取所有的文章列表
     * @param
     */
    public function index($page = 1){
    	$this->load->model('article_category_model','category');
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
        $res = $this->article->select_article(array());
        $cat = $this->input->post('cat_id');
        $config['base_url'] = site_url('article/index');
        $config['total_rows'] = count($res);
        $config['per_page'] = '10';
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['use_page_numbers']=TRUE;
        $this->pagination->initialize($config);
        $offset = $config['per_page'] *($page-1);

		if ($cat){
			$result['catid'] = $cat;
			$result['list'] = $this->article->select_article(array('cat_id' => $cat),$config['per_page'],$offset);
		}else{
			$result['catid'] = '';
			$result['list'] = $this->article->select_article(array(),$config['per_page'],$offset);
		}

        for($i=0;$i<count($result['list']);$i++) {          //时间戳转换时间格式
            $result['list'][$i]['createtime'] = date('Y-m-d',$result['list'][$i]['createtime']);
            $result['list'][$i]['updatetime'] = date('Y-m-d',$result['list'][$i]['updatetime']);
        }

		$this->load->view('header');
        $this->load->view('article',$result);
    }

   public function showeidt($id = ''){
   		$this->load->helper('form');
   		$this->load->model('article_category_model','category');
   		//获取所有分类
   		$categories = $this->category->select_categories(array());
   		if ($categories){
   			foreach ($categories as $cat){
   				$cate[$cat['id']] = $cat['name'];
   				
   			}
   		}
   		$data = array();
   			$article = array_pop($this->article->select_article(array('aid' => $id)));
   			$data = array(
   				'aid' => $article['aid'],
   				'title' => $article['title'],
   				'shortdesc' => $article['shortdesc'],
   				'content' => $article['content'],
   				'cat_id' => $article['cat_id'],
   				'url' => $article['url'],
   				'category' => $cate
   			);
   		 $this->load->view('header');
   		 $this->load->view('editarticle',$data);
   		
   }
    /*
     * 添加修改文章
     */
    public function edit(){
    	header("content-type:text/html;charset=utf8");

        if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != '') { //上传图片
            $config = array(
                'upload_path' => 'uploads/article_pic',
                'allowed_types' => 'gif|jpg|png',
                'file_name' => time(),
            );
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $this->session->set_flashdata('flashmessage', '图片上传失败');
                redirect('article/index');
                exit;
            }
        }

        isset($config) && $data['picture'] = 'article_pic/'.$config['file_name'].'.'.$this->upload->get_ext();

        $data['aid'] = $this->input->post('aid');
        $data['title'] = $this->input->post('title');
        $data['shortdesc'] = $this->input->post('shortdesc');

        $content = $this->input->post('content');       //过滤HTML标签
        $content = preg_replace( "@<a(.*?)</a>@is", "", $content );
        $data['content'] = $content;

        $data['cat_id'] = $this->input->post('cat_id');
        $data['url'] = $this->input->post('url');
        if (!$this->input->post('aid')){
        	$data['createtime'] = time();
        }
        $data['updatetime'] = time();

        if($this->article->edit_article($data, $this->input->post('aid'))){
            if ($data['aid']){
                $this->session->set_flashdata('flashmessage', '文章编辑成功');
            }else{
                $this->session->set_flashdata('flashmessage', '文章添加成功');
            }
            redirect('article/index');
        }else{
            $this->session->set_flashdata('flashmessage', '操作失败');
            redirect('article/index');
        }
    }

   
    /*
     * 删除文章
     */
    public function delete($id){
        $this->article->delete_article($id);
        $this->session->set_flashdata('flashmessage', '删除成功');
        redirect('article/index');
    }


    /*
     * 手机端获取上滑图片
     */
    public function get_start_pic(){
        header("Content-type:image/jpg");
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('上滑图片');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']));
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['picture'] = $r['picture'] ;
        }
        $i = rand(0,count($final)-1);
        echo file_get_contents(base_url().'uploads/'.$final[$i]['picture']);
    }


    /*
     * 手机端获取心灵花园文章
     */
    public function get_heart_garden($page = 1,$limit = 2){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('心灵花园');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['picture'] = $r['picture'] ;
            $final[$key]['createtime'] = date('Y年m月d日',$r['createtime']) ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

   /*
    * 手机端获取信息-发现
    */
    public function get_information_find($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('信息-发现');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['picture'] = $r['picture'] ;
            $final[$key]['createtime'] = date('Y-m-d',$r['createtime']) ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

   /*
    * 手机端获取信息-关联
    */
    public function get_information_relevance($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('信息-关联');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['picture'] = $r['picture'] ;
            $final[$key]['createtime'] = date('Y-m-d',$r['createtime']) ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

   /*
    * 手机端获取多元服务-设计
    */
    public function get_service_design(){
        header('content-type:application/json');
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('多元服务-设计');
        $this->db->select('aid,picture');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']));

        $new_arr = array_chunk($article,4);


        $result = new Ret('ok',$new_arr);
        echo json_encode($result);
    }

   /*
    * 手机端获取多元服务-体验
    */
    public function get_service_experience($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('多元服务-体验');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['picture'] = $r['picture'] ;
            $final[$key]['createtime'] = date('Y-m-d',$r['createtime']) ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

   /*
    * 手机端获取多元服务-管家
    */
    public function get_service_manager($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('多元服务-管家');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['picture'] = $r['picture'] ;
            $final[$key]['createtime'] = date('Y-m-d',$r['createtime']) ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

    /*
   * 手机端获取多元服务-会员
   */
    public function get_service_vip($page = 1,$limit = 5){
        //验证登入
        if($this->session->userdata('user_id')){
            $offset = $limit *($page-1);
            $this->load->model('article_category_model','category');
            $aid = $this->category->get_id('多元服务-会员');
            $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
            $final = array();
            foreach($article as $key =>  $r){
                $final[$key]['aid'] = $r['aid'] ;
                $final[$key]['title'] = $r['title'] ;
                $final[$key]['picture'] = $r['picture'] ;
                $final[$key]['createtime'] = date('Y-m-d',$r['createtime']) ;
            }
            if ($final){
                $result = new Ret('ok',$final);
            }else{
                $result = new Ret('ok',array());
            }
            echo json_encode($result);
        }else{
            header('http/1.0 401');
            exit;
        }

    }

   /*
    * 手机端获取荐-最新推荐
    */
    public function get_apply01($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('荐-最新推荐');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['shortdesc'] = $r['shortdesc'] ;
            $final[$key]['content'] = $r['content'] ;
            $final[$key]['url'] = $r['url'] ;
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
 * 手机端获取荐-精品阅读
 */
    public function get_apply02($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('荐-精品阅读');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['shortdesc'] = $r['shortdesc'] ;
            $final[$key]['content'] = $r['content'] ;
            $final[$key]['url'] = $r['url'] ;
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
 * 手机端获取荐-生活必备
 */
    public function get_apply03($page = 1,$limit = 5){
        $offset = $limit *($page-1);
        $this->load->model('article_category_model','category');
        $aid = $this->category->get_id('荐-生活必备');
        $article = $this->article->select_article(array('cat_id' => $aid[0]['id']),$limit,$offset);
        $final = array();
        foreach($article as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['shortdesc'] = $r['shortdesc'] ;
            $final[$key]['content'] = $r['content'] ;
            $final[$key]['url'] = $r['url'] ;
            $final[$key]['picture'] = $r['picture'] ;
        }
        if ($final){
            $result = new Ret('ok',$final);
        }else{
            $result = new Ret('ok',array());
        }
        echo json_encode($result);
    }

    //显示文章详细
    public function get_article_detail($id){
        $this->load->model('article_category_model','category');
        $content = $this->article->get_article(array('aid' => $id));
        if ($content[0]['cat_id']){
            $cname = $this->category->get_name($content[0]['cat_id']);
        }
        $final = array();
        foreach($content as $key =>  $r){
            $final[$key]['aid'] = $r['aid'] ;
            $final[$key]['title'] = $r['title'] ;
            $final[$key]['shortdesc'] = $r['shortdesc'] ;
            $final[$key]['content'] = $r['content'] ;
            $final[$key]['review_number'] = $r['review_number'] ;
            $final[$key]['praise_number'] = $r['praise_number'] ;
            $final[$key]['picture'] = $r['picture'] ;
            $final[$key]['createtime'] = date('Y-m-d',$r['createtime']) ;
        }
        $result = new Ret('ok',$final,$cname[0]['name']);
        echo json_encode($result);

    }
    //文章“赞”
    public function praise_article($id){
        $res = array_pop($this->article->select_article(array('aid'=>$id)));
        $res['praise_number'] = $res['praise_number']+1;
        $data['praise_number'] = $res['praise_number'];
        if($this->article->edit_article($data, $id)){
            $result = new Ret('ok',array('praise' => $res['praise_number']));
            echo json_encode($result);
        }else{
            $result = new Ret('-1',array('error' => '赞失败'));
            echo json_encode($result);
        }
    }

}





?>
