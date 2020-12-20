<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
     default:
        $andSQL = ' and type="full_station"';
        $strSQL = "select * from discount where 1 $andSQL order by create_date desc";    
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
		$discount_id = $arr_data[0]['id'];
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
            $data = array(
                'update_date'=>$update_date,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
                'amount'=>$amount,
                'title'=>$title,
                'status'=>$status,
                // 'isfreeship'=>$isfreeship,
                'threshold'=>$threshold
            );
            // print_r($data);
            // exit;
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
            'title' => '購買滿多少(元)',
            'type' => 'text',
            'name' => 'threshold',
            'value' => $arr_data[0]['threshold'],
            'help' => '可享全站折扣',
            )
        ); 
        array_push($data, array(
            'title' => '折價數',
            'type' => 'text',
            'value' => $arr_data[0]['amount'],
            'name' => 'amount',
            'help' => '請填入折數，例如：95折填入95。'
            )
        );
        // array_push($data, array(
        //     'title' => '折扣後計算是否免運',
        //     'type' => 'select',
        //     'name' => 'isfreeship',
        //     'value' => $arr_data[0]['isfreeship'],
        //     'options'=>$arr_ison1
        //         )
        // );  
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '全站折扣設定',
            "form_name" => 'form1',
            "elements" => $data
        );      
        $arr_date  = array(
            "create_date" => $arr_data[0]['create_date'],
            "update_date" => $arr_data[0]['update_date']
        );    
        break;
endswitch;
?>