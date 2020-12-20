<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id', SESSION_BACKEND);

switch ($_GET['func']):
case "update":
    $about_id = $_GET['id'];
    $strSQL = "SELECT * FROM about WHERE id = '$about_id'";
    $arr_data = $db->Execute($strSQL);
    if ($db->Affected_Rows() < 1) {
            FuncSite::msg_box_error('查無資料！'); 
            Func::go_to(-1);
            exit;
    }
    if ($_POST['flag'] == 'true') {
        foreach ($_POST as $kk => $vv) {
            $$kk = (trim($vv));
        }
        $create_date = strtotime($create_date, '00:00:00');
        $update_date = time();
        $data = array(
            'title' => $title,
            'content' => $content,
            'create_date' => $create_date,
            'update_date' => $update_date,
        );
        // print_r($data);
        // exit;
        $a = $db->update('about', $data, "id = '$about_id'");
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
        'title' => '發佈日期',
        'type' => 'date',
        'name' => 'create_date',
        'value' => date('Y-m-d', $arr_data[0]['create_date']),
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '標題',
        'type' => 'text',
        'name' => 'title',
        'value' => $arr_data[0]['title'],
        'length' => 30,
        'max_length' => 50,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '內容',
        'type' => 'textarea',
        'name' => 'content',
        'value' => $arr_data[0]['content'],
        'rows' => 4,
        "required" => true,
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
    $about_id = $_GET['id'];
    $strSQL = "SELECT * FROM about WHERE id = '$about_id'";
    $db->Execute($strSQL);
    if ($db->Affected_Rows() < 1) {
        FuncSite::msg_box_error('查無資料！');
        Func::go_to(-1);
        exit;
    }
    $db->delete('about', "id='$about_id'");
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
        // $create_date = time();
        $create_date = strtotime($create_date, '00:00:00');
        $update_date = time();
        $data = array(
            'create_date' => $create_date,
            'title' => $title,
            'content' => $content,
            'update_date' => $update_date,
        );
        // print_r($data);
        // exit;
        $a = $db->insert('about', $data);
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
        'title' => '發佈日期',
        'type' => 'date',
        'name' => 'create_date',
        'value' => date('Y-m-d'),
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '標題',
        'type' => 'text',
        'name' => 'title',
        'length' => 30,
        'max_length' => 50,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '內容',
        'type' => 'textarea',
        'name' => 'content',
        'rows' => 4,
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
    $strSQL = "SELECT * FROM about WHERE 1  ORDER BY create_date desc";
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
