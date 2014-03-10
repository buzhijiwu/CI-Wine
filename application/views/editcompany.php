<script>
        KindEditor.ready(function(K) {
            window.editor = K.create('#editor_id');
       
        var options = {
            cssPath : '/css/index.css',
            filterMode : true
        };
        var editor = K.create('textarea[name="description"]', options);
        });
</script>
<div id="right">
<fieldset>
   <legend>编辑企业信息</legend>
	<form id="editForm" action="<?php echo site_url('company/edit'); ?>" method="post" enctype="multipart/form-data">
	  <?php echo form_hidden('cid',$cid)?>
	  <table>
	  	<tr>
	  		<td>公司名称：</td><td><input id="companyname" type="text" name="companyname" value="<?php echo $companyname?>"></td>
	  	</tr>
	  	<tr>
	  		<td>公司简介：</td><td><textarea style="width:700px;height:300px;" id="editor_id" rows="" cols="" name="description" id="description"><?php echo $description; ?></textarea></td>
	  	</tr>
	  	<tr>
	  		<td>logo：</td><td><input type="file" name="logo" ></td>
	  	</tr>
	  	<tr>
	  		<td><input class="btn" type="submit" value="确定") ></td>
	  		<td><a href="<?php echo site_url('index')?>"><input class='btn' type="button" value="取消"></a></td>
	  	</tr>
	  </table>
	
	</form>

</fieldset>

</div>
<script>
	function createtr(){
		$("#teltr").after("<tr><td></td><td><input type='text' name='tel[]'><span style='font-size:20px;' onclick='removetr(this)'><img src='<?php echo base_url()."images/minimize.png" ;?>' /></span></td></tr>");
	}
	function createqqtr(){
		$("#telqqtr").after("<tr><td></td><td><input type='text' name='qq_account[]'><span style='font-size:20px;' onclick='removetr(this)'><img src='<?php echo base_url()."images/minimize.png" ;?>' /></span></td></tr>");
	}
	function removetr(id){
		$(id).parent().parent().remove();
	}

	$("#editForm").submit(checkinfo);
	function checkinfo(e){        
		if($("#companyname").val() == ''){
			alert('请填写企业名');
			return false;
		}
		if($("#companyname").val() == ''){
			alert('请填写企业名');
			return false;
		}
		if($("input[name='tel[]']").val() == ''){
			alert('请填写电话');
			return false;
		}
		var flag =true;		
			 $("input[name='tel[]']").each(function(){
				var isMobile=/^(?:13\d|15\d)\d{5}(\d{3}|\*{3})$/;   
				var isPhone=/^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
				
				 if(!isMobile.test($(this).val()) && !isPhone.test($(this).val())){
					   flag = false;					   					   
				       alert("请正确填写电话号码，例如:13415764179或0321-4816048");	
				       e.preventDefault();
						
				  }				  
			});
        if($("#address").val() == ''){
			alert('请填写地址');
			return false;
        }
        
//		if($("#url").val()){
//			alert(IsURL($("#url").val()));
//			if(IsURL($("#url").val())){
//			}else{
//				alert('请填写正确的网址');
//				return false;
//			}
//		}

		function IsURL(str_url){
			  var strRegex = "^((https|http|ftp|rtsp|mms)?://)" 
			  + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@ 
			        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184 
			        + "|" // 允许IP和DOMAIN（域名）
			        + "([0-9a-z_!~*'()-]+\.)*" // 域名- www. 
			        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名 
			        + "[a-z]{2,6})" // first level domain- .com or .museum 
			        + "(:[0-9]{1,4})?" // 端口- :80 
			        + "((/?)|" // a slash isn't required if there is no file name 
			        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$"; 
			        var re=new RegExp(strRegex); 
			        if (re.test(str_url)){
			            return (true); 
			        }else{ 
			            return (false); 
			        }
			    } 
	}
</script>
