<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id', SESSION_BACKEND);

switch ($_GET['func']):
case "update":
    $baby_card_id = $_GET['id'];
    $strSQL = "SELECT * FROM baby_card WHERE id = '$baby_card_id'";
    $arr_data = $db->Execute($strSQL);
    if ($db->Affected_Rows() < 1) {
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
    }
    // echo $arr_data[0]['seccode'];
    $strSQL = "SELECT * FROM `card_set` WHERE id in(SELECT card_style_id FROM `baby_card` WHERE seccode='" . $arr_data[0]['seccode'] . "')";
    // echo $strSQL;
    $card_style = $db->Execute($strSQL);
    $baby_pic = $arr_data[0]['baby_pic'];
    if ($_POST['flag'] == 'true') {
        foreach ($_POST as $kk => $vv) {
            $$kk = (trim($vv));
        }
        $address = $county . $district . $addr;
        $update_date = time();
        if ($_FILES) {
            if ($_FILES['baby_pic']['tmp_name']) {
                $ext = strtolower(pathinfo($_FILES['baby_pic']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false) {
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);

                    exit;
                }
                $baby_pic = time() . rand(100, 999) . '.' . $ext;
                if ($ext == 'png' || $ext == 'gif') {
                    Func::ImageResize_Transparent($_FILES['baby_pic']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $baby_pic, 400, 250);
                } else {
                    Func::ImageResize($_FILES['baby_pic']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $baby_pic, 400, 250);
                }

            }
        }
        if ($del_baby_pic == 'true') {
            $baby_pic = '';
        }
        $data = array(
            'note' => $note,
        );
        // print_r($data);
        // exit;
        $a = $db->update('baby_card', $data, "id = '$baby_card_id'");
        if (!$a) {
            FuncSite::msg_box('更新成功！');
        } else {
            FuncSite::msg_box_error('更新失敗！');
        }
        Func::go_to($func_page . '.php');
        exit;
    }

    $data = array();
    array_push($data, array(
        'title' => '訂單編號',
        'type' => 'text_show',
        'name' => 'seccode',
        'value' => $arr_data[0]['seccode'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '爸爸名字',
        'type' => 'text_show',
        'name' => 'dad_name',
        'value' => $arr_data[0]['dad_name'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '媽媽名字',
        'type' => 'text_show',
        'name' => 'mom_name',
        'value' => $arr_data[0]['mom_name'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶名字',
        'type' => 'text_show',
        'name' => 'baby_name',
        'value' => $arr_data[0]['baby_name'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶照片',
        'type' => 'image_babycard_download',
        'name' => 'baby_pic',
        'value' => $arr_data[0]['baby_pic'],
        'pre_folder' => "https://shop.mousecake.com.tw/webimages",
        // 'max_size' => 4096,
        // 'download' => true
    )
    );
    array_push($data, array(
        'title' => '寶寶性別',
        'type' => 'select_show',
        'name' => 'sex',
        'options' => $arr_sex,
        'value' => $arr_data[0]['sex'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶生日',
        'type' => 'text_show',
        'name' => 'baby_birthday',
        'value' => $arr_data[0]['baby_birthday'],
    )
    );
    array_push($data, array(
        'title' => '小卡名稱',
        'type' => 'text_show',
        'name' => 'title',
        'value' => $card_style[0]['title'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '小卡樣式',
        'type' => 'image_show',
        'name' => 'img',
        'value' => $card_style[0]['img'],
        'pre_folder' => __WEB_IMAGES_FOLDER,
        // 'max_size' => 4096,
        // 'download' => true
    )
    );

    array_push($data, array(
        'title' => '給寶寶祝福的話',
        'type' => 'textarea_show',
        'name' => 'wish',
        'value' => $arr_data[0]['wish'],
    )
    );
    array_push($data, array(
        'title' => '管理員備註',
        'type' => 'textarea',
        'name' => 'note',
        'rows' => 4,
        'value' => $arr_data[0]['note'],
    )
    );
    $arr_form1 = array(
        "func" => 'update',
        "form_title" => '基本設定',
        "form_name" => 'form1',
        "elements" => $data,
    );
    $arr_date = array(
        "create_date" => $arr_data[0]['create_date'],
        "update_date" => $arr_data[0]['update_date'],
    );
    break;
case "delete":
    $baby_card_id = $_GET['id'];
    $strSQL = "SELECT * FROM baby_card WHERE id = '$baby_card_id'";
    $db->Execute($strSQL);
    if ($db->Affected_Rows() < 1) {
        FuncSite::msg_box_error('查無資料！');
        Func::go_to(-1);
        exit;
    }
    $db->delete('baby_card', "id='$baby_card_id'");
    $curr_page = $_GET['curr_page'];
    if ($curr_page != '') {
        Func::go_to($func_page . '.php?curr_page=' . $curr_page);
    } else {
        Func::go_to($func_page . '.php');
    }
    exit;
    break;
case "insert":
    if ($_POST['flag'] == 'true') {
        // print_r($_POST);
        // exit;
        foreach ($_POST as $kk => $vv) {
            $$kk = (trim($vv));
        }
        $address = $county . $district . $addr;
        $create_date = time();
        $update_date = time();
        if ($_FILES) {
            if ($_FILES['baby_pic']['tmp_name']) {
                $ext = strtolower(pathinfo($_FILES['baby_pic']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false) {
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);

                    exit;
                }
                $baby_pic = time() . rand(100, 999) . '.' . $ext;
                if ($ext == 'png' || $ext == 'gif') {
                    Func::ImageResize_Transparent($_FILES['baby_pic']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $baby_pic, 400, 250);
                } else {
                    Func::ImageResize($_FILES['baby_pic']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $baby_pic, 400, 250);
                }

            }
        }
        $data = array(
            'seccode' => $seccode,
            'dad_name' => $dad_name,
            'mom_name' => $mom_name,
            'baby_name' => $baby_name,
            'baby_pic' => $baby_pic,
            'baby_birthday' => $baby_birthday,
            'sex' => $sex,
            'wish' => $wish,
            'note' => $note,
        );
        // print_r($data);
        // exit;
        $a = $db->insert('baby_card', $data);
        if ($a) {
            FuncSite::msg_box('新增成功！');
        } else {
            FuncSite::msg_box_error('新增失敗！');
        }
        Func::go_to($func_page . '.php');
        exit;
    }
    $data = array();
    array_push($data, array(
        'title' => '訂單編號',
        'type' => 'text',
        'name' => 'seccode',
        'value' => $arr_data[0]['seccode'],
        'length' => 30,
        'max_length' => 50,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '爸爸名字',
        'type' => 'text',
        'name' => 'dad_name',
        'value' => $arr_data[0]['dad_name'],
        'length' => 30,
        'max_length' => 50,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '媽媽名字',
        'type' => 'text',
        'name' => 'mom_name',
        'value' => $arr_data[0]['mom_name'],
        'length' => 30,
        'max_length' => 50,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶名字',
        'type' => 'text',
        'name' => 'baby_name',
        'value' => $arr_data[0]['baby_name'],
        'length' => 30,
        'max_length' => 50,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶照片',
        'type' => 'image',
        'name' => 'baby_pic',
        'value' => $arr_data[0]['baby_pic'],
        'pre_folder' => __WEB_IMAGES_FOLDER,
        // 'max_size' => 4096,
        'download' => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶性別',
        'type' => 'text',
        'name' => 'sex',
        'value' => $arr_data[0]['sex'],
        'length' => 30,
        'max_length' => 50,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶生日',
        'type' => 'text',
        'name' => 'baby_birthday',
        'length' => 4,
        'max_length' => 4,
        'value' => $arr_data[0]['baby_birthday'],
    )
    );
    array_push($data, array(
        'title' => '給寶寶祝福的話',
        'type' => 'text',
        'name' => 'wish',
        'length' => 4,
        'max_length' => 4,
        'value' => $arr_data[0]['wish'],
    )
    );
    array_push($data, array(
        'title' => '管理員備註',
        'type' => 'text',
        'name' => 'note',
        'length' => 4,
        'max_length' => 4,
        'value' => $arr_data[0]['note'],
    )
    );
    $arr_form1 = array(
        "func" => 'insert',
        "form_name" => 'form1',
        "form_title" => '基本設定',
        "elements" => $data,
    );
    break;
default:
    $arr_data = array();
    $andSQL = '';
    $status = $_GET['status'];
    if ($status != '' and $status != 3) {
        $andSQL .= " and status = " . $status;
    }
    $strSQL = "SELECT * FROM baby_card WHERE 1 $andSQL AND isset = '1' ORDER BY seccode desc";
    // echo $strSQL;
    // exit;
    $rs = $db->Execute($strSQL);
    $rows = $db->Affected_Rows();
    $curr_page = $_GET['curr_page'];
    $last_page = ceil($rows / __DATA_PER_PAGE);
    if ($curr_page > $last_page) {
        $curr_page = $last_page;
    }

    if ($curr_page < 1) {
        $curr_page = 1;
    }

    if ($last_page == 0) {
        $curr_page = 0;
    }

    $arr_data = $db->PageExecute($strSQL, __DATA_PER_PAGE, $curr_page);
    endswitch;
