<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $orders_id = $_GET['id'];
        $strSQL = "SELECT * FROM orders where sn = '$orders_id'";        
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }		

		//更新為已讀
		$data = array('isread'=>'1',);
        $db->update('orders',$data,"sn = '$orders_id'");

		$old_state = $arr_data[0]['state'];
		$old_seccode = $arr_data[0]['seccode'];
		
		$strSQL = "SELECT * FROM orders_item where order_sn = '$orders_id'";        
        $arr_data2 = $db->Execute($strSQL);
		$content="<table class='table table-bordered' width='100%'>";
        $content.= "<tr class ='unsortable'>
                        <th class='text-center' style='color:#99abb4;'>名稱</th>
                        <th class='text-center' style='color:#99abb4;'>單價</th>
                        <th class='text-center' style='color:#99abb4;'>數量</th>
                        <th class='text-center' style='color:#99abb4;'>小計</th>
                        <th class='text-center' style='color:#99abb4;'>備註</th>
                    <tr class ='unsortable'>";
        $i = 1;
        $notot = 0;
        if (is_array($arr_data2)):
            foreach ($arr_data2 as $kk => $data)
            {
                $id = $data['sn'];
                $name = $data['name'];
                $num = $data['num'];
                $price = $data['price'];
                $stot = $price * $num;
                $notot += $stot;
                switch ($data['ipp']) {
                    case 0:
                        $ipp = '購買商品';
                        break;
                    case 1:
                        $ipp = '加價購商品';
                        break;
                    case 2:
                        $ipp = '滿額贈商品';
                        break;
                }
                $content.="<tr class='unsortable'>";
                $content.='<td class="text-center">'.$name . '</td><td class="text-center">' . number_format($price) . '<td class="text-center">'.$num . '</td><td class="text-center">'.number_format($stot) . '<td class="text-center">'.$ipp . '</td>';
                $i++;
            }
        endif;
        $content.="<tr class ='unsortable'><td class='text-center'>小計</td><td colspan='2'></td><td class='text-center'>".number_format($notot)."</td></tr>";
        $content.="<tr class ='unsortable'><td class='text-center'>運費</td><td colspan='2' ></td><td class='text-center'>".number_format($arr_data[0]['ship'])."</td></tr>";
        $content.="<tr class ='unsortable'><td class='text-center'>手續費</td><td colspan='2' ></td><td class='text-center'>".number_format($arr_data[0]['fees'])."</td></tr>";
        if($arr_data[0]['coupon_discount']!=''){
            $content.="<tr class ='unsortable'><td class='text-center'>優惠券</td><td colspan='2' ></td><td class='text-center'>".($arr_data[0]['coupon_discount'])."</td></tr>";
        }
        if($arr_data[0]['cash_discount']>0){
            $content.="<tr class ='unsortable'><td class='text-center'>滿額現折</td><td colspan='2' ></td><td class='text-center'>-".number_format($arr_data[0]['cash_discount'])."</td></tr>";
        }
        if($arr_data[0]['full_station_discount']>0){
            $content.="<tr class ='unsortable'><td class='text-center'>全站折扣</td><td colspan='2' ></td><td class='text-center'>".number_format($arr_data[0]['full_station_discount'])."折</td></tr>";
        }
        if($arr_data[0]['red_use']>0){
            $content.="<tr class ='unsortable'><td class='text-center'>紅利折抵</td><td colspan='2' ></td><td class='text-center'>-".number_format($arr_data[0]['red_use'])."</td></tr>";
        }
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }			
            // if (Func::get_client_ip() == "114.46.51.8") {

            // }
            if($state==5 && $arr_data[0]['state']!=5){//訂單取消
                ?>            
                <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
                    ga('create', 'UA-111731983-1', 'auto');
                    ga('set', 'currencyCode', 'TWD');
                    ga('set', '&uid', '<?=$arr_data[0]['cust_id']?>');
                    ga('require', 'ec');
                    ga('ec:setAction', 'refund', {
                        'id': '<?=$arr_data[0]['seccode']?>'
                    });
                    ga('send', 'pageview'); 
                </script>
                <?php
            }

            if($state==4 && $arr_data[0]['state']!=4){//訂單完成
                if($arr_data[0]['state']==5){//原為取消訂單
                    $data = array('isset'=>1);
                    $db->update('orders',$data,"sn = '$orders_id'");                    
                    ?>
                    <script>
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
                        ga('create', 'UA-111731983-1', 'auto');
                        ga('set', 'currencyCode', 'TWD');
                        ga('set', '&uid', '<?=$arr_data[0]['cust_id']?>');
                        ga('require', 'ec');
                    </script>
                    <?php
                    $db->insert('point',$data);
                    $strSQL = "SELECT * FROM orders_item WHERE order_sn=" .$arr_data[0]['sn'];
                    $orders_item = $db->Execute($strSQL);
                    foreach ($orders_item as $value) :
                    ?>
                    <script>
                        ga('ec:addProduct', {
                            'id': '<?=$value['item_sn']?>',
                            'name': '<?=$value['name']?>',
                            'price': '<?=$value['price']?>.00',
                            'quantity': '<?=$value['num']?>'
                        });
                    </script>
                    <?php
                    endforeach;
                    ?>
                    <script>
                        ga('ec:setAction', 'purchase', {
                            'id': '<?=$arr_data[0]['seccode']?>',
                            'option': '<?=$arr_data[0]['payment']?>',
                            'affiliation': '杏屋乳酪蛋糕',
                            'revenue': '<?=$arr_data[0]['total']?>.00',
                            'shipping': '<?=$arr_data[0]['ship']?>.00',
                            'coupon': '<?=$arr_data[0]['coupon_discount_code']?>'
                        });
                        ga('send', 'pageview'); 
                    </script>
                <?php
                }else{
                    $data = array('pay_state'=>1,'pay_time'=>time());
                    $db->update('orders',$data,"sn = '$orders_id'");
                }
            }                    
                $ship_date = strtotime($ship_date);
                $data = array(
                    'pay_state'=>$pay_state,
                    'state'=>$state,
                    'ship_no'=>$ship_no,
                    'home_delivery'=>$home_delivery,
                    'admin_note'=>$admin_note,
                    'update_date'=>time(),
                );
                $a = $db->update('orders',$data,"sn = '$orders_id'");
            if($pay_state ==1 &&$arr_data[0]['pay_state']!=1){
                $data = array('pay_time'=>time());
                $db->update('orders',$data,"sn = '$orders_id'");
            }
            if($state==3 && $arr_data[0]['state']!=3){//改為已出貨                
                $data = array('ship_date'=>time());                
                $db->update('orders',$data,"sn = '$orders_id'");
            }

            if(!$a){
                if($arr_data[0]['state']!=$state){
                    $change .= '將「'.$arr_class[$arr_data[0]['state']].'」，修改成「'.$arr_class[$state].'」、';
                }
                if($arr_data[0]['pay_state']!=$pay_state){
                    $change .= '將「'.$arr_pay_state[$arr_data[0]['pay_state']].'」，修改成「'.$arr_pay_state[$pay_state].'」、';
                }
                if($arr_data[0]['ship_date']!=$ship_date){
                    $change .= '將「'.date('Y-m-d',$arr_data[0]['ship_date']).'」，修改成「'.date('Y-m-d',$ship_date).'」、';
                }
                if($arr_data[0]['ship_no']!=$ship_no){
                    $change .= '將「'.$arr_data[0]['ship_no'].'」，修改成「'.$ship_no.'」、';
                }
                if($arr_data[0]['home_delivery']!=$home_delivery){
                    $change .= '將「'.$arr_data[0]['home_delivery'].'」，修改成「'.$home_delivery.'」、';
                }
                if($arr_data[0]['admin_note']!=$admin_note){
                    $change .= '將「'.$arr_data[0]['admin_note'].'」，修改成「'.$admin_note.'」、';
                }
                $change = mb_substr($change,0,-1);
                if($change!=''){
                    $data = array('create_date'=>date('Y-m-d H:i:s'),'action'=>'修改訂單：'.$arr_data[0]['seccode'].'，'.$change,'member_name'=>Session::get('member_name',SESSION_BACKEND));
                    $db->insert('operating_log',$data);
                }
                FuncSite::msg_box('更新成功！');
            }else{
                FuncSite::msg_box_error('更新失敗！');
            }       
            $tmp = '';
            if(is_array($arg)){
                foreach ($arg as $kk => $vv) {
                    if($kk!='func' && $kk!='id'):
                        $tmp .= "{$kk}={$vv}&";
                    endif;
                }
            }
            Func::go_to($func_page . '.php?&'.$tmp);
            exit;
        }
        $data = array();
        
        if($arr_data[0]['state']==3 || $arr_data[0]['state']==4){
            $state_sel = 'select_show';
        }else{
            $state_sel = 'select';
        }
        array_push($data, array(
            'title' => '訂單狀態',
            'type' => 'select',
            'name' => 'state',
            'value' => $arr_data[0]['state'],
            'options'=>$arr_class
            )
        );
        if($arr_data[0]['payment']=='信用卡線上刷卡'||$arr_data[0]['payment']=='Web-ATM'||$arr_data[0]['payment']=='超商代碼繳費'){
            array_push($data, array(
                'title' => '付款狀態',
                'type' => 'select_show',
                'name' => 'pay_state1',
                'options' => $arr_pay_state ,
                'value' =>$arr_data[0]['pay_state']
                )
            ); 
            array_push($data, array(
                'title' => '付款狀態',
                'type' => 'hidden',
                'name' => 'pay_state',
                'value' =>$arr_data[0]['pay_state']
                )
            ); 
        }else{
            array_push($data, array(
                'title' => '付款狀態',
                'type' => 'select',
                'name' => 'pay_state',
                'options' => $arr_pay_state ,
                'value' =>$arr_data[0]['pay_state']
                )
            ); 
        }

        if($arr_data[0]['pay_state']==1){
            array_push($data, array(
                'title' => '付款時間',
                'type' => 'text_show',
                'value' =>  date('Y-m-d H:i:s',$arr_data[0]['pay_time'])
                )
            );
        }       
        if($arr_data[0]['payment']=='信用卡線上刷卡'){
            array_push($data, array(
                'title' => '綠界交易序號',
                'type' => 'text_show',
                'value' => $arr_data[0]['TradeNo']
                )
            );
            array_push($data, array(
                'title' => '綠界訂單編號',
                'type' => 'text_show',
                'value' => $arr_data[0]['tmp_ordercode']
                )
            );
        }
        if($arr_data[0]['FundTime']!=''){
            array_push($data, array(
                'title' => '預計撥款日',
                'type' => 'text_show',
                'value' => date('Y-m-d',$arr_data[0]['FundTime'])
                )
            );
        }
        array_push($data, array(
            'title' => '取貨方式',
            'type' => 'text_show',
            'value' => $arr_data[0]['freight']
            )
        );
        array_push($data, array(
            'title' => '付款方式',
            'type' => 'text_show',
            'value' => $arr_data[0]['payment']
            )
        );
        if($arr_data[0]['payment']=='信用卡線上刷卡'){
            array_push($data, array(
                'title' => '信用卡卡號',
                'type' => 'text_show',
                'value' => $arr_data[0]['Card4No']
                )
            );
        }else if($arr_data[0]['payment']=='超商代碼繳費'){
            array_push($data, array(
                'title' => '超商繳費代碼',
                'type' => 'text_show',
                'value' => $arr_data[0]['CodeNo']
                )
            );
            array_push($data, array(
                'title' => '繳費期限',
                'type' => 'text_show',
                'value' => $arr_data[0]['ExpireDate']
                )
            );
        }else if($arr_data[0]['payment']=='Web-ATM'){
            array_push($data, array(
                'title' => '銀行代碼',
                'type' => 'text_show',
                'value' => $arr_data[0]['BankNo']
                )
            );
            array_push($data, array(
                'title' => '銀行帳號末五碼',
                'type' => 'text_show',
                'value' => $arr_data[0]['VirtualAccount']
                )
            );
        }
        if($arr_data[0]['freight'] =='店取'){
                array_push($data, array(
                    'title' => '取貨店家',
                    'type' => 'text_show',
                    'value' => $arr_data[0]['pickup_store']
                    )
                );
            }
        array_push($data, array(
            'title' => '取貨時間',
            'type' => 'text_show',
            'value' => ($arr_data[0]['pickup_date']." ".$arr_data[0]['pickup_time'])
            )
        );
        // array_push($data, array(
        //     'title' => '取貨時間',
        //     'type' => 'text_show',
        //     'value' => $arr_data[0]['pickup_time']
        //     )
        // );
        switch ($orders[0]['ticktype']) {
            case 0:
                $tick = '個人(二聯式發票)';
              break;
            case 1:
                $tick = '三聯式發票';
              break;
          }
        array_push($data, array(
            'title' => '發票類型',
            'type' => 'text_show',
            'value' => $tick
            )
        );
        if($arr_data[0]['ticktype']=='1'){        
            array_push($data, array(
                'title' => '公司抬頭',
                'type' => 'text_show',
                'value' => $arr_data[0]['tickName']
                )
            );
            array_push($data, array(
                'title' => '統一編號',
                'type' => 'text_show',
                'value' => $arr_data[0]['tickNo']
                )
            );
        }
        if($arr_data[0]['tickTitle']!=''){
            array_push($data, array(
                'title' => '手機條碼',
                'type' => 'text_show',
                'value' => $arr_data[0]['tickTitle']
                )
            );
        }   
        if($arr_data[0]['ship_date']==0 || $arr_data[0]['ship_date']==''){
            $ship_date = '';
        }else{
            $ship_date = date('Y-m-d',$arr_data[0]['ship_date']);
        }
		array_push($data, array(
            'title' => '出貨日期',
            'type' => 'date',
            'name' => 'ship_date',
            'value' => $ship_date
            )
        );
        // array_push($data, array(
        //     'title' => '物流宅配',
        //     'type' => 'text',
        //     'name' => 'home_delivery',
        //     'value' => $arr_data[0]['home_delivery']
        //     )
        // );
        // array_push($data, array(
        //     'title' => '宅配單號',
        //     'type' => 'text',
        //     'name' => 'ship_no',
        //     'value' => $arr_data[0]['ship_no']
        //     )
        // );
        array_push($data, array(
            'title' => '訂單內容',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
            'title' => '訂單號碼',
            'type' => 'text_show',
            'value' =>$arr_data[0]['seccode']
            )
        );
        array_push($data, array(
            'title' => '訂單流水號',
            'type' => 'text_show',
            'value' => substr(date('Y',$arr_data[0]['addtime']),2,2).date('md',$arr_data[0]['addtime']).sprintf("%05d", $arr_data[0]['number'])
            )
        );
        array_push($data, array(
            'title' => '訂單時間',
            'type' => 'text_show',
            'value' =>date('Y-m-d H:i:s',$arr_data[0]['addtime'])
            )
        );
        array_push($data, array(
            'title' => '訂購內容',
            'type' => 'show1',
            'name' => 'content',
            'value' => $content . "<tr class ='unsortable'><td class='text-center'>總計</td><td colspan='2' ></td><td class='text-center'>".number_format($arr_data[0]['total'])."</td></tr></table>"
            )
        );
        array_push($data, array(
           'title' => '購買人資訊',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
            'title' => '姓名',
            'type' => 'text_show',
            'value' => $arr_data[0]['payer_name']
            )
        );
        array_push($data, array(
            'title' => '電話',
            'type' => 'text_show',
            'value' => trim(Encryption::ZxingCrypt($arr_data[0]["payer_phone"],"DECODE")),
            )
        );
        array_push($data, array(
            'title' => '電子郵件',
            'type' => 'text_show',
            'value' => $arr_data[0]['payer_email']
            )
        );
        if($arr_data[0]['freight']!='店取'){            
            array_push($data, array(
                'title' => '收件人資訊',
                'type' => 'more_title'
                )
            );
            array_push($data, array(
                'title' => '姓名',
                'type' => 'text_show',
                'value' => $arr_data[0]['for_name']
                )
            );
            array_push($data, array(
                'title' => '手機',
                'type' => 'text_show',
                'value' => trim(Encryption::ZxingCrypt($arr_data[0]['for_phone'],"DECODE"))
                )
            );
            array_push($data, array(
                'title' => '市內電話',
                'type' => 'text_show',
                'value' => trim(Encryption::ZxingCrypt($arr_data[0]['for_tel'],"DECODE"))
                )
            );
            array_push($data, array(
                'title' => '地址',
                'type' => 'text_show',
                'value' => trim(Encryption::ZxingCrypt($arr_data[0]['for_address'],"DECODE"))
                )
            );
        }


        array_push($data, array(
           'title' => '其他',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
            'title' => '備註',
            'type' => 'textarea_show',
            'value' => nl2br($arr_data[0]['note'])
            )
        );
        array_push($data, array(
            'title' => '管理員備註',
            'type' => 'textarea',
            'name' => 'admin_note',
            'value' => $arr_data[0]['admin_note']
            )
        );
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '付款',
            "form_name" => 'form1',
            "elements" => $data
        );
        $arr_date  = array(
            "create_date" => $arr_data[0]['addtime'],
            "update_date" => $arr_data[0]['update_date']
        );    
        break;
    default:
        $arr_data = array();
        // $andSQL = " AND isset='1'";
        
        $strSQL = "SELECT * FROM orders where 1 ";
        if ($_GET['output'] == '搜尋'){
            if ($keyword != ''){
                $andSQL .= " AND( seccode LIKE '%$keyword%' OR payer_name LIKE '%$keyword%' OR tmp_ordercode LIKE '%$keyword%')";
            }
            if($status!='' and $status<>3){
                $andSQL .= " AND state='".$status."'";
            }
            if($class_id!=''){
                $andSQL .= " AND state='".$class_id."'";
            }
            if($start!='' || $end!=''){
                if($start==''){
                    $start_e = strtotime(date('Y-m-d 00:00:00'));
                }else{
                    $start_e = strtotime($start.' 00:00:00');
                }
                if($end==''){
                    $end_e = strtotime(date('Y-m-d 23:59:59'));
                }else{
                    $end_e = strtotime($end.' 23:59:59');
                }
                $andSQL .= " AND (addtime between '".$start_e."' AND '".$end_e."') ";
            }
            if($pay_state!=''){
                $andSQL .= " AND pay_state='".$pay_state."'";
            }
            if($payment!=''){
                $andSQL .= " AND payment='".$payment."'";
            }
            $strSQL = "SELECT * FROM orders where 1 $andSQL ORDER BY sn DESC";
        }else if ($_GET['output'] == '匯出'){
            if ($keyword != ''){
                $andSQL .= " AND( seccode LIKE '%$keyword%' OR payer_name LIKE '%$keyword%' OR tmp_ordercode LIKE '%$keyword%')";
            }
            if($status!='' and $status<>3){
                $andSQL .= " and state='".$status."'";
            }
            if($class_id!=''){
                $andSQL .= " and state='".$class_id."'";
            }
            if($start!='' || $end!=''){
                if($start==''){
                    $start_e = strtotime(date('Y-m-d 00:00:00'));
                }else{
                    $start_e = strtotime($start.' 00:00:00');
                }
                if($end==''){
                    $end_e = strtotime(date('Y-m-d 23:59:59'));
                }else{
                    $end_e = strtotime($end.' 23:59:59');
                }
                $andSQL .= " AND (addtime between '".$start_e."' AND '".$end_e."') ";
            }
            if($pay_state!=''){
                $andSQL .= " AND pay_state='".$pay_state."'";
            }
            if($payment!=''){
                $andSQL .= " AND payment='".$payment."'";
            }
            $strSQL = "SELECT * FROM orders WHERE 1 $andSQL ORDER BY sn DESC";
            $rs1 = $db->Execute($strSQL);

            include '../PHPExcel/PHPExcel.php';
            include '../PHPExcel/PHPExcel/Writer/Excel2007.php';

            //或者include 'PHPExcel/Writer/Excel5.php'; 用於輸出.xls的

            //創建一個excel

            $objPHPExcel = new PHPExcel();
            $k = 0;
            //設置當前的sheet
            $objPHPExcel->setActiveSheetIndex(0);
             
            //建立名單
            //設置單元格的值
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '訂購日期');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '訂單編號');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', '購買人姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', '電話');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', '地址');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', '購買內容');
            $objPHPExcel->getActiveSheet()->setCellValue('G1', '訂單金額');
            $objPHPExcel->getActiveSheet()->setCellValue('H1', '付款方式');
            $objPHPExcel->getActiveSheet()->setTitle('總表');
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setName('微軟正黑體')->setSize(16);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
            unset($styleArray);
            //設定背景顏色單色
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(
                array('fill'     => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FBECD1')
                    ),
                )
            );
            //凍結窗格
            $objPHPExcel->getActiveSheet()->freezePane('A2');
            $kk = 1;
            $i = 2;
            $content = '';
            foreach ($rs1 as $vv) {
                $strSQL = "SELECT * FROM orders_item WHERE order_sn='".$vv['sn']."'";
                $orders_item = $db->Execute($strSQL);
                $content = '';
                foreach ($orders_item as $orders_items) {
                    $content .= $orders_items['name'].' x '.$orders_items['num']."\n";
                }
                $content = substr($content,0,-1);
                //設置sheet的name
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, date('Y-m-d H:i',$vv['addtime']));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $vv['seccode']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $vv['for_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, trim(Encryption::ZxingCrypt($vv['for_phone'],"DECODE")));
                $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, trim(Encryption::ZxingCrypt($vv["for_address"],"DECODE")));
               
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $content);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $vv['total']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $vv["payment"]);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFont()->setName('微軟正黑體')->setSize(15);
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':H'.$i)->applyFromArray($styleArray);
                unset($styleArray);

                //自動欄寬
                $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(45);
                $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(20);
                $i++;
                $kk++;
            }
            //直接輸出到瀏覽器

            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");
            header('Content-Disposition:attachment;filename='.date("Y-m-d").'訂單.xls');
            header("Content-Transfer-Encoding:binary");
            $objWriter->save('php://output');
        }else{
            $strSQL .= " ORDER BY sn DESC";
        }
        //  echo $strSQL;
        //  exit;
        $rs = $db->Execute($strSQL);
        $rows = $db->Affected_Rows();
        $curr_page = $_GET['curr_page'];
        $last_page = ceil($rows / __DATA_PER_PAGE);
        if ($curr_page > $last_page)
            $curr_page = $last_page;
        if ($curr_page < 1)
            $curr_page = 1;
        if ($last_page == 0)
            $curr_page = 0;
        $arr_data = $db->PageExecute($strSQL, __DATA_PER_PAGE, $curr_page);
endswitch;
?>