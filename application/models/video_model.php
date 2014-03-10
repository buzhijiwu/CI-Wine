<?php

class Video_model extends CI_Model {

    private $db_name = 'yk_video';

    public function __construct() {
        parent::__construct();
    }

	public function select_video($fetch = array('*'), $limit = 100, $offset = 0,$value = '') {
		if ($value){
			$this->db->like('video_name', $value);
		}
        $this->db->order_by("video_id", "desc");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    //添加视频
   public function edit_video($data, $id = '') {
        if($id) { //修改
            $this->db->where('video_id', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
            return $this->db->insert($this->db_name, $data) ? true : false;
        }
    }

 	//删除内容
    public function delete_video($id) {
        $this->db->delete($this->db_name, array('video_id' => $id));
        return $this->db->affected_rows();
    }
 	//查询
	public function get_video($fetch = array('*'), $limit = 1, $offset = 0) {
       // $this->db->order_by("video_id", "desc");
       // $this->db->join('ylz_article_category', 'ylz_article_category.id = ylz_article.cat_id');
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->row_array();
    }
    //查询数量
	public function select_video_count($fetch = array('*')) {
		$this->db->where($fetch);
		$this->db->from($this->db_name);
		return $this->db->count_all_results();
    }
    
}