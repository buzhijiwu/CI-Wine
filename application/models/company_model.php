<?php
class Company_model extends CI_Model{
    private $db_name = "yk_company";

    public function __construct(){
        parent::__construct();
        
    }

    /*
     * 查询企业
     */
	public function select_company($fetch = array('*'), $limit = 100, $offset = 0) {
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }

   
  //删除内容
    public function delete($id) {
        $this->db->delete($this->db_name, array('cid' => $id));
        return $this->db->affected_rows();
    }
    //添加修改企业
    function edit_company($data, $id = '') {
        if($id) { //修改
            $this->db->where('cid', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
            return $this->db->insert($this->db_name, $data) ? true : false;
        }
    }
}
?>