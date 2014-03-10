<?php

class Club_model extends CI_Model {

    private $db_name = 'yk_club';

    public function __construct() {
        parent::__construct();
    }

    public function select_club($fetch = array('*'), $limit = 100, $offset = 0,$value = '') {
        if ($value){
            $this->db->like('club_name', $value);
        }
        $this->db->order_by("club_id", "desc");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    //添加会所
    public function edit_club($data, $id = '') {
        if($id) { //修改
            $this->db->where('club_id', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
            return $this->db->insert($this->db_name, $data) ? true : false;
        }
    }
    //更新
    public function update_club($data,$id){
        $this->db->where('club_id', $id);
        return $this->db->update($this->db_name, $data) ? true : false;
    }

    //删除会所
    public function delete_club($id) {
        $this->db->delete($this->db_name, array('club_id' => $id));
        return $this->db->affected_rows();
    }
    //查询
    public function get_club($fetch = array('*'), $limit = 1, $offset = 0) {
        // $this->db->order_by("video_id", "desc");
        // $this->db->join('ylz_article_category', 'ylz_article_category.id = ylz_article.cat_id');
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->row_array();
    }
    //查询数量
    public function select_club_count($fetch = array('*')) {
        $this->db->where($fetch);
        $this->db->from($this->db_name);
        return $this->db->count_all_results();
    }

}