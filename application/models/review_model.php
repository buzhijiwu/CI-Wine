<?php

class Review_model extends CI_Model {

    private $db_name = 'yk_review';

    public function __construct() {
        parent::__construct();
    }
    //文章评论查询
    public function select_review1($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("review_id", "desc");
        $this->db->join('yk_user', 'yk_user.id = yk_review.uid');
        $this->db->join('yk_article', 'yk_article.aid = yk_review.aid');
        $this->db->select("yk_review.review_id,yk_review.create_time,yk_review.review_content,yk_review.uid,yk_user.user_name,yk_user.user_head,yk_article.aid,yk_article.title");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    //视频评论查询
    public function select_review2($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("review_id", "desc");
        $this->db->join('yk_user', 'yk_user.id = yk_review.uid');
        $this->db->join('yk_video', 'yk_video.video_id = yk_review.aid');
        $this->db->select("yk_review.review_id,yk_review.create_time,yk_review.review_content,yk_review.uid,yk_user.user_name,yk_user.user_head,yk_video.video_id,yk_video.video_name");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    //分享评论查询
    public function select_review3($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("review_id", "desc");
        $this->db->join('yk_user', 'yk_user.id = yk_review.uid');
        $this->db->join('yk_share', 'yk_share.share_id = yk_review.aid');
        $this->db->select("yk_review.review_id,yk_review.create_time,yk_review.review_content,yk_review.uid,yk_user.user_name,yk_user.user_head,yk_share.share_id,yk_share.share_title");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }

    //添加评论
    public function add_review($data) {
        return $this->db->insert($this->db_name, $data) ? true : false;
    }

    //删除评论
    public function delete_review($id) {
        $this->db->delete($this->db_name, array('review_id' => $id));
        return $this->db->affected_rows();
    }

}