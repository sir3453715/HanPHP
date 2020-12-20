<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $qa_id = $_GET['id'];
        $strSQL = "SELECT * FROM qa WHERE id = '$qa_id'";        
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
                'q'=>$q,
                'update_date'=>$update_date,
                'sort'=>$sort,
                'a'=>$a,
                'status'=>$status,
            );
            // print_r($data);
            // exit;
            $a = $db->update('qa',$data,"id = '$qa_id'");
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
            'title' => '問題',
            'type' => 'text',
            'name' => 'q',
            'value' => $arr_data[0]['q'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '回答',
            'type' => 'text',
            'name' => 'a',
            'value' => $arr_data[0]['a'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
            )
        );
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'length' => 4,
            'max_length' => 4,
            'value' => $arr_data[0]['sort']
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
        $qa_id = $_GET['id'];
        $strSQL = "SELECT * FROM qa WHERE id = '$qa_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('qa',"id='$qa_id'");
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
                'q'=>$q,
                'update_date'=>$update_date,
                'sort'=>$sort,
                'a'=>$a,
                'status'=>$status,
            );
            // print_r($data);
            // exit;
            $a = $db->insert('qa',$data);
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
            'title' => '問題',
            'type' => 'text',
            'name' => 'q',
            'value' => '',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '回答',
            'type' => 'text',
            'name' => 'a',
            'length' => 30,
            'max_length' => 50
                )
        );
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'length' => 4,
            'max_length' => 4,
            'value' =>'10'
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
        $strSQL = "SELECT * FROM qa WHERE 1 $andSQL ORDER BY sort desc";
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