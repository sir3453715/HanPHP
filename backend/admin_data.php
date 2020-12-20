<?php
//phpinfo();
//exit;
$member_id = Session::get('member_id','morning');

switch ($_GET['func']):
    case "update":
        $member_id = $_GET['id'];
        $strSQL = "select * from member where id = '$member_id'";        
        $arr_data = $db->Execute($strSQL);        
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $strSQL = "select * from desktop_list where member_id = '".$arr_data[0]['id']."' order by update_time desc limit 1";
        $arr_login = $db->Execute($strSQL);
        $old_pwd = $arr_data[0]['m_pwd'];
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $update_date = time();
            if($old_pwd==$m_pwd){
                $m_pwd = $m_pwd;
            }else{
                $m_pwd = Password::hash($m_pwd);
            }
            $data = array('m_name'=>$m_name,'m_id'=>$m_id,'m_pwd'=>$m_pwd,'status'=>$status,'update_date'=>$update_date);
            $a = $db->update('member',$data,"id = '$member_id'");
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
            'title' => '管理員名稱',
            'type' => 'text',
            'name' => 'm_name',
            "required" => true,
            'value' =>$arr_data[0]['m_name']
            )
        );
        array_push($data, array(
            'title' => '帳號',
            'type' => 'text',
            'name' => 'm_id',
            "required" => true,
            'value' =>$arr_data[0]['m_id']
            )
        );
        array_push($data, array(
            'title' => '密碼',
            'type' => 'password',
            'name' => 'm_pwd',
            "required" => true,
            'value' =>$arr_data[0]['m_pwd']
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
            "update_date" => $arr_data[0]['update_date'],
            "last_login_date" => $arr_login[0]['update_time'],
            "last_login_ip" => $arr_login[0]['client_ip']
        );    
        break;
    case "delete":
        $member_id = $_GET['id'];
        $strSQL = "select * from member where id = '$member_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('member',"id='$member_id'");
        if(!$a){
            FuncSite::msg_box('刪除成功！');
        }else{
            FuncSite::msg_box_error('刪除失敗！');
        }  
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
            $m_pwd = Password::hash($m_pwd);
            $data = array('m_name'=>$m_name,'m_id'=>$m_id,'m_pwd'=>$m_pwd,'status'=>$status,'create_date'=>$create_date,'update_date'=>$update_date);
            $a = $db->insert('member',$data);
            //exit;
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
            'title' => '管理員名稱',
            'type' => 'text',
            'name' => 'm_name',
            "required" => true,
            'value' =>''
            )
        );
        array_push($data, array(
            'title' => '帳號',
            'type' => 'text',
            'name' => 'm_id',
            "required" => true,
            'value' =>''
            )
        );
        array_push($data, array(
            'title' => '密碼',
            'type' => 'password',
            'name' => 'm_pwd',
            "required" => true,
            'value' =>''
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
        $keyword = $_GET['keyword'];
        if($status!='' and $status<>3){
            $andSQL = "and ison=".$status;
        }elseif($keyword!=''){
            $andSQL .= "and title like '%".$keyword."%'";
        }
        $strSQL = "select * from member where 1 $andSQL order by id desc";

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