<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $website_member_id = $_GET['id'];
        $strSQL = "SELECT * FROM website_member WHERE id = '$website_member_id'";        
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
        $data = array(
                'update_date'=>$update_date,
                'name'=>$name,
                'phone'=>Encryption::ZxingCrypt($phone,"ENCODE"),
                'tel'=>Encryption::ZxingCrypt($tel,"ENCODE"),
                'address'=>Encryption::ZxingCrypt($phone,"ENCODE"),
                'email'=>$email,
                'birthday'=>$birthday,
            );
            // print_r($data);
            // exit;
            $a = $db->update('website_member',$data,"id = '$website_member_id'");
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
            'title' => '姓名',
            'type' => 'text_show',
            'name' => 'name',
            'value' => $arr_data[0]['name'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '行動電話',
            'type' => 'text_show',
            'name' => 'phone',
            'value' => Encryption::ZxingCrypt($arr_data[0]['phone'],"DECODE"),
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '聯絡電話',
            'type' => 'text_show',
            'name' => 'tel',
            'value' => Encryption::ZxingCrypt($arr_data[0]['tel'],"DECODE"),
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '地址',
            'type' => 'text_show',
            'name' => 'address',
            'value' => Encryption::ZxingCrypt($arr_data[0]['address'],"DECODE"),
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '電子信箱',
            'type' => 'text_show',
            'name' => 'email',
            'value' => $arr_data[0]['email'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '生日',
            'type' => 'text_show',
            'name' => 'birthday',
            'value' => $arr_data[0]['birthday'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
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
        $website_member_id = $_GET['id'];
        $strSQL = "SELECT * FROM website_member WHERE id = '$website_member_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('website_member',"id='$website_member_id'");
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
            $create_date = time();
            $update_date = time();           
            $data = array(
                'create_date'=>$create_date,
                'name'=>$name,
                'phone'=>Encryption::ZxingCrypt($phone,"ENCODE"),
                'tel'=>Encryption::ZxingCrypt($tel,"ENCODE"),
                'address'=>Encryption::ZxingCrypt($phone,"ENCODE"),
                'email'=>$email,
                'birthday'=>$birthday,
            );
            // print_r($data);
            // exit;
            $a = $db->insert('website_member',$data);
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
            'title' => '姓名',
            'type' => 'text',
            'name' => 'name',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '行動電話',
            'type' => 'text',
            'name' => 'phone',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '聯絡電話',
            'type' => 'text',
            'name' => 'tel',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '地址',
            'type' => 'text',
            'name' => 'address',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '電子信箱',
            'type' => 'text_show',
            'name' => 'email',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '生日',
            'type' => 'text',
            'name' => 'birthday',
            'length' => 30,
            'max_length' => 50,
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
        $andSQL = '';
        // $andSQL .= "AND type = '0' " ;
        $search_name = $_GET['search_name'];
        if($search_name!=''){
            $andSQL .= "AND (name LIKE '%".$search_name."%' OR email LIKE '%".$search_name."%')";
        }
        $status = $_GET['status'];
        if($status!='' and $status<>3){
            $andSQL .= " and status = ".$status;
        }
        $strSQL = "SELECT * FROM `website_member` WHERE 1 $andSQL ORDER BY id asc";
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