<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary"><?= htmlspecialchars($func_title) ?></h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">首頁</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($func_title) ?></li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->
<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">                
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- <div class="row">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary m-l-12 dropdown-toggle" type="button" data-toggle="dropdown">選取
                                            <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" onclick="selAll('chk')">全選</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="usel('chk')">反選</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="unselAll('chk')">全部取消</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary m-l-12 dropdown-toggle" type="button" data-toggle="dropdown">動作
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeon('chk','apply','status')">啟用</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeoff('chk','apply','status')">不啟用</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="batchdelete('chk','apply')">刪除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-sm-6 text-right">
                            <!-- <a href="<?=$func_page . '.php?func=insert&class_id=' . $class_id;?>">
                                <button type="button" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-plus"></i>新增</button>
                            </a> -->
                            <!-- <div class="dropdown"> -->
                                <!-- <button class="btn btn-outline-secondary m-b-10 m-l-5 dropdown-toggle" type="button" data-toggle="dropdown">狀態篩選
                                    <span class="caret"></span>
                                </button> -->
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="?">全部顯示</a>
                                    </li>
                                    <li>
                                        <a href="?&status=1">啟用</a>
                                    </li>
                                    <li>
                                        <a href="?&status=0">不啟用</a>
                                    </li>
                                </ul>
                            <!-- </div> -->
                            <!--button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-print"></span>
                            </button-->
                            <a href="javascript:window.location.reload();"><button type="button" class="btn btn-outline-secondary m-b-10 m-l-5">
                                <i class="fa fa-refresh"></i>
                            </button></a>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="hidden-xs text-center">寄件時間</th>
                                    <th class="text-center">寄件人</th>
                                    <!-- <th class="text-center">主旨</th>                                             -->
                                    <th class="text-center">狀態</th>                                            
                                    <th class="text-center">動作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $i = 1;
                                if (is_array($arr_data)):
                                    foreach ($arr_data as $kk => $data)
                                    {
                                        $id = $data['id'];
                                        $create_date = date('Y-m-d H:i:s',$data['create_date']);
                                        $name = htmlspecialchars($data['name']);
                                        if($data['isread']==0){
                                            $status='<span class="label label-danger">未讀</span>';
                                        }elseif($data['isread']==1){
                                            $status='<span class="label label-success">已讀</span>';
                                        }else{
                                            $status='<span class="label label-default">已回覆</span>';
                                        }
                                        ?>
                                        <tr class ="unsortable">
                                            <td class="text-center"><?= $create_date ?></td>
                                            <!-- <td class="text-center"><?= $name ?></td> -->
                                            <td class="text-center">
                                                <a href="#" onclick="upd(<?= $data['id'] ?>);
                                                        return false;"><?= $name ?></a>
                                            </td>
                                            <td class="text-center"><?= $status ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-xs"> 
                                                <a href="javascript:void(0);" onclick="upd(<?= $data['id'] ?>);
                                                    return false;" title="編輯"><button type="button" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                    </button></a>
                                                    <a href="javascript:void(0);" onclick="del(<?= $data['id'] ?>);
                                                        return false;" title="刪除"><button type="button" class="btn btn-warning">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button></a>
                                                </div>
                                            </td>
                                            </tr>
                                        <?php
                                        $i++;
                                    }
                                endif;
                                ?>

                            </tbody>
                        </table>
                    </div>
                    </div>
                    <br/><br/>
                    <div class="row">
                        <div class="col-md-6">
                             <p class="text-secondary">目前位於第 <?=$curr_page?> / <?=$last_page?> 頁,共 <span class="badge"><?= $rows ?></span> 筆資料</p>
                        </div>
                        <div class="col-md-6 text-right">
                                <?php
                                FuncSite::fore_page($curr_page, $last_page,$arg);
                                ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- <div class="row">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary m-l-12 dropdown-toggle" type="button" data-toggle="dropdown">選取
                                            <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" onclick="selAll('chk')">全選</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="usel('chk')">反選</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="unselAll('chk')">全部取消</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary m-l-12 dropdown-toggle" type="button" data-toggle="dropdown">動作
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeon('chk','apply','status')">啟用</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeoff('chk','apply','status')">不啟用</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="batchdelete('chk','apply')">刪除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-sm-6 text-right">
                            <!-- <a href="<?=$func_page . '.php?func=insert&class_id=' . $class_id;?>">
                                <button type="button" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-plus"></i>新增</button>
                            </a> -->
                            <!-- <div class="dropdown"> -->
                                <!-- <button class="btn btn-outline-secondary m-b-10 m-l-5 dropdown-toggle" type="button" data-toggle="dropdown">狀態篩選
                                    <span class="caret"></span>
                                </button> -->
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="?">全部顯示</a>
                                    </li>
                                    <li>
                                        <a href="?&status=1">啟用</a>
                                    </li>
                                    <li>
                                        <a href="?&status=0">不啟用</a>
                                    </li>
                                </ul>
                            <!-- </div> -->
                            <!--button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-print"></span>
                            </button-->
                            <a href="javascript:window.location.reload();"><button type="button" class="btn btn-outline-secondary m-b-10 m-l-5">
                                <i class="fa fa-refresh"></i>
                            </button></a>
                        </div>
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

