<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 小猪猪
 * Date: 13-8-14
 * Time: 上午10:25
 * To change this template use File | Settings | File Templates.
 */

/*
 * 弹窗返回
 */
function alert_back($str){
    echo <<<EOT
<script>alert("$str");history.back();</script>;
EOT;


}

/*(
弹窗跳转
*/
function alert_location($str,$url){
    if($str){
        echo <<<EOT
<script>alert("$str");location.href="$url";</script>;
EOT;
    }else{
        echo <<<EOT
<script>location.href="$url";</script>;
EOT;
    }


}








?>
