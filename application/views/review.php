<div id="right">
    <fieldset>
        <legend>评论管理</legend>

        <a href="<?php echo site_url('review/index')."?id=1"; ?>" ><input class="btn" type="button" value="文章评论"></a>
        <a href="<?php echo site_url('review/index')."?id=2"; ?>" ><input class="btn" type="button" value="视频评论"></a>
        <a href="<?php echo site_url('review/index')."?id=3"; ?>" ><input class="btn" type="button" value="分享评论"></a>
        <?php
            if (isset($list)){
        ?>
            <table class="table table-striped table-hover" style="font-size: 13px;">
                <tr align="center" valign="middle" height="30">
                    <th width="5%"  bgcolor="#cccccc" style="text-align: center">序号</th>
                    <th width="30%"  bgcolor="#cccccc"style="text-align: center">标题</th>
                    <th width="35%"  bgcolor="#cccccc"style="text-align: center">评论内容</th>
                    <th width="10%" bgcolor="#cccccc"style="text-align: center">用户</th>
                    <th width="15%" bgcolor="#cccccc"style="text-align: center">评论时间</th>
                    <th bgcolor="#cccccc"style="text-align: center">操作</th>
                </tr>
                <?php
                    $i = 1;
                    foreach ($list as $item){
                ?>
                        <tr valign="middle">
                            <td bgcolor="#eeeeee" height="25" style="text-align: center;"><?php echo $i;$i++;?></td>

                <?php if($type == '1'){ ?>
                            <td bgcolor="#eeeeee" height="25" style="text-align: center;" title="<?php echo $item['title']; ?>"><?php echo str_cut($item['title'],20);?></td>
                <?php  }elseif($type == '2'){  ?>
                            <td bgcolor="#eeeeee" height="25" style="text-align: center;" title="<?php echo $item['video_name']; ?>"><?php echo str_cut($item['video_name'],20);?></td>
                <?php  }elseif($type == '3'){ ?>
                            <td bgcolor="#eeeeee" height="25" style="text-align: center;" title="<?php echo $item['share_title']; ?>"><?php echo str_cut($item['share_title'],20);?></td>
                <?php } ?>
                            <td bgcolor="#eeeeee" title="<?php echo $item['review_content']; ?>"><?php echo str_cut($item['review_content'],20);?></td>
                            <td bgcolor="#eeeeee" style="text-align: center;" ><?php echo $item['user_name'] ;?></td>
                            <td bgcolor="#eeeeee" style="text-align: center;"><?php echo $item['create_time'] ;?></td>
                            <td bgcolor="#eeeeee" style="text-align: center;"><a href="<?php echo site_url('review/delete_review/'.$item['review_id']);?>" onclick="return confirm('是否删除')">删除</a></td>
                        </tr>
                <?php
                }
                ?>
            </table>
        <?php
        }else{
            echo '暂无内容';
        }
        ?>
    </fieldset>
    <div id="page" style="text-align: center"><?php echo $this->pagination->create_links(); ?></div>
</div>
