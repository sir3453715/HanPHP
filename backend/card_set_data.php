<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $card_set_id = $_GET['id'];
        $strSQL = "SELECT * FROM card_set WHERE id = '$card_set_id'";        
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $img = $arr_data[0]['img'];
        $web_img = $arr_data[0]['web_img'];
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $update_date = time();
            if($_FILES['img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                @unlink(__SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                $img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 400, 250);
                }else{
                    Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 400, 250);
                }
            }
            if ($del_img == 'true')
            {
                $img = '';
            } 
            if($_FILES['web_img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['web_img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                @unlink(__SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $web_img);
                $web_img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['web_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $web_img, 380, 310);
                }else{
                    Func::ImageResize($_FILES['web_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $web_img, 380, 310);
                }
            }
            if ($del_web_img == 'true')
            {
                $web_img = '';
            } 
            $data = array(
                'update_date'=>$update_date,
                'title'=>$title,
                'status'=>$status,
                'img'=>$img,
                'web_img'=>$web_img,
                'content'=>$content,
                'sort'=>$sort,
            );
            $a = $db->update('card_set',$data,"id = '$card_set_id'");
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
            'title' => '標題',
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
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 400 * 250 ，或等比例之圖片。其檔案大小不得超過2M',
                'delete' => true
            )
        );
        array_push($data, array(
                'title' => '介紹圖片',
                'type' => 'image',
                'name' => 'web_img',
                'value' => $arr_data[0]['web_img'],
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 380 * 310 ，或等比例之圖片。其檔案大小不得超過2M',
                'delete' => true
            )
        );
        array_push($data, array(
            'title' => '介紹',
            'type' => 'textarea',
            'name' => 'content',
            'value' => $arr_data[0]['content'],
            'rows' => 5,
                )
        );
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'value' => $arr_data[0]['sort'],
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
        $card_set_id = $_GET['id'];
        $strSQL = "SELECT * FROM card_set WHERE id = '$card_set_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('card_set',"id='$card_set_id'");
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
            if($_FILES['img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                $img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 400, 250);
                }else{
                    Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 400, 250);
                }
            }
            if($_FILES['web_img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['web_img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                $web_img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['web_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $web_img, 380, 310);
                }else{
                    Func::ImageResize($_FILES['web_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $web_img, 380, 310);
                }
            }
            $data = array(
                'create_date'=>$create_date,
                'title'=>$title,
                'status'=>$status,
                'update_date'=>$update_date,
                'img'=>$img,
                'web_img'=>$web_img,
                'content'=>$content,
                'sort'=>$sort,
            );
            // print_r($data);
            // exit;
            $a = $db->insert('card_set',$data);
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
            'title' => '標題',
            'type' => 'text',
            'name' => 'title',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
                'title' => '圖片',
                'type' => 'image',
                'name' => 'img',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 400 * 250 ，或等比例之圖片。其檔案大小不得超過2M',
                // 'max_size' => 4096,
                'delete' => true
            )
        );
        array_push($data, array(
                'title' => '介紹圖片',
                'type' => 'image',
                'name' => 'web_img',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 380 * 310 ，或等比例之圖片。其檔案大小不得超過2M',
                'delete' => true
            )
        );
        array_push($data, array(
            'title' => '介紹',
            'type' => 'textarea',
            'name' => 'content',
            'rows' => 5,
                )
        );
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'length' => 30,
            'max_length' => 50,
            'value'=>10,
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
        $status = $_GET['status'];
        $keyword = $_GET['keyword'];
        if($status!='' and $status<>3){
            $andSQL .= "and status=".$status;
        }elseif($keyword!=''){
            $andSQL .= "and title like '%".$keyword."%'";
        }
        $strSQL = "SELECT * FROM card_set WHERE 1 $andSQL ORDER BY sort desc";
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