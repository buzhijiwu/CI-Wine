<?php
class Photo_model extends CI_Model{
    private $db_name = "yk_photo";

    public function __construct(){
        parent::__construct();

    }

    /*
     * 查询所有
     */
    public function select_photo() {
        $sql_join = 'select p.id,p.title,p.img,c.name from yk_photo as p join yk_photo_category as c on c.id = p.cid order by create_time DESC';
        $query = $this->db->query($sql_join);
        return $query->result_array();
    }

    /*
     * 搜索
     *
     */
    public function search($cid){
        $sql_join = "select p.id,p.title,p.img,p.cid,c.name from yk_photo as p join yk_photo_category as c on c.id = p.cid where cid='$cid' order by create_time DESC";
        $query = $this->db->query($sql_join);
        return $query->result_array();
    }

    /*
     * detail
     */
    public function get_detail($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->db_name);
        return $query->row_array();
    }

    //删除内容
    public function delete_photo($id) {
        $this->db->delete($this->db_name, array('id' => $id));
        return $this->db->affected_rows();
    }
    //添加修改内容
    function edit_product($data, $id = '') {
        if($id) { //修改
            $this->db->where('id', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
            return $this->db->insert($this->db_name, $data) ? true : false;
        }
    }

    /*
    * 查询
    */
    public function get_photo($fetch = array('*'), $limit = 100, $offset = 0) {
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }
    //查询数量
    public function select_product_count($fetch = array('*')) {
        $this->db->where($fetch);
        $this->db->from($this->db_name);
        return $this->db->count_all_results();
    }

}


?>
