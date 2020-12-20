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
                            <div class="row">
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
                                            <a href="javascript:void(0);" onclick="changeon('chk','baby_product','status')">啟用</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeoff('chk','baby_product','status')">不啟用</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="batchdelete('chk','baby_product')">刪除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="<?=$func_page . '.php?func=insert&class_id=' . $class_id;?>">
                                <button type="button" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-plus"></i>新增</button>
                            </a>
                            <!-- <div class="dropdown"> -->
                                <button class="btn btn-outline-secondary m-b-10 m-l-5 dropdown-toggle" type="button" data-toggle="dropdown">狀態篩選
                                    <span class="caret"></span>
                                </button>
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
                            <!-- <form method="GET">
                            <div class="col-sm-4 col-lg-2">
                                <div class="form-group">
                                    <label class="control-label" for="class_id">商品名稱</label><input type="text" class="form-control input-sm" id="keyword" name="keyword" value="<?= htmlspecialchars($_GET['keyword']) ?>" size="30" />
                                </div>
                                <label class="control-label" for="class_id">啟用狀態</label>
                                <select name="status" id="status" class="form-control input-sm">
                                    <option value="" <?=($_GET['status']=='')?'selected':''?> >全部</option>
                                    <option value="1" <?=($_GET['status']==1 && $_GET['status']!='')?'selected':''?> >啟用</option>
                                    <option value="0" <?=($_GET['status']==0 && $_GET['status']!='')?'selected':''?>>未啟用</option>
                                </select>
                            </div>
                            <div class="col-sm-4 col-lg-2">
                                <label class="control-label" for="class_id">商品大分類</label>
                                <select name="class_id" id="class_id" class="form-control input-sm" onchange="chagneclass();">
                                <?php
                                        echo '<option value="">全部</option>';
                                        $strSQL = "SELECT * FROM product_class WHERE up_id='0' ORDER BY sort ASC";
                                        $product_classs = $db->Execute($strSQL);
                                        foreach ($product_classs as $product_class) {
                                            if($_GET['class_id']==$product_class['id']){
                                                $sel = 'selected';
                                            }else{
                                                $sel = '';
                                            }
                                            echo '<option value="'.$product_class['id'].'" '.$sel.'>'.$product_class['title'].'</option>';
                                        }
                                    ?>
                                </select>
                                <br/>
                                <label class="control-label" for="class_id">商品小分類</label>
                                <select name="id" id="id" class="form-control input-sm">
                                    <?php
                                    if($_GET['class_id']!=''):
                                        $strSQL = "SELECT * FROM product_class WHERE up_id='".$_GET['class_id']."' ORDER BY sort ASC";
                                        $product_classs = $db->Execute($strSQL);
                                        foreach ($product_classs as $product_class) {
                                            if($_GET['id']==$product_class['id']){
                                                $sel = 'selected';
                                            }else{
                                                $sel = '';
                                            }
                                            echo '<option value="'.$product_class['id'].'" '.$sel.'>'.$product_class['title'].'</option>';
                                        }
                                    endif;
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4 col-lg-2">
                                <div class="form-group">
                                    <label class="control-label text-hide">搜尋按鈕</label>
                                    <br/>
                                    <div class="input-group input-group-sm">
                                        <button type="submit" class="btn btn-default">送出</button>
                                    </div>
                                </div>
                            </div>
                            </form> -->
                    </div>
                    <br/><br/>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-defaultsort="disabled" class="text-center">選取</th>
                                    <!--<th class="text-center">顯示於首頁</th>-->
                                    <th data-defaultsort="disabled" class="text-center">商品名稱</th>
                                    <!-- <th data-defaultsort="disabled" class="hidden-xs text-center">發佈日期</th> -->
                                    <th class="hidden-xs text-center">排序</th>
                                    <th data-defaultsort="disabled" class="text-center">狀態</th>
                                    <th data-defaultsort="disabled" class="text-center">動作</th>
                                </tr>
                            </thead>
                            <tbody>                                        

                        <?php
                        $i = 1;
                        if (is_array($arr_data)):
                            foreach ($arr_data as $kk => $data)
                            {

                                $id = $data['id'];
                                $sort = $data['sort'];
                                $title = htmlspecialchars($data['title']);
                                if(is_array($arg)){
                                    foreach ($arg as $kk => $vv) {
                                        if($kk!='curr_page' && $vv!=''){
                                            $page_tmp .= "{$kk}={$vv}&";
                                        }
                                    }
                                }
                                ?>
                                <tr class="vertical-md-middle <?=($page_tmp!='')?'unsortable':''?>" id="n_<?=$data['id']?>">
                                            <td class="text-center">
                                                <label>
                                                    <input class="control-label" type="checkbox" value="<?= $data['id'] ?>" name="chk">
                                                </label>
                                             </td>
                                             <!--<td class="text-center"><?= $isindex ?></td>-->
                                            <td class="text-center">
                                                <a href="<?=$func_page;?>.php?func=update&id=<?= $data['id'] ?>" onclick="upd1(<?= $data['id'] ?>);
                                                        return false;"><?= $title ?></a>
                                            </td>
                                            <td class="form-inline hidden-xs text-center" data-value="<?=$sort?>">                                                
                                                <input type="text" id="sort_<?=$data['id']?>" class="form-control input-sm" value="<?=$sort?>" size="2" onchange="changesort(<?= $data['id'] ?>,'product')">
                                            </td>
                                            <td class="text-center">
                                            <?php
                                                if($data['status']==1){
                                                    echo '<span class="label label-success">啟用</span>';
                                                }else{
                                                    echo '<span class="label label-default">不啟用</span>';
                                                }
                                            ?>                                            
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-xs"> 
                                                    <a href="javascript:void(0);" onclick="upd1(<?= $data['id'] ?>);
                                                    return false;" title="編輯"><button type="button" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                    </button></a>
                                                    <a href="javascript:void(0);" onclick="del1(<?= $data['id'] ?>);
                                                        return false;" title="刪除"><button type="button" class="btn btn-warning">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button></a>
                                                    <a href="javascript:void(0);" onclick="copy1(<?= $data['id'] ?>);
                                                        return false;" title="複製"><button type="button" class="btn btn-danger">
                                                        <i class="fa fa-files-o "></i>
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
                            <div class="row">
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
                                            <a href="javascript:void(0);" onclick="changeon('chk','baby_product','status')">啟用</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeoff('chk','baby_product','status')">不啟用</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="batchdelete('chk','baby_product')">刪除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="<?=$func_page . '.php?func=insert&class_id=' . $class_id;?>">
                                <button type="button" class="btn btn-success btn-flat btn-addon m-b-10 m-l-5"><i class="ti-plus"></i>新增</button>
                            </a>
                            <!-- <div class="dropdown"> -->
                                <button class="btn btn-outline-secondary m-b-10 m-l-5 dropdown-toggle" type="button" data-toggle="dropdown">狀態篩選
                                    <span class="caret"></span>
                                </button>
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
