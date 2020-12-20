<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $product_id = $_GET['id'];
        $strSQL = "SELECT * FROM product WHERE id = '$product_id'";        
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $img = $arr_data[0]['img'];
        $img1 = $arr_data[0]['img1'];
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $update_date = time();
            $onshelf = strtotime($onshelf);
            $offshelf = strtotime($offshelf);
            if(is_array($_FILES)){
	            if($_FILES['img']['tmp_name']){
	                $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
	                if (in_array($ext, $array_img_ext) === false){
	                    FuncSite::msg_box_error('圖片格式錯誤！');
	                    Func::go_to(-1);                            
	                    exit;
	                }
	                @unlink(__SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
	                $img = time().rand(100,999) . '.' . $ext;
	                // @copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
	                if($ext=='png' || $ext=='gif'){
	                    Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 201, 159);
	                }else{
	                    Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 201, 159);
	                }
	            }
	            if($_FILES['img1']['tmp_name']){
	                $ext = strtolower(pathinfo($_FILES['img1']['name'], PATHINFO_EXTENSION));
	                if (in_array($ext, $array_img_ext) === false){
	                    FuncSite::msg_box_error('圖片格式錯誤！');
	                    Func::go_to(-1);                            
	                    exit;
	                }
	                @unlink(__SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img1);
	                $img1 = time().rand(100,999) . '.' . $ext;
	                // @copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
	                if($ext=='png' || $ext=='gif'){
	                    Func::ImageResize_Transparent($_FILES['img1']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img1, 450, 450);
	                }else{
	                    Func::ImageResize($_FILES['img1']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img1, 450, 450);
	                }
	            }
            }
            if ($del_img == 'true')
            {
                $img = '';
            }
            if ($del_img1 == 'true')
            {
                $img1 = '';
            }
            $recommend = implode(',', $_POST['recommend']);
            $data = array(
                'title'=>$title,
                'sort'=>$sort,
                'status'=>$status,
                'ishot'=>$ishot,    
                'isevent'=>$isevent,
                'update_date'=>$update_date,
                'img'=>$img,
                'img1'=>$img1,
                'original_price'=>$original_price,
                'discounted_price'=>$discounted_price,
                'content'=>$content,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
                'recommend'=>$recommend,
                'summary'=>$summary,
            );

            $a = $db->update('product',$data,"id = '$product_id'");
            // print_r($data);
            // exit;
            if(!$a){
                FuncSite::msg_box('更新成功！');

                $strSQL = "delete FROM list_insert_price_detail  WHERE templet_id='$product_id'";
                $db->Execute($strSQL);
                foreach(explode(',',trim($_POST['i_category_id'])) as $vv){
                    // echo $vv."<br>";
                    if(preg_match('/^([0-9]+)$/',$vv)){
                        // echo $vv."<br>";
                        $strSQL = "insert into list_insert_price_detail values(null,'$product_id','$vv','baby_product');";
                        $db->Execute($strSQL);
                        // $strSQL = "SELECT * FROM product_class2 WHERE id='$vv'";
                        // $rs=$db->Execute($strSQL);
                        $strSQL = "SELECT * FROM list_insert_price_detail WHERE templet_id='$product_id' and class_id='".$rs[0]['id']."'";
                        $rs1=$db->Execute($strSQL);
                        if($rs1[0]['id']==null){
                        $strSQL = "insert into list_insert_price_detail values(null,'$product_id','".$rs[0]['id']."','baby_product');";
                        // echo $strSQL.'<br>';
                        $db->Execute($strSQL);
                        }
                    }
                }
            }else{
                FuncSite::msg_box_error('更新失敗！');
            }     
            $tmp = '';
            if(is_array($arg)){
                foreach ($arg as $kk => $vv) {
                    if($kk!='func' && $kk!='id'):
                        $tmp .= "{$kk}={$vv}&";
                    endif;
                }
            }
            Func::go_to($func_page . '.php?&'.$tmp);
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
            'title' => '熱賣商品設定',
            'type' => 'radio',
            'name' => 'ishot',
            'value' => $arr_data[0]['ishot'],
            'options'=>$arr_ishot
                )
        );
        array_push($data, array(
            'title' => '活動商品設定',
            'type' => 'radio',
            'name' => 'isevent',
            'value' => $arr_data[0]['isevent'],
            'options'=>$arr_isevent
                )
        );
        if($arr_data[0]['onshelf']==0){
            $onshelf = '';
        }else{
            $onshelf = date('Y-m-d H:i',$arr_data[0]['onshelf']);
        }
        array_push($data, array(
            'title' => '上架時間',
            'type' => 'datetime',
            'name' => 'onshelf',
            'help' => '如為空值，即為立即上架。',
            'value' => $onshelf
            )
        );
        if($arr_data[0]['offshelf']==0){
            $offshelf = '';
        }else{
            $offshelf = date('Y-m-d H:i',$arr_data[0]['offshelf']);
        }
        array_push($data, array(
            'title' => '下架時間',
            'type' => 'datetime',
            'name' => 'offshelf',
            'help' => '如為空值，即為沒有下架期限。',
            'value' => $offshelf
            )
        );
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'length' => 4,
            'max_length' => 4,
            'help' => '數字越大，排序越前面。',
            'value' => $arr_data[0]['sort']
                )
        );    

        array_push($data, array(
            'title' => '加價購產品',
            'type' => 'list1'
            )
        );  
        array_push($data, array(
            'title' => '原價',
            'type' => 'text',
            'name' => 'original_price',
             "required" => true,
            'value' => $arr_data[0]['original_price']
            )
        );
        array_push($data, array(
            'title' => '特價',
            'type' => 'text',
            'name' => 'discounted_price',
             "required" => true,
            "help" => "若為0則顯示原價。",
            'value' => $arr_data[0]['discounted_price']
            )
        );   
        array_push($data, array(
            'title' => '名稱',
            'type' => 'text',
            'name' => 'title',
            'value' => $arr_data[0]['title'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );     
        array_push($data, array(
                'title' => '簡述',
                'type' => 'textarea',
                'name' => 'summary',
                'rows' => 3,
                'value' => $arr_data[0]['summary']
            )
        );   
        array_push($data, array(
                'title' => '說明',
                'type' => 'html',
                'name' => 'content',
                'height' => '300',
                'value' => $arr_data[0]['content']
            )
        );       
        array_push($data, array(
            'title' => '圖片',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
                'title' => '封面圖',
                'type' => 'image',
                'name' => 'img',
                'value' => $arr_data[0]['img'],
                'help' => '建議寬高: 201 * 159 ，或等比例之圖片。',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                // 'max_size' => 4096,
                'delete' => true
            )
         );
        array_push($data, array(
                'title' => '商品圖1',
                'type' => 'image',
                'name' => 'img1',
                'value' => $arr_data[0]['img1'],
                'help' => '建議寬高: 450 * 450 ，或等比例之圖片。',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                // 'max_size' => 4096,
                'delete' => true
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
        $product_id = $_GET['id'];        
        $strSQL = "SELECT * FROM product WHERE id = '$product_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('product',"id='$product_id'");
        $$tmp = '';
        if(is_array($arg)){
            foreach ($arg as $kk => $vv) {
                if($kk!='func' && $kk!='id'):
                    $tmp .= "{$kk}={$vv}&";
                endif;
            }
        }
        Func::go_to($func_page . '.php?&'.$tmp);
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
            if(is_array($_FILES)){
                if($_FILES['img']['tmp_name']){
                    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $array_img_ext) === false){
                        FuncSite::msg_box_error('圖片格式錯誤！');
                        Func::go_to(-1);                            
                        exit;
                    }
                    $img = time().rand(100,999) . '.' . $ext;
                    // @copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                    if($ext=='png' || $ext=='gif'){
                        Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 201, 159);
                    }else{
                        Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 201, 159);
                    }
                }
                if($_FILES['img1']['tmp_name']){
                    $ext = strtolower(pathinfo($_FILES['img1']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $array_img_ext) === false){
                        FuncSite::msg_box_error('圖片格式錯誤！');
                        Func::go_to(-1);                            
                        exit;
                    }
                    $img1 = time().rand(100,999) . '.' . $ext;
                    // @copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                    if($ext=='png' || $ext=='gif'){
                        Func::ImageResize_Transparent($_FILES['img1']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img1, 450, 450);
                    }else{
                        Func::ImageResize($_FILES['img1']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img1, 450, 450);
                    }
                }
            }
            // $isegg1 = $_POST['isegg'];
            // $isegg_fin = implode(',', $isegg1);
            $recommend = implode(',', $_POST['recommend']);
            $data = array(
                'create_date'=>$create_date,
                'title'=>$title,
                'type'=> '1',
                'update_date'=>$update_date,
                'status'=>$status,
                'ishot'=>$ishot,
                'isevent'=>$isevent,
                'sort'=>$sort,
                'original_price'=>$original_price,
                'discounted_price'=>$discounted_price,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
                'content'=>$content,
                'img'=>$img,
                'img1'=>$img1,
                'recommend'=>$recommend,
                'summary'=>$summary,
            );
            $a = $db->insert('product',$data);
            $insert_id = $db->lastInsertId();
            if($a){
                  //分類寫入
                foreach(explode(',',trim($_POST['i_category_id'])) as $vv){
                    // echo $vv."<br>";
                    if(preg_match('/^([0-9]+)$/',$vv)){
                        // echo $vv."<br>";
                        $strSQL = "insert into list_insert_price_detail values(null,'$insert_id','$vv','baby_product');";
                        $db->Execute($strSQL);
                        $strSQL = "SELECT * FROM list_insert_price_detail WHERE templet_id='$insert_id' and class_id='".$rs[0]['id']."'";
                        $rs1=$db->Execute($strSQL);
                        if($rs1[0]['id']==null){
                        $strSQL = "insert into list_insert_price_detail values(null,'$insert_id','".$rs[0]['id']."','baby_product');";
                        // echo $strSQL.'<br>';
                        $db->Execute($strSQL);
                        }
                    }
                }
                
                
                FuncSite::msg_box('新增成功！');
            }else{
                FuncSite::msg_box_error('新增失敗！');
            }            
            $tmp = '';
            if(is_array($arg)){
                foreach ($arg as $kk => $vv) {
                    if($kk!='func' && $kk!='id'):
                        $tmp .= "{$kk}={$vv}&";
                    endif;
                }
            }
            Func::go_to($func_page . '.php?&'.$tmp);
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
            'title' => '熱賣商品設定',
            'type' => 'radio',
            'name' => 'ishot',
            'value' => 1,
            'options'=>$arr_ishot
                )
        );
        array_push($data, array(
            'title' => '活動商品設定',
            'type' => 'radio',
            'name' => 'isevent',
            'value' => 1,
            'options'=>$arr_isevent
                )
        );
        array_push($data, array(
            'title' => '上架時間',
            'type' => 'datetime',
            'name' => 'onshelf',
            'help' => '如為空值，即為立即上架。',
            )
        );
        array_push($data, array(
            'title' => '下架時間',
            'type' => 'datetime',
            'name' => 'offshelf',
            'help' => '如為空值，即為沒有下架期限。',
            )
        );
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'length' => 4,
            'max_length' => 4,
            'help' => '數字越大，排序越前面。',
            'value' => 10
                )
        );        
        array_push($data, array(
            'title' => '加價購商品',
            'type' => 'list1'
            )
        ); 
        array_push($data, array(
            'title' => '原價',
            'type' => 'text',
            'name' => 'original_price',
             "required" => true,
            )
        );
        array_push($data, array(
            'title' => '特價',
            'type' => 'text',
            'name' => 'discounted_price',
            "help" => "若為0則顯示原價。",
             "required" => true,
            )
        );     
        array_push($data, array(
            'title' => '名稱',
            'type' => 'text',
            'name' => 'title',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );     
        array_push($data, array(
                'title' => '簡述',
                'type' => 'textarea',
                'name' => 'summary',
                'rows' => 3,
            )
        );   
        array_push($data, array(
                'title' => '說明',
                'type' => 'html',
                'name' => 'content',
                'height' => '300',
            )
        );  
        array_push($data, array(
            'title' => '圖片',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
                'title' => '封面圖',
                'type' => 'image',
                'name' => 'img',
                'help' => '建議寬高: 201 * 159 ，或等比例之圖片。',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                // 'max_size' => 4096,
                'delete' => true
            )
         );
        array_push($data, array(
                'title' => '商品圖1',
                'type' => 'image',
                'name' => 'img1',
                'help' => '建議寬高: 450 * 450 ，或等比例之圖片。',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                // 'max_size' => 4096,
                'delete' => true
            )
         );
        $arr_form1 = array(
            "func" => 'insert',
            "form_name" => 'form1',
            "form_title" => '基本設定',
            "elements" => $data
        ); 
        break;
    case "copy":
        $product_id = $_GET['id'];
        $strSQL = "SELECT * FROM product WHERE id = '$product_id'";        
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $img = $arr_data[0]['img'];
        $img1 = $arr_data[0]['img1'];
        $img2 = $arr_data[0]['img2'];
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }

            $create_date = time();
            $update_date = time();
            $onshelf = strtotime($onshelf);
            $offshelf = strtotime($offshelf);
            if(is_array($_FILES)){
                if($_FILES['img']['tmp_name']){
                    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $array_img_ext) === false){
                        FuncSite::msg_box_error('圖片格式錯誤！');
                        Func::go_to(-1);                            
                        exit;
                    }
                    $img = time().rand(100,999) . '.' . $ext;
                    // @copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                    if($ext=='png' || $ext=='gif'){
                        Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 201, 159);
                    }else{
                        Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 201, 159);
                    }
                }
                if($_FILES['img1']['tmp_name']){
                    $ext = strtolower(pathinfo($_FILES['img1']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $array_img_ext) === false){
                        FuncSite::msg_box_error('圖片格式錯誤！');
                        Func::go_to(-1);                            
                        exit;
                    }
                    $img1 = time().rand(100,999) . '.' . $ext;
                    // @copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                    if($ext=='png' || $ext=='gif'){
                        Func::ImageResize_Transparent($_FILES['img1']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img1, 450, 450);
                    }else{
                        Func::ImageResize($_FILES['img1']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img1, 450, 450);
                    }
                }

            }
            $recommend = implode(',', $_POST['recommend']);
            $data = array(
                'create_date'=>$create_date,
                'title'=>$title,
                'type'=> '1',
                'sort'=>$sort,
                'status'=>$status,
                'ishot'=>$ishot,
                'isevent'=>$isevent,
                'update_date'=>$update_date,
                'img'=>$img,
                'img1'=>$img1,
                'original_price'=>$original_price,
                'discounted_price'=>$discounted_price,
                'content'=>$content,
                'onshelf'=>$onshelf,
                'offshelf'=>$offshelf,
                'recommend'=>$recommend,
                'summary'=>$summary,
            );
            $a = $db->insert('product',$data);
            $insert_id = $db->lastInsertId();
            if($a){
                  //分類寫入

                foreach(explode(',',trim($_POST['i_category_id'])) as $vv){
                    // echo $vv."<br>";
                    if(preg_match('/^([0-9]+)$/',$vv)){
                        // echo $vv."<br>";
                        $strSQL = "insert into list_insert_price_detail values(null,'$insert_id','$vv','baby_product');";
                        $db->Execute($strSQL);
                        $strSQL = "SELECT * FROM list_insert_price_detail WHERE templet_id='$insert_id' and class_id='".$rs[0]['id']."'";
                        $rs1=$db->Execute($strSQL);
                        if($rs1[0]['id']==null){
                        $strSQL = "insert into list_insert_price_detail values(null,'$insert_id','".$rs[0]['id']."','baby_product');";
                        // echo $strSQL.'<br>';
                        $db->Execute($strSQL);
                        }
                    }
                }
                FuncSite::msg_box('複製成功！');
            }else{
                FuncSite::msg_box_error('複製失敗！');
            }            
            $tmp = '';
            if(is_array($arg)){
                foreach ($arg as $kk => $vv) {
                    if($kk!='func' && $kk!='id'):
                        $tmp .= "{$kk}={$vv}&";
                    endif;
                }
            }
            Func::go_to($func_page . '.php?&'.$tmp);
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
            'title' => '熱賣商品設定',
            'type' => 'radio',
            'name' => 'ishot',
            'value' => $arr_data[0]['ishot'],
            'options'=>$arr_ishot
                )
        );
        array_push($data, array(
            'title' => '活動商品設定',
            'type' => 'radio',
            'name' => 'isevent',
            'value' => $arr_data[0]['isevent'],
            'options'=>$arr_isevent
                )
        );
        if($arr_data[0]['onshelf']==0){
            $onshelf = '';
        }else{
            $onshelf = date('Y-m-d H:i',$arr_data[0]['onshelf']);
        }
        array_push($data, array(
            'title' => '上架時間',
            'type' => 'datetime',
            'name' => 'onshelf',
            'help' => '如為空值，即為立即上架。',
            'value' => $onshelf
            )
        );
        if($arr_data[0]['offshelf']==0){
            $offshelf = '';
        }else{
            $offshelf = date('Y-m-d H:i',$arr_data[0]['offshelf']);
        }
        array_push($data, array(
            'title' => '下架時間',
            'type' => 'datetime',
            'name' => 'offshelf',
            'help' => '如為空值，即為沒有下架期限。',
            'value' => $offshelf
            )
        );
        array_push($data, array(
            'title' => '排序',
            'type' => 'text',
            'name' => 'sort',
            'length' => 4,
            'max_length' => 4,
            'help' => '數字越大，排序越前面。',
            'value' => $arr_data[0]['sort']
                )
        );    
        array_push($data, array(
            'title' => '加價購商品',
            'type' => 'list1'
            )
        );    
        array_push($data, array(
            'title' => '原價',
            'type' => 'text',
            'name' => 'original_price',
             "required" => true,
            'value' => $arr_data[0]['original_price']
            )
        );
        array_push($data, array(
            'title' => '特價',
            'type' => 'text',
            'name' => 'discounted_price',
             "required" => true,
             "help" => "若為0則顯示原價。",
            'value' => $arr_data[0]['discounted_price']
            )
        );      
        array_push($data, array(
            'title' => '名稱',
            'type' => 'text',
            'name' => 'title',
            'value' => $arr_data[0]['title'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );     
        array_push($data, array(
                'title' => '簡述',
                'type' => 'textarea',
                'name' => 'summary',
                'rows' => 3,
                'value' => $arr_data[0]['summary']
            )
        );   
        array_push($data, array(
                'title' => '說明',
                'type' => 'html',
                'name' => 'content',
                'height' => '300',
                'value' => $arr_data[0]['content']
            )
        );       
        array_push($data, array(
            'title' => '圖片',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
                'title' => '封面圖',
                'type' => 'image',
                'name' => 'img',
                'value' => $arr_data[0]['img'],
                'help' => '建議寬高: 201 * 159 ，或等比例之圖片。',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                // 'max_size' => 4096,
                'delete' => true
            )
         );
        array_push($data, array(
                'title' => '商品圖1',
                'type' => 'image',
                'name' => 'img1',
                'value' => $arr_data[0]['img1'],
                'help' => '建議寬高: 450 * 450 ，或等比例之圖片。',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                // 'max_size' => 4096,
                'delete' => true
            )
         );
        $arr_form1 = array(
            "func" => 'copy',
            "form_title" => '基本設定',
            "form_name" => 'form1',
            "elements" => $data
        );
        $arr_date  = array(
            "create_date" => $arr_data[0]['create_date'],
            "update_date" => $arr_data[0]['update_date']
        );    
        break;
    default:
        $arr_data = array();
        $andSQL = '';
        
        $andSQL .= "AND type = '1' " ;
        $status = $_GET['status'];
        $keyword = $_GET['keyword'];
        $class_id = $_GET['class_id'];
        $id = $_GET['id'];
        if($status!=''){
            $andSQL = "and status=".$status;
        }
        if($keyword!=''){
            $andSQL .= "and (title like '%".$keyword."%')";
        }

        $strSQL = "SELECT * FROM product WHERE 1 $andSQL ORDER BY sort DESC,id DESC";
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