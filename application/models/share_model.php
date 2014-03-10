<?php

class Share_model extends CI_Model {

    private $db_name = 'yk_share';

    public function __construct() {
        parent::__construct();
    }

	public function select_share($fetch = array('*'), $limit = 100, $offset = 0,$value = '') {
		if ($value){
			$this->db->like('share_title', $value);
		}
        $this->db->order_by("share_id", "desc");
        $this->db->join('yk_user', 'yk_user.id = yk_share.user_id');
        $this->db->select("share_id,share_title,share_content,share_pic,user_id,user_name,review_number,yk_share.create_time");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    //添加视频
   public function edit_share($data, $id = '') {
        if($id) { //修改
            $this->db->where('share_id', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
        	if(time()-$this->session->userdata('last_life_time')<60*15){
                echo json_encode(new Ret('no','上传过于频繁'));
                exit;
            }
        	if ($this->db->insert($this->db_name, $data)){
        		$this->session->set_userdata("last_life_time",time());
        		return true;
        	}else{
        		return false;
        	}
            
        }
    }

 	//删除内容
    public function delete_share($id) {
        $this->db->delete($this->db_name, array('share_id' => $id));
        return $this->db->affected_rows();
    }
 	//查询
	public function get_share($fetch = array('*'), $limit = 1, $offset = 0) {
       // $this->db->order_by("video_id", "desc");
       // $this->db->join('ylz_article_category', 'ylz_article_category.id = ylz_article.cat_id');
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->row_array();
    }
    //查询数量
	public function select_share_count($fetch = array('*')) {
		$this->db->where($fetch);
		$this->db->from($this->db_name);
		return $this->db->count_all_results();
    }
    
}