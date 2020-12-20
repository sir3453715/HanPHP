<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id', SESSION_NAME);

switch ($_GET['func']):
default:
    $web_setting_id = 1;
    $strSQL = "SELECT * FROM web_setting WHERE id = '$web_setting_id'";
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
        $update_date = time();
        $data = array(
            'title' => $title,
            'keyword' => $keyword,
            'description' => $description,
            'update_date' => $update_date,
            'address' => $address,
            'tel' => $tel,
            'mail' => $mail,
            'fb' => $fb,
            'line' => $line,
            'ig' => $ig,
            'hours' => $hours,
            'bank_code' => $bank_code,
            'bank_account' => $bank_account,
            'account_name' => $account_name,
            'bank_name' => $bank_name,
            // 'free_ship'=>$free_ship
        );
        // print_r($data);
        // exit;
        $a = $db->update('web_setting', $data, "id = '$web_setting_id'");
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
        'title' => '網站標題',
        'type' => 'text',
        'name' => 'title',
        'value' => $arr_data[0]['title'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '網站描述',
        'type' => 'textarea',
        'name' => 'description',
        'rows' => 3,
        'value' => $arr_data[0]['description'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '網站關鍵字',
        'type' => 'textarea',
        'name' => 'keyword',
        'value' => $arr_data[0]['keyword'],
        'help' => '關鍵字請用 , 做分隔。',
        'rows' => 3,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '地址',
        'type' => 'text',
        'name' => 'address',
        'value' => $arr_data[0]['address'],
    )
    );
    array_push($data, array(
        'title' => '客服專線',
        'type' => 'text',
        'name' => 'tel',
        'value' => $arr_data[0]['tel'],
    )
    );
    array_push($data, array(
        'title' => '客服時間',
        'type' => 'text',
        'name' => 'hours',
        'value' => $arr_data[0]['hours'],
    )
    );
    array_push($data, array(
        'title' => '客服信箱',
        'type' => 'text',
        'name' => 'mail',
        'value' => $arr_data[0]['mail'],
    )
    );

    array_push($data, array(
        'title' => '銀行代碼',
        'type' => 'text',
        'name' => 'bank_code',
        'value' => $arr_data[0]['bank_code'],
    )
    );
    array_push($data, array(
        'title' => '銀行帳號',
        'type' => 'text',
        'name' => 'bank_account',
        'value' => $arr_data[0]['bank_account'],
    )
    );
    array_push($data, array(
        'title' => '銀行戶名',
        'type' => 'text',
        'name' => 'account_name',
        'value' => $arr_data[0]['account_name'],
    )
    );
    array_push($data, array(
        'title' => '銀行名稱',
        'type' => 'text',
        'name' => 'bank_name',
        'value' => $arr_data[0]['bank_name'],
    )
    );

    array_push($data, array(
        'title' => 'Facebook',
        'type' => 'text',
        'name' => 'fb',
        'value' => $arr_data[0]['fb'],
        'help' => '請輸入網址後半部:https://www.facebook.com/"輸入部分"',
    )
    );
    array_push($data, array(
        'title' => 'Line',
        'type' => 'text',
        'name' => 'line',
        'value' => $arr_data[0]['line'],
        'help' => '請輸入網址後半部:https://line.me/"輸入部分"',
    )
    );
    array_push($data, array(
        'title' => 'Instagram',
        'type' => 'text',
        'name' => 'ig',
        'value' => $arr_data[0]['ig'],
        'help' => '請輸入網址後半部 : https://www.instagram.com/"輸入部分"',
    )
    );
    // array_push($data, array(
    //     'title' => '免運費金額',
    //     'type' => 'text',
    //     'name' => 'free_ship',
    //     'value' => $arr_data[0]['free_ship'],
    //     // 'help' => '請填入完整網址。',
    //     )
    // );
    $arr_form1 = array(
        "func" => 'update',
        "form_title" => '網站優化設定',
        "form_name" => 'form1',
        "elements" => $data,
    );
    $arr_date = array(
        "update_date" => $arr_data[0]['update_date'],
    );
    endswitch;
