/*
验证表单，添加商品
 */

$(function(){
    /*
    、添加商品验证
    */
    $("#product_form").submit(function(){
        if($("#title").val() == ''&&$("#pts_content").val() == ''){
            alert('标题和内容不能都为空');
            return false;
        }

        if($("#title").val().length>20){
            alert('标题不得超过20个字符');
            return false;
        }

        if($("#pts_img").val() == ''){
            alert('必须上传图片');
            return false;
        }


        if($("#pts_content").val().length>100){
            alert('标题不得超过100个字符');
            return false;
        }


    });







})