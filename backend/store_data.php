<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $store_id = $_GET['id'];
        $strSQL = "SELECT * FROM store WHERE id = '$store_id'";        
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
            $address = $county.$district.$addr;
            $update_date = time();
            if($_FILES){
                if($_FILES['img']['tmp_name']){
                    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $array_img_ext) === false){
                        FuncSite::msg_box_error('圖片格式錯誤！');
                        Func::go_to(-1);
                        
                        exit;
                    }
                    $img = time().rand(100,999) . '.' . $ext;
                    if($ext=='png' || $ext=='gif'){
                        Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 320, 320);
                    }else{
                        Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 320, 320);
                    }

                }
        }
        if ($del_img == 'true')
        {
            $img = '';
        }
        $data = array(
                'title'=>$title,
                'update_date'=>$update_date,
                'sort'=>$sort,
                'addr'=>$addr,
                'county'=>$county,
                'district'=>$district,
                'address'=>$address,
                'address_note'=>$address_note,
                'img'=>$img,
                'tel'=>$tel,
                'hours'=>$hours,
                'status'=>$status,
            );
            // print_r($data);
            // exit;
            $a = $db->update('store',$data,"id = '$store_id'");
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
                'title' => '啟用設定1',
                'type' => 'checkbox',
                'name' => 'status1',
                'value' => $arr_data[0]['status'],
                'options'=>$arr_chk
            )
        );
        array_push($data, array(
            'title' => '門市名稱',
            'type' => 'text',
            'name' => 'title',
            'value' => $arr_data[0]['title'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '圖片',
            'type' => 'image',
            'name' => 'img',
            'value' => $arr_data[0]['img'],
            'help' => '建議寬高: 320 × 320 ，或等比例之圖片。其檔案大小不得超過2M',
            'pre_folder' => __WEB_IMAGES_FOLDER,
            // 'max_size' => 4096,
            'delete' => true
            )
        );
        array_push($data, array(
            'title' => '地點',
            'type' => 'select_TWzipcode',
            'name' => 'area',
            'value' => $arr_data[0]['county'],
            'value1' => $arr_data[0]['district'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '地址',
            'type' => 'text',
            'name' => 'addr',
            'value' => $arr_data[0]['addr'],
            "required" => true
            )
        );
        array_push($data, array(
            'title' => '地址備註',
            'type' => 'text',
            'name' => 'address_note',
            'value' => $arr_data[0]['address_note'],
            'length' => 30,
            'max_length' => 50
                )
        );
        array_push($data, array(
            'title' => '營業時間',
            'type' => 'textarea',
            'name' => 'hours',
            'value' => $arr_data[0]['hours'],
            'rows' => 3,
            "required" => true
            )
        );
        array_push($data, array(
            'title' => '電話',
            'type' => 'text',
            'name' => 'tel',
            'value' => $arr_data[0]['tel'],
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
        $store_id = $_GET['id'];
        $strSQL = "SELECT * FROM store WHERE id = '$store_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('store',"id='$store_id'");
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
            $address = $county.$district.$addr;
            $create_date = time();
            $update_date = time();
            if($_FILES){
                if($_FILES['img']['tmp_name']){
                    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $array_img_ext) === false){
                        FuncSite::msg_box_error('圖片格式錯誤！');
                        Func::go_to(-1);
                        
                        exit;
                    }
                    $img = time().rand(100,999) . '.' . $ext;
                    if($ext=='png' || $ext=='gif'){
                        Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 320, 320);
                    }else{
                        Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 320, 320);
                    }

                }
            }
            $data = array(
                'create_date'=>$create_date,
                'title'=>$title,
                'update_date'=>$update_date,
                'sort'=>$sort,
                'addr'=>$addr,
                'county'=>$county,
                'district'=>$district,
                'address'=>$address,
                'address_note'=>$address_note,
                'img'=>$img,
                'tel'=>$tel,
                'hours'=>$hours,
                'status'=>$status,
            );
            // print_r($data);
            // exit;
            $a = $db->insert('store',$data);
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
            'title' => '門市名稱',
            'type' => 'text',
            'name' => 'title',
            'value' => '',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '圖片',
            'type' => 'image',
            'name' => 'img',
            'max_size' => 4096,
            'help' => '建議寬高: 320 × 320 ，或等比例之圖片。其檔案大小不得超過2M',
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '地點',
            'type' => 'select_TWzipcode',
            'name' => 'area',
            'value' => $arr_data[0]['county'],
            'value1' => $arr_data[0]['district'],            
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '地址',
            'type' => 'text',
            'name' => 'addr',
            "required" => true
            )
        );
        array_push($data, array(
            'title' => '地址備註',
            'type' => 'text',
            'name' => 'address_note',
            'length' => 30,
            'max_length' => 50
                )
        );
        array_push($data, array(
            'title' => '營業時間',
            'type' => 'textarea',
            'name' => 'hours',
            'rows' => 3,
            "required" => true
            )
        );
        array_push($data, array(
            'title' => '電話',
            'type' => 'text',
            'name' => 'tel',
            'value' => '',
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
        $strSQL = "SELECT * FROM store WHERE 1 $andSQL ORDER BY sort desc";
        // echo $strSQL;
        // exit;
        $arr_data = $db->Execute($strSQL);
//        $rows = $db->Affected_Rows();
//        $curr_page = $_GET['curr_page'];
//        $last_page = ceil($rows / __DATA_PER_PAGE);
//        if ($curr_page > $last_page)
//            $curr_page = $last_page;
//        if ($curr_page < 1)
//            $curr_page = 1;
//        if ($last_page == 0)
//            $curr_page = 0;
//        $arr_data = $db->PageExecute($strSQL, __DATA_PER_PAGE, $curr_page);
endswitch;



?>