<?php
class Forum_model extends CI_Model{
    private $db_name = "yk_forum";

    public function __construct(){
        parent::__construct();
        
    }

    /*
     * 查询所有论坛
     */
	public function select_forum($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("fid", "desc");       
       // $this->db->join('yk_user', 'yk_user.uid = yk_faq.uid');
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }

    public function select_forum_by($limit = 100, $offset = 0,$name) {
        $this->db->order_by("fid", "desc");  
        $this->db->like('name', $name);      
        $query = $this->db->get($this->db_name, $limit, $offset);
        return $query->result_array();
    }

   
  //删除内容
    public function delete_forum($id) {
        $this->db->delete($this->db_name, array('fid' => $id));
        return $this->db->affected_rows();
    }
    //添加修改内容
    public function edit_forum($data, $id = '') {
        if($id) { //修改
            $this->db->where('fid', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
            return $this->db->insert($this->db_name, $data) ? true : false;
        }
    }
 
	 public function get($id){
	 	 $query = $this->db->get_where($this->db_name,array('fid' => $id));
         return $query->result_array();
	 }


}
?>