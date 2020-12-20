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
			$update_date = time();
            $onshelf = strtotime($onshelf);
            $offshelf = strtotime($offshelf);
            if($offshelf<$onshelf){
                FuncSite::msg_box_error('開始日期不得大於結束日期！');
                Func::go_to(-1);
                exit;
            }
            $strSQL = "select * from discount where code = '$code' and id<>$discount_id and type='coupon'";        
            $rs = $db->Execute($strSQL);
            if($rs[0]['id']!=''){
                FuncSite::msg_box_error('代號已存在！');
                Func::go_to(-1);
                exit;
            }
            $data = array('update_date'=>$update_date,'onshelf'=>$onshelf,'offshelf'=>$offshelf,'type1'=>$type1,'amount'=>$amount,'title'=>$title,'status'=>$status,);
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
            'title' => '代號',
            'type' => 'text_show',
            'value' => $arr_data[0]['code'],
            )
        );
        array_push($data, array(
            'title' => '類型',
            'type' => 'select',
            'options' => $arr_type,
            'value' => $arr_data[0]['type1'],
            'name' => 'type1'
            )
        );
        array_push($data, array(
            'title' => '折價數',
            'type' => 'text',
            'value' => $arr_data[0]['amount'],
            'name' => 'amount',
            'help' => '如為現金折扣請填入金額(元)；%數折扣請填入折數，例如：95折填入95。'
            )
        );
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '優惠券設定',
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
            $strSQL = "select * from discount where code = '$code' and type='coupon'";        
            $rs = $db->Execute($strSQL);
            if($rs[0]['id']!=''){
                FuncSite::msg_box_error('代號已存在！');
                Func::go_to(-1);
                exit;
            }
            $data = array('create_date'=>$create_date,'update_date'=>$update_date,'onshelf'=>$onshelf,'offshelf'=>$offshelf,'code'=>$code,'type1'=>$type1,'amount'=>$amount,'title'=>$title,'status'=>$status,'type'=>'coupon');
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
            'title' => '代號',
            'type' => 'text',
            'help' => '代號不得重複。',
            'name' => 'code',
            "required" => true
            )
        );
        array_push($data, array(
            'title' => '類型',
            'type' => 'select',
            'options' => $arr_type,
            'name' => 'type1'
            )
        );
        array_push($data, array(
            'title' => '折價數',
            'type' => 'text',
            'name' => 'amount',
            'help' => '如為現金折扣請填入金額(元)；%數折扣請填入折數，例如：95折填入95。'
            )
        );
        $arr_form1 = array(
            "func" => 'insert',
            "form_name" => 'form1',
            "form_title" => '優惠券設定',
            "elements" => $data
        ); 
        break;
    default:
        $arr_data = array();
        $andSQL = ' and type="coupon"';
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