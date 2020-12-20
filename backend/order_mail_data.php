<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $orders_mail_id = $_GET['id'];
        $strSQL = "SELECT * FROM orders_mail WHERE id = '$orders_mail_id'";        
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
            $data = array('title'=>$title);
            // print_r($data);
            // exit;
            $a = $db->update('orders_mail',$data,"id = '$orders_mail_id'");
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
            'title' => '電子信箱',
            'type' => 'text',
            'name' => 'title',
            'value' => $arr_data[0]['title'],
             "required" => true
            )
        );
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '基本設定',
            "form_name" => 'form1',
            "elements" => $data
        ); 
        break;
    case "delete":
        $orders_mail_id = $_GET['id'];
        $strSQL = "SELECT * FROM orders_mail WHERE id = '$orders_mail_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('orders_mail',"id='$orders_mail_id'");
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
            $data = array('title'=>$title);
            $a = $db->insert('orders_mail',$data);
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
            'title' => '電子信箱',
            'type' => 'text',
            'name' => 'title',
            "required" => true
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
        $strSQL = "SELECT * FROM orders_mail WHERE 1 $andSQL";
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