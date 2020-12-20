<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $discount_id = $_GET['id'];
        $strSQL = "SELECT * FROM discount WHERE id = '$discount_id'";     
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
            $data = array(
                'title'=>$title,
                'status'=>$status,
                'update_date'=>$update_date,
                'recommend_price'=>$recommend_price,
                'recommend_limit'=>$recommend_limit,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
            );

            $a = $db->update('discount',$data,"id = '$discount_id'");
            // print_r($data);
            // exit;
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
            'title' => '加價購商品名稱',
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
            'title' => '加價購價格',
            'type' => 'text',
            'name' => 'recommend_price',
             "required" => true,
            'value' => $arr_data[0]['recommend_price']
            )
        );   
        array_push($data, array(
            'title' => '數量上限',
            'type' => 'text',
            'name' => 'recommend_limit',
             "required" => true,
            'value' => $arr_data[0]['recommend_limit']
            )
        );
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '基本設定',
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
        $strSQL = "SELECT * FROM discount WHERE id = '$discount_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('discount',"id='$discount_id'");
        Func::go_to($func_page . '.php');
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
            $data = array(
                'create_date'=>$create_date,
                'title'=>$title,
                'type'=>'increase_price',
                'status'=>$status,
                'update_date'=>$update_date,
                'recommend_price'=>$recommend_price,
                'recommend_limit'=>$recommend_limit,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
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
            'options'=>$arr_ison
                )
        );          
        array_push($data, array(
            'title' => '加價購商品名稱',
            'type' => 'text',
            'name' => 'title',
            )
        ); 
        array_push($data, array(
            'title' => '開始日期',
            'type' => 'datetime',
            'name' => 'onshelf',
            'help' => '如空值為不開放，開始及結束時間皆不為空值才會開放。',
            )
        );
        array_push($data, array(
            'title' => '結束日期',
            'type' => 'datetime',
            'name' => 'offshelf',
            'help' => '如空值為不開放，開始及結束時間皆不為空值才會開放。',
            )
        );   
        array_push($data, array(
            'title' => '加價購價格',
            'type' => 'text',
            'name' => 'recommend_price',
            "required" => true,
            )
        );   
        array_push($data, array(
            'title' => '數量上限',
            'type' => 'text',
            'name' => 'recommend_limit',
            "required" => true,
            )
        );
        $arr_form1 = array(
            "func" => 'insert',
            "form_name" => 'form1',
            "form_title" => '基本設定',
            "elements" => $data
        ); 
        break;
    default:
        $arr_data = array();
        $andSQL = '';
        $andSQL .= ' and type="increase_price"';
        $status = $_GET['status'];
        $keyword = $_GET['keyword'];
        if($status!='' and $status<>3){
            $andSQL .= "and status=".$status;
        }elseif($keyword!=''){
            $andSQL .= "and title like '%".$keyword."%'";
        }
        $strSQL = "SELECT * FROM discount WHERE 1 $andSQL ORDER BY id DESC";
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