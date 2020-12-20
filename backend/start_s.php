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
    <div class="col-lg-12">
        <!-- <div class="panel panel-default">
            <div class="panel-heading">最新訂單
            </div>
            <table class="table"> 
                <thead>
                    <tr>
                        <th class="text-center">訂單日期</th>
                        <th class="text-center">訂單號碼</th>
                        <th class="text-center">收件人</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $strSQL = "SELECT * FROM orders WHERE isread = 0 ORDER BY addtime DESC LIMIT 10";        
                        $orders = $db->Execute($strSQL);
                        foreach ($orders as $order) :
                    ?>
                    <tr>
                        <td class="text-center"><?=date('Y-m-d H:i:s',$order['addtime'])?></td>
                        <td class="text-center">
                            <a href="orders.php?func=update&id=<?=$order['sn']?>"><?=$order['seccode']?></a>
                        </td>
                        <td class="text-center"><?=$order['for_name']?></td>
                    </tr>        
                    <?php endforeach;?>                              
                </tbody>
            </table>
            <?php if($count_orders[0]['count(*)']-10>0):?>
            <div class="panel-footer">
                <small>未讀未處理訂單!</small>
                <span class="pull-right"><a href="orders.php">尚有 <?=$count_orders[0]['count(*)']-10?> 筆未處理訂單</a></span>
            </div>
            <?php endif;?> -->
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">登入紀錄</div>
            <table class="table"> 
                <thead>
                    <tr>
                        <th class="text-center">姓名</th>
                        <th class="text-center">IP</th>
                        <th class="text-center">登入時間</th>
                    </tr>
                </thead>
                <tbody> 
                <?php
                foreach ($arr_data as $data):
                ?>
                    <tr>
                        <td class="text-center"><?=$data['member_name']?></td>
                        <td class="text-center"><?=$data['client_ip']?></td>
                        <td class="text-center"><?=$data['update_time']?></td>
                    </tr>
                <?php
                endforeach;
                ?>                                       
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- footer -->
<footer class="footer">
    <?php
        echo __FOOTER_COPYRIGHT;
    ?>
</footer>
<!-- End footer -->
