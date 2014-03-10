<div id="right">
    <fieldset>
        <legend>主题会所管理</legend>
        <form id="formaction" action="<?php echo site_url('club') ;?>" method="post">
            <table width="100%">
                <tr>
                    <td width="45%">
                        <a href="<?php echo site_url('club/showedit'); ?>" ><input class="btn" type="button" value='添加主题会所'></a>		            <td>
                        <input class="input-medium search-query" style="height:30px;width:250px;" type="text" name="name" id="name" placeholder="请输入要查询的会所标题"><input class="btn" type="submit" value="搜素">
                    </td>
                </tr>
            </table>
        </form>


        <?php
        if($list){
            ?>
            <table class="table table-striped table-hover " style="font-size: 13px;">
                <tr><th width="10%" style="text-align: center;">序号</th>
                    <th width="35%" style="text-align: center;">会所名称</th>
                    <th width="20%" style="text-align: center;">创建时间</th>
                    <th width="10%" colspan="2" style="text-align: center;">操作</th>
                    <th width="25%" style="text-align: center;">是否显示模块</th>
                </tr>
                <?php
                $i=1;
                foreach ($list as $value){
                    ?>
                    <tr style="height:10px;">
                        <td style="text-align: center;"><?php echo $i;$i++; ?></td>
                        <td style="text-align: center;"><?php echo $value['club_name']; ?></td>
                        <td style="text-align: center;"><?php echo $value['create_time']; ?></td>
                        <td style="text-align: center;"><a href="<?php echo site_url('club/showedit/'.$value['club_id']); ?>">编辑</a></td>
                        <td style="text-align: center;"><a href="<?php echo site_url('club/delete/'.$value['club_id'])?>" onclick="return confirm('确定要删除？')">删除</a></td>
                        <td  style="text-align: center;padding: 0">
                            <form id="check<?php echo $value['club_id']; ?>" name="check<?php echo $value['club_id']; ?>" action="<?php echo site_url('club/makeadmin/'.$value['club_id'])?>" method="post">
                                <input type="radio" id="mkclub<?php echo $value['club_id']; ?>" name="is_show" value="1"  <?php if($value['is_show'] == '1') { ?> checked ="checked" <?php } ?> onclick='checkadmin("<?php echo 'check'.$value['club_id']; ?>")'>
                                    &nbsp;是&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="rmclub<?php echo $value['club_id']; ?>" name="is_show" value="0"  <?php if($value['is_show'] == '0') { ?> checked ="checked" <?php } ?> onclick='checkadmin("<?php echo 'check'.$value['club_id']; ?>")'>
                                    &nbsp;否
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
        <?php }else{ ?>
            <br>未查询到主题会所...
        <?php } ?>
    </fieldset>
    <div id="page" style="text-align: center"><?php echo $this->pagination->create_links()?></div>
</div>

