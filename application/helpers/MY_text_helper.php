<?php
function str_cut($str,$count){
	if ($str){
		if(utf8_strlen($str) > $count){
			return mb_substr($str, 0,$count).'...';
		}elseif (utf8_strlen($str) <= $count){
			return mb_substr($str, 0,$count);
		}
	}else{
		return '';
	}
}

function utf8_strlen($string = null) {
// 将字符串分解为单元
	preg_match_all("/./us", $string, $match);
// 返回单元个数
	return count($match[0]);
}