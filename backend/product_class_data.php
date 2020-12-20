<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);
switch ($_GET['func']):
    case "update":
        $product_class_id = $_GET['id'];
        $strSQL = "SELECT * FROM product_class WHERE id = '$product_class_id'";        
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $img = $arr_data[0]['img'];
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $update_date = time();
            $data = array(
                'title'=>$title,
                'sort'=>$sort,
                'status'=>$status,
                'update_date'=>$update_date
            );
            $a = $db->update('product_class',$data,"id = '$product_class_id'");
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
            'title' => '顯示設定',
            'type' => 'radio',
            'name' => 'status',
            'value' => $arr_data[0]['status'],
            'options'=>$arr_ison
            )
        );
        if($product_class_id == 9){
            array_push($data, array(
                'title' => '組別',
                'type' => 'text_show',
                'name' => 'title',
                'value' => $arr_data[0]['title'],
                'length' => 30,
                'max_length' => 50,
                "required" => true
                )
            );
        }else{
            array_push($data, array(
                'title' => '組別',
                'type' => 'text',
                'name' => 'title',
                'value' => $arr_data[0]['title'],
                'length' => 30,
                'max_length' => 50,
                "required" => true
                )
            );
        }
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'value' =>$arr_data[0]['sort']
            )
        );
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '組別設定',
            "form_name" => 'form1',
            "elements" => $data
        );
        $arr_date  = array(
            "create_date" => $arr_data[0]['create_date'],
            "update_date" => $arr_data[0]['update_date']
        );    
        break;
    case "delete":
        $product_class_id = $_GET['id'];
        $strSQL = "SELECT * FROM product_class WHERE id = '$product_class_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('product_class',"id='$product_class_id'");
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
            $data = array(
                'create_date'=>$create_date,
                'title'=>$title,
                'update_date'=>$update_date,
                'sort'=>$sort,
                'status'=>$status,
            );
            $a = $db->insert('product_class',$data);
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
            'title' => '顯示設定',
            'type' => 'radio',
            'name' => 'status',
            'value' => '1',
            'options'=>$arr_ison
                )
        );
        array_push($data, array(
            'title' => '組別',
            'type' => 'text',
            'name' => 'title',
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
            'value' =>'10'
                )
        );        
        $arr_form1 = array(
            "func" => 'insert',
            "form_name" => 'form1',
            "form_title" => '組別設定',
            "elements" => $data
        ); 
        break;
    default:
        $arr_data = array();
        $andSQL = '';
        $status = $_GET['status'];
        $keyword = $_GET['keyword'];
        if($status!='' and $status<>3){
            $andSQL = "and status=".$status;
        }elseif($keyword!=''){
            $andSQL .= "and title like '%".$keyword."%'";
        }
        $strSQL = "SELECT * FROM product_class WHERE 1 $andSQL ORDER BY sort desc";
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