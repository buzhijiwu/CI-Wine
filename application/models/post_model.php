<?php
class Post_model extends CI_Model{
    private $db_name = "yk_post";

    public function __construct(){
        parent::__construct();
        
    }

    /*
     * 查询所有帖子
     */
	public function select_post($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("pid", "desc");       
        $this->db->join('yk_user', ' yk_user.id = yk_post.uid'); 
        $this->db->select("user_head,user_name,pid,uid,subject,message,yk_post.create_time");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
	//贴子按回复排序
	public function select_post_by_comment($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("commenttime", "desc");       
        $this->db->join('yk_user', ' yk_user.uid = yk_post.uid'); 
        $this->db->select("user_head,user_name,pid,subject,message,yk_post.create_time");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    
	public function select_posts($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("pid", "desc");       
        $this->db->join('yk_user', ' yk_user.uid = yk_post.uid');
        $this->db->select("user_head,pid,fid,yk_user.id,user_name,subject,message,create_time");
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
   
  //删除内容
    public function delete_post($id) {
        $this->db->delete($this->db_name, array('pid' => $id));
        return $this->db->affected_rows();
    }
    //添加修改帖子
    public function edit_post($data, $id = '') {
        if($id) { //修改
            $this->db->where('pid', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
//          return $this->db->insert($this->db_name, $data) ? true : false;
            if(time()-$this->session->userdata('last_post_time')<60){
                echo json_encode(new Ret('no','发帖过于频繁'));
                exit;
            }

            if($this->db->insert($this->db_name, $data)){
                $this->session->set_userdata("last_post_time",time());
                return true;
            }else{
                return false;
            }
        }
    }
 
	 public function get($id){
	 	 $query = $this->db->get_where($this->db_name,array('fid' => $id));
         return $query->result_array();
	 }

  //查询数量
	public function select_post_count($fetch = array('*')) {
		$this->db->where($fetch);
		$this->db->join('yk_user', ' yk_user.id = yk_post.uid');
		$this->db->from($this->db_name);
		return $this->db->count_all_results();
    }
	 
  //获取一条贴子的信息
  public function get_post($pid){
  	 $this->db->join('yk_user', ' yk_user.id = yk_post.uid');
  	 //$this->db->join('yk_forum', ' yk_post.fid = yk_forum.fid');
     $this->db->select("user_head,user_name,pid,subject,message,yk_post.create_time");
   	 $query = $this->db->get_where($this->db_name,array('pid' => $pid));
     return $query->row_array();
  }
  //获取贴子的简单信息
  public function get_simple_post($pid){
  	 $this->db->join('yk_user', ' yk_user.uid = yk_post.uid');
     $this->db->select("user_head,pid,fid,yk_user.uid,subject,create_time");
   	 $query = $this->db->get_where($this->db_name,array('pid' => $pid));
     return $query->row_array();
  }
}
?>
