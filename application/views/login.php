<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>葡萄树后台管理</title>
    <META http-equiv=Content-Type content="text/html; charset=gb2312">
    <STYLE>
        TD {
            FONT-SIZE: 11px;
            COLOR: #000000;
            FONT-FAMILY: Verdana, Arial, Helvetica, sans-serIf;
            TEXT-DECORATION: none
        }
        .input_1 {
            BORDER-RIGHT: #999999 1px solid;
            PADDING-RIGHT: 2px;
            BORDER-TOP: #999999 1px solid;
            PADDING-LEFT: 2px;
            LIST-STYLE-POSITION: inside;
            FONT-SIZE: 12px;
            PADDING-BOTTOM: 2px;
            MARGIN-LEFT: 10px;
            BORDER-LEFT: #999999 1px solid;
            COLOR: #333333; PADDING-TOP: 2px;
            BORDER-BOTTOM: #999999 1px solid;
            FONT-FAMILY: Arial, Helvetica, sans-serIf;
            LIST-STYLE-TYPE: none;
            HEIGHT: 18px;
            BACKGROUND-COLOR: #dadedf
        }
    </STYLE>
    <META content="MSHTML 6.00.6000.16705" name=GENERATOR>
    <script type="text/javascript">
        window.onload = function(){
            var clean = document.getElementById("clean");
            clean.onclick = function(){
                document.getElementById("username").value = '';
                document.getElementById("password").value = '';
            }
            var login_form = document.getElementById('login_form');
            login_form.onsubmit = function(){
                var name = document.getElementById('username');
                var pass = document.getElementById("password");
                if(name.value == ''){
                    alert('请输入用户名');
                    return false;
                }
                if(pass.value == ''){
                    alert("请输入密码");
                    return false
                }

            }

        }



    </script>

</HEAD>
<BODY>
<TABLE cellSpacing=0 cellPadding=0 width=651 align=center border=0>
    <TBODY>

    <TR>
        <TD height=50></TD>
    </TR>
    <TR>
        <TD height=351><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                <TBODY>

                <TR>
                    <TD width=15 background=<?php echo base_url()?>images/ileft.gif height=43></TD>
                    <TD width=620 background=<?php echo base_url()?>images/i_topbg2.gif><IMG
                            height=43 src="<?php echo base_url()?>images/i_top1.gif" width=43></TD>
                    <TD width=16><IMG height=43 src="<?php echo base_url()?>images/iright.gif"
                                      width=16></TD>
                </TR>
                <TR>
                    <TD background=<?php echo base_url()?>images/ileftbg.gif></TD>
                    <TD vAlign=center background=<?php echo base_url()?>images/bg.gif height=279><TABLE height=109 cellSpacing=0 cellPadding=0 width=369 align=center
                                                                                 border=0>
                            <TBODY>
                            <TR>
                                <TD width=155><IMG height=140
                                                   src="<?php echo base_url()?>images/logo.jpg" width=155 useMap=#Map
                                                   border=0></TD>
                                <TD vAlign=top align=left width=214><TABLE cellSpacing=0 cellPadding=0 width=167 border=0>
                                        <TBODY>

                                        <TR>
                                            <TD vAlign=bottom width=167 height=30><A
                                                    href="#"><IMG
                                                        height=19 src="<?php echo base_url()?>images/adminsyteam.gif"
                                                        width=154 border=0></A></TD>
                                        </TR>
                                        <TR>
                                            <TD height=123><TABLE height=109 cellSpacing=0 cellPadding=0
                                                                  align=center border=0>
                                                    <FORM id='login_form' name=form2 action="<?php echo site_url("user/admin_login")?>" method="post">

                                                        <TR>
                                                            <TD vAlign=bottom align=left width=44 height=28><DIV align=right><IMG height=14
                                                                                                                                  src="<?php echo base_url()?>images/id.gif" width=43></DIV></TD>
                                                            <TD vAlign=bottom align=left width=114
                                                                height=28><INPUT class=input_1 id=username size=15
                                                                                 name=username>
                                                            </TD>
                                                        </TR>
                                                        <TR>
                                                            <TD align=left height=20><DIV align=right><IMG height=14
                                                                                                           src="<?php echo base_url()?>images/pass.gif"
                                                                                                           width=43></DIV></TD>
                                                            <TD height=20><INPUT class=input_1 id=password
                                                                                 type=password size=15 name=password></TD>
                                                        </TR>
                                                        <TR>
                                                            <TD vAlign=center colSpan=2 height=25><DIV align=center>
                                                                    <INPUT type=image
                                                                           src="<?php echo base_url()?>images/b_login.gif" name=denglu>
                                                                    <IMG style="CURSOR: hand" id="clean"
                                                                         onclick=clean() height=21
                                                                         src="<?php echo base_url()?>images/b_clean.gif" width=73> </DIV></TD>
                                                        </TR>
                                                    </FORM>

                                                </TABLE></TD>
                                        </TR>
                                        </TBODY>
                                    </TABLE></TD>
                            </TR>
                            </TBODY>
                        </TABLE></TD>
                    <TD background=<?php echo base_url()?>images/irightbg.gif></TD>
                </TR>
                <TR>
                    <TD><IMG height=29 src="<?php echo base_url()?>images/i_bottom_left.gif"
                             width=15></TD>
                    <TD background=<?php echo base_url()?>images/i_bottom_bg.gif></TD>
                    <TD width=16><IMG height=29
                                      src="<?php echo base_url()?>images/i_bottom_right.gif"
                                      width=16></TD>
                </TR>
                </TBODY>
            </TABLE></TD>
    </TR>
    <TR>
        <TD height=1></TD>
    </TR>
    <TR>
        <TD>&nbsp;</TD>
    </TR>
    </TBODY>
</TABLE>
</BODY>
</HTML>
