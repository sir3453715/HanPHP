
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
                <div class="form-body">
                    <form method="GET" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="class_id">訂單號碼/姓名</label>
                                <input type="text" name="keyword" id="keyword" value="<?=$keyword?>" class="form-control input-sm">
                                <div id="suggesstion-box"></div>
                                <label class="control-label" for="class_id">訂單狀態</label>
                                <select name="class_id" id="class_id" class="form-control input-sm">
                                    <?php
                                        echo '<option value="" >全部</option>';
                                        foreach ($arr_class as $key => $value) {
                                            $sek = '';
                                            if($_GET['class_id']==$key && $_GET['class_id']!=''){
                                                $sek = 'selected';
                                            }
                                            echo '<option value="'.$key.'" '.$sek.' >'.$value.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="class_id">開始日期</label><input type="date" class="form-control input-sm" value="<?=$start?>" name="start" size="5">
                                <label class="control-label" for="class_id">結束日期</label><input type="date" class="form-control input-sm" value="<?=$end?>" name="end" size="5">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="class_id">付款方式</label>
                                <select name="payment" id="payment" class="form-control input-sm">
                                    <?php
                                        echo '<option value="" >全部</option>';
                                        echo '<option value="信用卡線上刷卡" '.(($_GET['payment']=='信用卡線上刷卡' && $_GET['payment']!='')?'selected':'').' >信用卡線上刷卡</option>';
                                        echo '<option value="Web-ATM" '.(($_GET['payment']=='Web-ATM' && $_GET['payment']!='')?'selected':'').' >Web-ATM</option>';
                                        echo '<option value="超商代碼繳費" '.(($_GET['payment']=='超商代碼繳費' && $_GET['payment']!='')?'selected':'').' >超商代碼繳費</option>';
                                        echo '<option value="貨到付款" '.(($_GET['payment']=='貨到付款' && $_GET['payment']!='')?'selected':'').' >貨到付款</option>';
                                        echo '<option value="ATM轉帳" '.(($_GET['payment']=='ATM轉帳' && $_GET['payment']!='')?'selected':'').' >ATM轉帳</option>';
                                        echo '<option value="店面取貨付款" '.(($_GET['payment']=='店面取貨付款' && $_GET['payment']!='')?'selected':'').' >店面取貨付款</option>';
                                    ?>
                                </select>
                                <div id="suggesstion-box"></div>
                                <label class="control-label" for="class_id">付款狀態</label>
                                <select name="pay_state" id="pay_state" class="form-control input-sm">
                                    <?php
                                        echo '<option value="" >全部</option>';
                                        echo '<option value="1" '.(($_GET['pay_state']==1 && $_GET['pay_state']!='')?'selected':'').' >已付款</option>';
                                        echo '<option value="0" '.(($_GET['pay_state']==0 && $_GET['pay_state']!='')?'selected':'').' >未付款</option>';
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label text-hide">搜尋按鈕</label>
                                <div class="input-group input-group-sm">
                                    <button type="submit" value="搜尋" id="output" name="output" class="btn btn-outline-secondary">送出</button>
                                </div>
                                <label class="control-label text-hide">匯出按鈕</label>
                                <div class="input-group input-group-sm">
                                    <button type="submit" value="匯出" id="output" name="output" class="btn btn-outline-secondary">匯出</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    <!-- <div align="right"><font color="red"><b>*訂單若經過三天仍未付款，訂單自動取消，貨到付款、到店自取、超商取貨付款除外！</b></font></div> -->
                </div>
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
                                            <a href="javascript:void(0);" onclick="changeon('chk','member','status')">啟用</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeoff('chk','member','status')">不啟用</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="batchdelete('chk','member')">刪除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">                        
                            <!-- <div class="dropdown"> -->
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
                                <th class="text-center">選取</th>
                                    <!-- <th class="text-center">訂單流水號</th> -->
                                    <th class="text-center">訂單時間</th>
                                    <th class="text-center">訂單號碼</th>
                                    <th class="text-center">姓名</th>                                             
                                    <th class="text-center">狀態</th>
                                    <th class="text-center">付款方式</th>
                                    <th class="text-center">付款</th>
                                    <th class="text-center">處理狀態</th>
                                    <th class="hidden-xs text-center">付款日期</th>
                                    <th class="text-center">應付金額</th>
                                    <th class="text-center">動作</th>
                                    <!-- <th class="text-center">發票</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            if (is_array($arr_data)):
                                foreach ($arr_data as $kk => $data)
                                {
                                    $id = $data['sn'];
                                    $state = $data['state'];
                                    $seccode = $data['seccode'];
                                    $addtime = date('Y-m-d H:i:s',$data['addtime']);
                                    if($data['pay_time']!=0){
                                        $pay_time = date('Y-m-d',$data['pay_time']);
                                    }else{
                                        $pay_time = '';
                                    }		
                                    if($data['isread']==0){
                                        $status='<span class="label label-danger">未讀</span>';
                                    }elseif($data['isread']==1){
                                        $status='<span class="label label-success">已讀</span>';
                                    }else{
                                        $status='<span class="label label-default">已回覆</span>';
                                    }				
                                // $pay_time = $data['pay_time'];
                                $pay_state = $data['pay_state'];
                                $total = $data['total'];
                            ?>
                                <tr class ="unsortable">
                                    <td class="text-center">
                                                <label>
                                                    <input class="control-label" type="checkbox" value="<?= $data['sn'] ?>" name="chk">
                                                </label>
                                             </td>
                                             <!-- <td class="text-center"><?= substr(date('Y',$data['addtime']),2,2).date('md',$data['addtime']).sprintf("%05d", $data['number']) ?></td> -->
                                             <td class="text-center"><?= $addtime ?></td>
                                             <td class="text-center"><a href="javascript:void(0);" onclick="upd1(<?= $data['sn'] ?>);
                                                        return false;"><?= $seccode ?></a></td>
                                            <td class="text-center"><?= $data['payer_name'] ?></td>
                                            <td class="text-center"><?= $status ?></td>
                                            <td class="text-center"><?= $data['payment'] ?></td>
                                            <td class="text-center">
                                                <?php
                                                    if($pay_state==0){
                                                        echo '<span class="label label-default">未付款</span>';
                                                    }elseif($pay_state==1){
                                                        echo '<span class="label label-success">付款成功</span>';
                                                    }elseif($pay_state==2){
                                                        echo '<span class="label label-primary">付款失敗</span>';
                                                    }elseif($pay_state==3){
                                                        echo '<span class="label label-danger">取消付款</span>';
                                                    }
												?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                if ($state == '0'){
                                                    echo '<span class="label label-danger">待處理</span>';
                                                }else if ($state == '1'){
                                                    echo '<span class="label label-info">處理中</span>';
                                                }else if ($state == '2'){
                                                    echo '<span class="label label-warning">備貨中</span>';
                                                }else if ($state == '3'){
                                                    echo '<span class="label label-primary">已出貨</span>';
                                                }else if ($state == '4'){
                                                    echo '<span class="label label-success">訂單完成</span>';
                                                }else if ($state == '5'){
                                                    echo '<span class="label label-default">訂單取消</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="hidden-xs text-center"><?=$pay_time ?></td>
                                            <td class="text-center"><?=number_format($total) ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-xs"> 
                                                <a href="javascript:void(0);" onclick="upd(<?= $data['sn'] ?>);
                                                return false;" title="檢視"><button type="button" class="btn btn-primary">
                                                <span class="fa fa-eye"></span>
                                            </button></a>
                                            
                                                </div>
                                                <div class="btn-group btn-group-xs"> 
                                                    <a href="javascript:void(0);" onclick="print(<?= $data['sn'] ?>);
                                                    return false;" title="列印出貨單"><button type="button" class="btn btn-warning">
                                                        <span class="fa fa-print"></span>
                                                    </button></a>
                                                        
                                                    </button></a>
                                                </div>
                                            </td>
                                            <td>
                                            <?php if($data['InvoiceNumber']=='' && $data['ticktype']!='1' && $data['state']==3): ?>
                                            <!-- <a href="ec_invoice.php?sn=<?=$data['sn']?>">開立</a> -->
                                            <?php endif; ?>
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
                                            <a href="javascript:void(0);" onclick="changeon('chk','member','status')">啟用</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="changeoff('chk','member','status')">不啟用</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="batchdelete('chk','member')">刪除</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">                         
                            <!-- <div class="dropdown"> -->
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
<script>
    function print(o_sn){
        window.open('print_shipper.php?sn='+o_sn,'print_shipper','resizable=yes,scrollbars=yes,width=683,height=550');
    }
</script>