<div id="right">
<fieldset>
    <legend>用户管理</legend>
		<form id="formaction" action="<?php echo site_url('user/index') ;?>" method="post">
		    <table width="100%">
		        <tr>       	
		            <td width="45%">
						<a href="<?php echo site_url('user/add_show') ;?>" style="text-decoration: none;"><button class="btn" type="button">添加用户</button></a>            </td>
		            <td>
		                <input class="input-medium search-query" style="height:30px;width:250px;" type="text" name="user_name" id="user_name" placeholder="请输入要查询的用户名"><input class="btn" type="submit" value="搜素">
		            </td>
		        </tr>
		    </table>
		</form>

 
   <?php if (isset($list)){ ?>
    <table class="table table-striped table-hover" style="font-size: 13px;">
        <tr>
            <th width="10%"  style="text-align: center;">序号</th>
            <th width="20%"  style="text-align: center;">用户名</th>
            <th width="30%"  style="text-align: center;">所属会所</th>
            <th width="20%"  style="text-align: center;">注册时间</th>
            <th width="10%"  style="text-align: center;">操作</th>
            <th style="text-align: center;">管理员</th>
        </tr>
        <?php
        $flag = 1;
            foreach($list as $item){
         ?>
            <tr>
                <td style="text-align: center;padding: 0"><?php echo $flag;$flag++;?></td>
                <td style="text-align: center;padding: 0"><?php echo $item["user_name"];?></td>
                <td style="text-align: center;padding: 0"><?php echo $item["club_name"];?></td>
                <td style="text-align: center;padding: 0"><?php echo $item["create_time"];?></td>
<!--                <td  style="text-align: center;padding: 0"><a href="--><?php //echo site_url('user/edit_password/'.$item["id"]); ?><!--" >修改密码</a></td>-->
                <td  style="text-align: center;padding: 0"><a href="<?php echo site_url('user/delete/'.$item["id"]); ?>" onclick="return confirm('是否删除')">删除</a></td>
                <td  style="text-align: center;padding: 0">
                    <form id="check<?php echo $item['id']; ?>" name="check<?php echo $item['id']; ?>" action="<?php echo site_url('user/makeadmin/'.$item['id'])?>" method="post">
                        <input type="radio" id="mkadmin<?php echo $item['id']; ?>" name="is_admin" value="1"  <?php if($item['is_admin'] == '1') { ?> checked ="checked" <?php } ?> onclick='checkadmin("<?php echo 'check'.$item['id']; ?>")'>&nbsp;是&nbsp;
                        <input type="radio" id="rmadmin<?php echo $item['id']; ?>" name="is_admin" value="0"  <?php if($item['is_admin'] == '0') { ?> checked ="checked" <?php } ?> onclick='checkadmin("<?php echo 'check'.$item['id']; ?>")'>&nbsp;否
                    </form>
                </td>
            </tr>
            	<script>
	            	function checkadmin(id){
	                	document.forms[id].submit();	
	            	}
           		 </script>
            <?php
            }
        ?>
            </table>
        <?php
            }else{
                echo '暂无用户';
            }
        ?>
     </fieldset>
<!--		<div id="page" style="text-align: center">--><?php //echo $this->pagination->create_links()?><!--</div>-->
    </div>