<?php
class Product_model extends CI_Model{
    private $db_name = "yk_product";

    public function __construct(){
        parent::__construct();

    }

    /*
     * 查询所有的分类
     */
    public function select_product($fetch = array('*'), $limit = 100, $offset = 0) {
        $this->db->order_by("pid", "desc");
        $this->db->join('yk_product_category', 'yk_product_category.id = yk_product.cat_id');
        $query = $this->db->get_where($this->db_name, $fetch, $limit, $offset);
        return $query->result_array();
    }


    //删除内容
    public function delete_product($id) {
        $this->db->delete($this->db_name, array('pid' => $id));
        return $this->db->affected_rows();
    }
    //添加修改内容
    function edit_product($data, $id = '') {
        if($id) { //修改
            $this->db->where('pid', $id);
            return $this->db->update($this->db_name, $data) ? true : false;
        } else { //添加
            return $this->db->insert($this->db_name, $data) ? true : false;
        }
    }

    /*
    * 查询
    */
    public function get_product($fetch = array('*'), $limit = 1, $offset = 0) {
        $this->db->order_by("pid", "desc");
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
