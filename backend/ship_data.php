<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $ships_id = $_GET['id'];
        $strSQL = "SELECT * FROM ships WHERE id = '$ships_id'";        
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
            $strSQL = "SELECT * FROM ships WHERE 1 AND id != '$ships_id'";
            $Ships = $db->Execute($strSQL);
            // echo $strSQL;
            // exit;
            foreach($Ships as $ships){
                if($ships['min_num']<=$min_num&&$min_num<=$ships['max_num']){
                    FuncSite::msg_box_error('最小範圍重複或在別的運費範圍內！');
                    Func::go_to(-1);
                    exit;
                }elseif($ships['min_num']<=$max_num&&$max_num<=$ships['max_num']){
                    FuncSite::msg_box_error('最大範圍重複或在別的運費範圍內！');
                    Func::go_to(-1);
                    exit;
                }elseif($min_num<=$ships['min_num']&&$ships['max_num']<=$max_num){
                    FuncSite::msg_box_error('範圍包含別的運費範圍！');
                    Func::go_to(-1);
                    exit;
                }
            }
            if($min_num>$max_num){
                FuncSite::msg_box_error('最小範圍不能大魚最大範圍！');
                Func::go_to(-1);
                exit;
            }
            $data = array(
                'min_num'=>$min_num,
                'update_date'=>$update_date,
                'ship'=>$ship,
                'max_num'=>$max_num,
                'status'=>$status,
            );
            // print_r($data);
            // exit;
            $a = $db->update('ships',$data,"id = '$ships_id'");
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
            'title' => '最小範圍',
            'type' => 'text',
            'name' => 'min_num',
            'value' => '',
            'length' => 30,
            'max_length' => 50,
            'value' => $arr_data[0]['min_num'],
            "required" => true,
            'help' => '不可與其它運費之範圍重複或在其它運費之範圍內!'
                )
        );
        array_push($data, array(
            'title' => '最大範圍',
            'type' => 'text',
            'name' => 'max_num',
            'value' => '',
            'length' => 30,
            'max_length' => 50,
            'value' => $arr_data[0]['max_num'],
            "required" => true,
            'help' => '不可與其它運費之範圍重複或在其它運費之範圍內!'
                )
        );
        array_push($data, array(
            'title' => '運費',
            'type' => 'text',
            'name' => 'ship',
            'length' => 30,
            'value' => $arr_data[0]['ship'],
            'max_length' => 50
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
        $ships_id = $_GET['id'];
        $strSQL = "SELECT * FROM ships WHERE id = '$ships_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('ships',"id='$ships_id'");
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
            // print_r($_POST);
            // exit;
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $strSQL = "SELECT * FROM ships WHERE 1 ";
            $Ships = $db->Execute($strSQL);
            foreach($Ships as $ships){
                if($ships['min_num']<=$min_num&&$min_num<=$ships['max']){
                    FuncSite::msg_box_error('最小範圍重複或在別的運費範圍內！');
                    Func::go_to(-1);
                    exit;
                }elseif($ships['max_num']<=$max_num&&$max_num<=$ships['max_num']){
                    FuncSite::msg_box_error('最大範圍重複或在別的運費範圍內！');
                    Func::go_to(-1);
                    exit;
                }elseif($min_num<=$ships['min_num']&&$ships['max_num']<=$max_num){
                    FuncSite::msg_box_error('範圍包含別的運費範圍！');
                    Func::go_to(-1);
                    exit;
                }
            }


            $create_date = time();
            $update_date = time();           
            $data = array(
                'create_date'=>$create_date,
                'min_num'=>$min_num,
                'update_date'=>$update_date,
                'ship'=>$ship,
                'max_num'=>$max_num,
                'status'=>$status,
            );
            // print_r($data);
            // exit;
            $a = $db->insert('ships',$data);
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
            'value' => 1,
            'options'=>$arr_ison
                )
        );
        array_push($data, array(
            'title' => '最小範圍',
            'type' => 'text',
            'name' => 'min_num',
            'value' => '',
            'length' => 30,
            'max_length' => 50,
            "required" => true,
            'help' => '不可與其它運費之範圍重複或在其它運費之範圍內!'
                )
        );
        array_push($data, array(
            'title' => '最大範圍',
            'type' => 'text',
            'name' => 'max_num',
            'value' => '',
            'length' => 30,
            'max_length' => 50,
            "required" => true,
            'help' => '不可與其它運費之範圍重複或在其它運費之範圍內!'
                )
        );
        array_push($data, array(
            'title' => '運費',
            'type' => 'text',
            'name' => 'ship',
            'length' => 30,
            'max_length' => 50
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
        $status = $_GET['status'];
        if($status!='' and $status<>3){
            $andSQL .= " and status = ".$status;
        }
        $strSQL = "SELECT * FROM ships WHERE 1 $andSQL ORDER BY id asc";
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