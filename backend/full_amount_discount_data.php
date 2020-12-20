<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $discount_id = $_GET['id'];
        $strSQL = "select * from discount where id = '$discount_id'";        
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
		
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            // print_r($_POST);
            // exit;
			$update_date = time();
            $onshelf = strtotime($onshelf);
            $offshelf = strtotime($offshelf);
            if($offshelf<$onshelf){
                FuncSite::msg_box_error('開始日期不得大於結束日期！');
                Func::go_to(-1);
                exit;
            }
            $strSQL = "select * from discount where id<>$discount_id and type='full_amount'";
            $discount = $db->Execute($strSQL);
            foreach ($discount as $value) {
                if($onshelf>=$value['onshelf'] && $onshelf<=$value['offshelf']){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
                if($offshelf>=$value['onshelf'] && $offshelf<=$value['offshelf']){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
                if($value['onshelf']>=$onshelf && $value['onshelf']<=$offshelf){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
                if($value['offshelf']>=$onshelf && $value['offshelf']<=$offshelf){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
            }
            $recommend = implode(',', $_POST['recommend']);
            $recommend_price = implode(',', $_POST['recommend_price']);
            $data = array(
                'update_date'=>$update_date,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
                'title'=>$title,
                'status'=>$status,
                'recommend'=>$recommend,
                'recommend_price'=>$recommend_price,
                'amount'=>$amount,
                'cash_discount'=>$cash_discount,
                'accumulate'=>$accumulate
            );
            $a = $db->update('discount',$data,"id = '$discount_id'");
            if(!$a){
                FuncSite::msg_box('更新成功！');
            }else{
                FuncSite::msg_box_error('更新失敗！');
            }     
            Func::go_to($func_page . '.php');
            exit;
        }
        $data = array();    
        array_push($data, array(
            'title' => '啟用設定',
            'type' => 'radio',
            'name' => 'status',
            'value' => $arr_data[0]['status'],
            'options'=>$arr_ison
                )
        );  
        array_push($data, array(
            'title' => '能否重複折扣',
            'type' => 'radio',
            'name' => 'accumulate',
            'value' => $arr_data[0]['accumulate'],
            'options'=>$arr_mulate
                )
        );
        array_push($data, array(
            'title' => '活動名稱',
            'type' => 'text',
            'name' => 'title',
            'value' => $arr_data[0]['title']
            )
        );  
        if($arr_data[0]['onshelf']==0){
            $onshelf = '';
        }else{
            $onshelf = date('Y-m-d H:i',$arr_data[0]['onshelf']);
        }
        array_push($data, array(
            'title' => '開始日期',
            'type' => 'datetime',
            'name' => 'onshelf',
            'help' => '如空值為不開放，開始及結束時間皆不為空值才會開放。',
            'value' => $onshelf
            )
        );
        if($arr_data[0]['offshelf']==0){
            $offshelf = '';
        }else{
            $offshelf = date('Y-m-d H:i',$arr_data[0]['offshelf']);
        }
        array_push($data, array(
            'title' => '結束日期',
            'type' => 'datetime',
            'name' => 'offshelf',
            'help' => '如空值為不開放，開始及結束時間皆不為空值才會開放。',
            'value' => $offshelf
            )
        );
        array_push($data, array(
            'title' => '購買滿多少(元)',
            'type' => 'text',
            'name' => 'amount',
            'value' => $arr_data[0]['amount'],
            'help' => '可享滿額現折優惠',
            )
        );
        array_push($data, array(
            'title' => '現金折價多少(元)',
            'type' => 'text',
            'value' => $arr_data[0]['cash_discount'],
            'name' => 'cash_discount'
            )
        );
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '滿額現折設定',
            "form_name" => 'form1',
            "elements" => $data
        );      
        $arr_date  = array(
            "create_date" => $arr_data[0]['create_date'],
            "update_date" => $arr_data[0]['update_date']
        );    
        break;
    case "delete":
        $discount_id = $_GET['id'];
        $strSQL = "select * from discount where id = '$discount_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('discount',"id='$discount_id'");
        $curr_page = $_GET['curr_page'];
        if($curr_page!=''){
            Func::go_to($func_page . '.php?curr_page='.$curr_page);
        }else{
            Func::go_to($func_page . '.php');
        }
        exit;
        break;
    case "insert":
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $create_date = time();
            $update_date = time();
            $onshelf = strtotime($onshelf);
            $offshelf = strtotime($offshelf);
            if($offshelf<$onshelf){
                FuncSite::msg_box_error('開始日期不得大於結束日期！');
                Func::go_to(-1);
                exit;
            }
            $strSQL = "select * from discount where id<>$discount_id and type='full_amount'";
            $discount = $db->Execute($strSQL);
            foreach ($discount as $value) {
                if($onshelf>=$value['onshelf'] && $onshelf<=$value['offshelf']){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
                if($offshelf>=$value['onshelf'] && $offshelf<=$value['offshelf']){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
                if($value['onshelf']>=$onshelf && $value['onshelf']<=$offshelf){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
                if($value['offshelf']>=$onshelf && $value['offshelf']<=$offshelf){
                    FuncSite::msg_box_error('活動時間與其他活動時間重疊！');
                    Func::go_to(-1);
                    exit;
                }
            }
            // print_r($_POST);
            // exit;
            $data = array(
                'create_date'=>$create_date,
                'update_date'=>$update_date,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
                'type'=>'full_amount',
                'title'=>$title,
                'status'=>$status,
                'amount'=>$amount,
                'cash_discount'=>$cash_discount,
                'accumulate'=>$accumulate
            );
            $a = $db->insert('discount',$data);
            if($a){
                FuncSite::msg_box('新增成功！');
            }else{
                FuncSite::msg_box_error('新增失敗！');
            }            
            Func::go_to($func_page . '.php');
            exit;
        }
        $data = array();
        array_push($data, array(
            'title' => '啟用設定',
            'type' => 'radio',
            'name' => 'status',
            'value' => '1',
            'options'=>$arr_ison
                )
        );
        array_push($data, array(
            'title' => '能否重複折扣',
            'type' => 'radio',
            'name' => 'accumulate',
            'value' => 1,
            'options'=>$arr_mulate
                )
        );
        array_push($data, array(
            'title' => '活動名稱',
            'type' => 'text',
            'name' => 'title'
            )
        );
        array_push($data, array(
            'title' => '開始日期',
            'type' => 'datetime',
            'help' => '如空值為不開放，開始及結束時間皆不為空值才會開放。',
            'name' => 'onshelf'
            )
        );
        array_push($data, array(
            'title' => '結束日期',
            'type' => 'datetime',
            'help' => '如空值為不開放，開始及結束時間皆不為空值才會開放。',
            'name' => 'offshelf'
            )
        );
        array_push($data, array(
            'title' => '購買滿多少(元)',
            'type' => 'text',
            'name' => 'amount',
            'help' => '可享滿額現折優惠',
            )
        );
        array_push($data, array(
            'title' => '現金折價多少(元)',
            'type' => 'text',
            'name' => 'cash_discount'
            )
        );
        $arr_form1 = array(
            "func" => 'insert',
            "form_name" => 'form1',
            "form_title" => '滿額現折設定',
            "elements" => $data
        ); 
        break;
    default:
        $arr_data = array();
        $andSQL = ' and type="full_amount"';
        $strSQL = "select * from discount where 1 $andSQL order by create_date desc";
        // echo $strSQL;
        // exit;
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