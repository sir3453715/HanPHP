<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary"><?=$func_title?></h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">首頁</a></li>
            <li class="breadcrumb-item active"><?=$func_title?></li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="col-xs-12">
                <a class="btn btn-pink" href="javascript:history.back()"><i class="fa fa-reply"></i></a>
                <a href="javascript:window.location.reload();" class="btn btn-pink pull-right">
                    <i class="fa fa-refresh"></i>
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-validation">
                        <FORM METHOD="POST" class="form-horizontal col-md-12"  name="form2" ACTION="acl.php?func=update&id=<?=$admin_account?>">
                            <INPUT TYPE="hidden" NAME="total_id">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="button" onclick="javascript:history.go(-1);" class="btn btn-outline-secondary">上一頁 </button>&nbsp;
                                    <button type="button" class="btn btn-primary" onclick="chkdata();">更新</button>&nbsp;
                                    <button type="reset" class="btn btn-outline-secondary">取消</button>
                                </div>
                            </div>

                            <div class="panel panel-default panel-no-heading">
                                <div class="panel-heading"><b>權限設定</b></div>
                            <div class="panel-body"><br>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <div class="form-group row">
                                                <?php
                                                if($admin_account!=''):
                                                ?>
                                                    <!-- <div class="panel-body"> -->
                                                    <link rel="STYLESHEET" type="text/css" href="js/codebase/dhtmlx.css">
                                                    <script  src="js/codebase/dhtmlx.js"></script>
                                                    <script  src="js/codebase/dhtmlx_deprecated.js"></script>
                                                    <div id="treeboxbox_tree"></div>                               
                                                    <!-- </div> -->
                                                <?php
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div><br><br>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button type="button" onclick="javascript:history.go(-1);" class="btn btn-outline-secondary">上一頁</button>&nbsp;
                                            <button type="button" onclick="chkdata();" class="btn btn-primary">更新</button>&nbsp;
                                            <button type="reset" class="btn btn-outline-secondary">取消</button>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<!-- footer -->
<footer class="footer">
    <?php
    echo __FOOTER_COPYRIGHT;
    ?>
</footer>
<!-- End footer -->
<script>
    tree2 = new dhtmlXTreeObject("treeboxbox_tree","100%","100%",0);
    tree2.setSkin('dhx_skyblue');
    tree2.setImagePath("js/codebase/imgs/dhxtreeview_material/");
    tree2.enableCheckBoxes(1);
    tree2.enableThreeStateCheckboxes(true);
    //tree2.loadXML("test/tree3.xml");
    tree2.loadXML("acl.php?func=xml&id=<?=$admin_account?>&<?=time()?>");
</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function chkdata(){
    document.forms['form2'].elements['total_id'].value=tree2.getAllChecked();
    //alert(tree2.getAllChecked());
    document.forms['form2'].submit();
}
//-->
</SCRIPT>

