<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 小猪猪
 * Date: 13-8-13
 * Time: 上午9:41
 * To change this template use File | Settings | File Templates.
 */


/*
 * 返回数据
 */
class Ret {
    public $status;
    public $remark;
    public $result;

    function __construct($status='ok',$result=array(),$remark = null) {
        $this->status = $status;
        $this->result = $result;
        $this->remark = $remark;
    }
}



?>
