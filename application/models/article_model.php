<?php
class Article_model extends CI_Model{
    private $db_name = "yk_article";

    public function __construct(){
        parent::__construct();
        
    }

    /*
     * 查询所有的分类
     */
	public function select_article($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("aid", "desc");
        $this->db->join('yk_article_category', 'yk_article_category.id = yk_article.cat_id');
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }

   
  //删除内容
    public function delete_article($id) {
        $this->db->delete($this->db_name, array('aid' => $id));
        return $this->db->affected_rows();
    }
    //添加修改内容
    function edit_article($data, $id = '') {
        if($id) { //修改
            $this->db->where('aid', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
            return $this->db->insert($this->db_name, $data) ? true : false;
        }
    }

 	/*
     * 查询
     */
	public function get_article($fetch = array('*'), $limit = 1, $offset = 0) {
        $this->db->order_by("aid", "desc");
       // $this->db->join('ylz_article_category', 'ylz_article_category.id = ylz_article.cat_id');
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    //查询数量
	public function select_article_count($fetch = array('*')) {
		$this->db->where($fetch);
		$this->db->from($this->db_name);
		return $this->db->count_all_results();
    }

}


?>
