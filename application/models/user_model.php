<?php

class User_model extends CI_Model {

    private $_tb = 'yk_user';

    public function __construct() {
        parent::__construct();
    }

    public function is_login() {
        return $this->session->userdata('user_id') ? true  : false;
    }

    /*
     * 某用户名是否存在
     */
    public function is_exists($account) {
        if(trim($account)) {
            $query = $this->db->get_where($this->_tb, array('user_name' => $account));
            return $query->num_rows() > 0 ? true : false;
        } else {
            return false;
        }
    }


    //普通注册用户
    function register_user($data) {
        if($this->db->insert($this->_tb, $data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /*
     * 普通登入
     */
    public function login($data){
        $this->db->select('*');
        $query = $this->db->get_where($this->_tb,$data);
        return $query->num_rows()?$query->row_array():'';
    }



    /**
     * 获取用户本地信息by name
     * @param $user_name
     */
    public function get_info_by_name($user_name) {
        $this->db->where('user_name',$user_name);
        $query = $this->db->get($this->_tb);
        return $query->row();
    }




    //获取所有的会员列表
    public function select_all($fetch = array('*'), $limit = 100, $offset = 0) {
    	$this->db->order_by("id", "asc");
        $query = $this->db->get_where($this->_tb, $fetch, $limit, $offset);       
        return $query->result_array();
    }


    //修改会员
    public function update_user($data,$id){
        $this->db->where('id', $id);
        return $this->db->update($this->_tb, $data) ? true : false;
    }

    //根据id获取会员的信息
    public function getInfoById($id){
        $query = $this->db->get_where($this->_tb,array('id' => $id));
        $row = $query->row_array();
        return $row;
    }

    //删除会员
    public function deleteById($id){
        $this->db->delete($this->_tb,array('id'=>$id));
        return $this->db->affected_rows();

    }






}