<?php
// print_r($now_menu);
?>
        <!-- wrapper -->
            <div class="content" data-pg-name="div.content">
                <div id="c-topbar01" class="c-topbar topbar clearfix" data-pgc="c-topbar01">
                    <h1 class="pull-left h3" data-pgc-field="topba01Title"><?= htmlspecialchars($now_menu['menu_name']) ?></h1>
                    <!--ol class="breadcrumb c-breadcrumb01" id data-pgc="c-breadcrumbs01" data-pgc-field="breadcrumbs01"> 
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="#">Library</a>
                        </li>                         
                        <li class="active">Data</li>
                    </ol-->
                </div>
                <div class="itopbar" data-pgc-field="itopbar">
                    <div id="c-topbar02" class="row c-topbar" data-pgc="c-topbar02">
                        <div class="col-sm-6">
                        </div>
                        <div class="text-right col-sm-6">
                            <!--<a href="<?= $func_page . '.php?func=insert' ?>"><button type="button" class="btn btn-sm btn-primary">
                                <span class="glyphicon glyphicon-plus"></span> 新增
                            </button></a>    -->                       
                            <a href="javascript:window.location.reload();"><button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-refresh"></span>
                            </button></a>
                        </div>
                    </div>
                </div>
                <div class="ibox" data-pg-name="div.ibox" data-pgc-field="ibox">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>                                        

                       
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" data-pgc="c-pagination01">
                        <div class="col-md-6">
                             <p class="text-info">目前位於第 <?=$curr_page?> / <?=$last_page?> 頁,共 <span class="badge"><?= $rows ?></span> 筆資料</p>
                        </div>
                        <div class="col-md-6 text-right">
                                <?php
                                FuncSite::fore_page($curr_page, $last_page);
                                ?>
                        </div>
                    </div>
                    <div id="c-topbar02" class="row c-topbar" data-pgc="c-topbar02">
                        <div class="col-sm-6">
                        </div>
                        <div class="text-right col-sm-6">
                            <!--<a href="<?= $func_page . '.php?func=insert' ?>"><button type="button" class="btn btn-sm btn-primary">
                                <span class="glyphicon glyphicon-plus"></span> 新增
                            </button></a>-->
                            <a href="javascript:window.location.reload();"><button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-refresh"></span>
                            </button></a>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer" data-pgc="c-footer01">
                <?php
                echo __FOOTER_COPYRIGHT;
                ?>
            </footer>
            <div id="c-modal11" class="modal fade pg-show-modal" tabindex="-1" role="dialog" data-pgc="c-modal11">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Modal Remote title</h4>
                        </div>
                        <div class="modal-body">
                            <p><i class="fa fa-refresh fa-spin"></i> Loading&hellip;</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer -->
            <!-- Modal -->
