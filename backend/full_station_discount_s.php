<?php
// print_r($now_menu);
?>
        <!-- wrapper -->
            <div class="content" data-pg-name="div.content">
                <div id="c-topbar01" class="c-topbar topbar clearfix" data-pgc="c-topbar01">
                    <h1 class="pull-left h3" data-pgc-field="topba01Title"><?= htmlspecialchars($func_title) ?></h1>
                    <!--ol class="breadcrumb c-breadcrumb01" id data-pgc="c-breadcrumbs01" data-pgc-field="breadcrumbs01"> 
                        <li>
                            <a href="javascript:void(0);">Home</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Library</a>
                        </li>                         
                        <li class="active">Data</li>
                    </ol-->
                </div>
                <div class="itopbar" data-pgc-field="itopbar">
                    <div id="c-topbar02" class="row c-topbar" data-pgc="c-topbar02">
                        <div class="col-sm-6">            
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> 選取
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
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
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> 動作
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:void(0);" onclick="changeon('chk','discount','status')">啟用</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="changeoff('chk','discount','status')">不啟用</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="batchdelete('chk','discount')">刪除</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-right col-sm-6">
                            <a href="<?=$func_page . '.php?func=insert&class_id=' . $class_id;?>"><button type="button" class="btn btn-sm btn-primary">
                                <span class="glyphicon glyphicon-plus"></span> 新增
                            </button></a>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> 狀態篩選
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="?class_id=<?=$class_id?>">全部顯示</a>
                                    </li>
                                    <li>
                                        <a href="?class_id=<?=$class_id?>&status=1">啟用</a>
                                    </li>
                                    <li>
                                        <a href="?class_id=<?=$class_id?>&status=0">不啟用</a>
                                    </li>
                                </ul>
                            </div>
                            <!--button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-print"></span>
                            </button-->
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
                                        <tr>
                                            <th class="text-center">選取</th>
                                            <th class="text-center">標題</th>
                                            <th class="hidden-xs text-center">開始時間</th>                                            
                                            <th class="hidden-xs text-center">結束時間</th>                                            
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
                                $onshelf = date('Y-m-d H:i',$data['onshelf']);
                                $offshelf = date('Y-m-d H:i',$data['offshelf']);
                                $title = htmlspecialchars($data['title']);
                                ?>
                                <tr class ="unsortable">
                                            <td class="text-center">
                                                <label>
                                                    <input class="control-label" type="checkbox" value="<?= $data['id'] ?>" name="chk">
                                                </label>
                                             </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" onclick="upd(<?= $data['id'] ?>);
                                                        return false;"><?= $title ?></a>
                                            </td>
                                            <td class="text-center"><?= $onshelf ?></td>
                                            <td class="text-center"><?= $offshelf ?></td>
                                            <td class="text-center">
                                            <?php
                                                if($data['status']==1){
                                                    echo '<span class="label label-success">啟用</span>';
                                                }else{
                                                    echo '<span class="label label-default">不啟用</span>';
                                                }
                                            ?>       
                                            <td class="text-center">
                                                <div class="btn-group btn-group-xs"> 
                                                    <a href="javascript:void(0);" onclick="upd(<?= $data['id'] ?>);
                                                        return false;" title="編輯"><button type="button" class="btn btn-default">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button></a>
                                                    <a href="javascript:void(0);" onclick="del(<?= $data['id'] ?>);
                                                        return false;" title="刪除"><button type="button" class="btn btn-default">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button></a>
                                                </div>
                                            </td>
                                            </tr>
                                <?php
                                $i++;
                            }
                        endif;
                        ?>
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
                                FuncSite::fore_page($curr_page, $last_page,$arg);
                                ?>
                        </div>
                    </div>
                    <div id="c-topbar02" class="row c-topbar" data-pgc="c-topbar02">
                        <div class="col-sm-6">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> 選取
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
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
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> 動作
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:void(0);" onclick="changeon('chk','discount','status')">啟用</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="changeoff('chk','discount','status')">不啟用</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="batchdelete('chk','discount')">刪除</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-right col-sm-6">
                            <a href="<?=$func_page . '.php?func=insert&class_id=' . $class_id;?>"><button type="button" class="btn btn-sm btn-primary">
                                <span class="glyphicon glyphicon-plus"></span> 新增
                            </button></a>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> 狀態篩選
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="?class_id=<?=$class_id?>">全部顯示</a>
                                    </li>
                                    <li>
                                        <a href="?class_id=<?=$class_id?>&status=1">啟用</a>
                                    </li>
                                    <li>
                                        <a href="?class_id=<?=$class_id?>&status=0">不啟用</a>
                                    </li>
                                </ul>
                            </div>
                            <!--button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-print"></span>
                            </button-->
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
            <script type="text/javascript">
            function upd1(id) {
                location.href = "<?=$func_page;?>.php?&func=update&id=" + id + '&class_id=<?=$class_id;?>';
                return false;
            }
            function del1(id){
              reset();
              alertify.confirm("確定要刪除?", function (e) {
                console.log(e);
                if (e) {
                  location.href = "<?=$func_page;?>.php?&func=delete&id=" + id + '&class_id=<?=$class_id;?>';
                } else {
                  alertify.error("你已點選取消!");
                }
              }); 
              return false;
            }
            </script>
            <!-- footer -->
            <!-- Modal -->
