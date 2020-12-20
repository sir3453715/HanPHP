<?php
//phpinfo();
//exit;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$member_id = Session::get('member_id', 'morning');

switch ($_GET['func']):
case "update":
    $apply_id = $_GET['id'];
    $strSQL = "SELECT * FROM apply WHERE id = '$apply_id'";
    $arr_data = $db->Execute($strSQL);
    if ($db->Affected_Rows() < 1) {
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
    }

    //更新為已讀
    if ($arr_data['0']['isread'] == '0') {
        $data = array('isread' => '1');
        $a = $db->update('apply', $data, "id = '$apply_id'");
    }
    if ($_POST['flag'] == 'true') {
        foreach ($_POST as $kk => $vv) {
            $$kk = (trim($vv));
        }
        $update_date = time();
        if ($content_re != '' && $arr_data[0]['issend'] == 0) {
            $message = nl2br($content_re);

            include "../mail.php";
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->CharSet = 'utf-8';
                $mail->Encoding = 'base64';
                $mail->isSMTP();
                $mail->Host = __MAIL_SERVER;
                $mail->SMTPAuth = true;
                $mail->Username = __MAIL_NAME;
                $mail->Password = __MAIL_PASSWORD;
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                //Recipients
                $mail->setFrom(__MAIL_FROM, 'mousecake 杏屋乳酪蛋糕');
                $mail->addAddress($arr_data[0]['email']);
                // $mail->addBCC($value['title']);

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'mousecake 杏屋乳酪蛋糕 - 試吃申請';
                $mail->Body = $output;
                $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
                $mail->send();
                $data = array(
                    'update_date' => $update_date,
                    'content_re' => $content_re,
                    'isread' => '2',
                    'remark' => $remark,
                    'issend' => '1',
                    'update_date' => $update_date,
                );
                $a = $db->update('apply', $data, "id = '$apply_id'");
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        } else {
            $data = array(
                'update_date' => $update_date,
                'isread' => $isread,
                'remark' => $remark,
                'update_date' => $update_date,
            );
            $a = $db->update('apply', $data, "id = '$apply_id'");
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
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '電話',
        'type' => 'text_show',
        'value' => trim(Encryption::ZxingCrypt($arr_data[0]['phone'], "DECODE")),
        'name' => 'phone',
    )
    );
    array_push($data, array(
        'title' => '宅配地址',
        'type' => 'text_show',
        'name' => 'address',
        'value' => trim(Encryption::ZxingCrypt($arr_data[0]['address'], "DECODE")),
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => 'E-mail',
        'type' => 'text_show',
        'name' => 'email',
        'value' => $arr_data[0]['email'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '預算金額',
        'type' => 'text_show',
        'name' => 'address',
        'value' => $arr_data[0]['budget_money'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '預算盒數',
        'type' => 'text_show',
        'name' => 'address',
        'value' => $arr_data[0]['budget_box'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '付款方式',
        'type' => 'text_show',
        'name' => 'payment',
        'value' => $arr_data[0]['payment'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '預產期',
        'type' => 'text_show',
        'name' => 'due_date',
        'value' => $arr_data[0]['due_date'],
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '備註',
        'type' => 'textarea_show',
        'name' => 'note',
        'value' => nl2br($arr_data[0]['note']),
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '寶寶照片/媽媽手冊',
        'type' => 'image_show',
        'name' => 'baby_pic',
        'value' => $arr_data[0]['baby_pic'],
        'pre_folder' => __WEB_IMAGES_FOLDER,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '狀態',
        'type' => 'select',
        'name' => 'isread',
        'options' => $arr_isread1,
        'value' => $arr_data[0]['isread'],
        "required" => true,
    )
    );
    if ($arr_data[0]['issend'] == 0) {
        array_push($data, array(
            'title' => '回信內容',
            'type' => 'textarea',
            'name' => 'content_re',
            'value' => nl2br($arr_data[0]['content_re']),
            'rows' => 5,
        )
        );
    } else {
        array_push($data, array(
            'title' => '回信內容',
            'type' => 'textarea_show',
            'name' => 'content_re',
            'value' => nl2br($arr_data[0]['content_re']),
            'rows' => 5,
        )
        );
    }
    array_push($data, array(
        'title' => '管理員備註',
        'type' => 'textarea',
        'name' => 'remark',
        'value' => nl2br($arr_data[0]['remark']),
        'rows' => 5,
    )
    );
    $arr_form1 = array(
        "func" => 'update',
        "form_title" => '試吃申請',
        "form_name" => 'form1',
        "elements" => $data,
    );
    $arr_date = array(
        "create_date" => $arr_data[0]['create_date'],
        "update_date" => $arr_data[0]['update_date'],
        "last_login_date" => $arr_login[0]['update_time'],
        "last_login_ip" => $arr_login[0]['client_ip'],
    );
    break;
case "delete":
    $apply_id = $_GET['id'];
    $strSQL = "SELECT * FROM apply WHERE id = '$apply_id'";
    $db->Execute($strSQL);
    if ($db->Affected_Rows() < 1) {
        FuncSite::msg_box_error('查無資料！');
        Func::go_to(-1);
        exit;
    }
    $db->delete('apply', "id='$apply_id'");
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
        foreach ($_POST as $kk => $vv) {
            $$kk = (trim($vv));
        }
        $create_date = time();
        $update_date = time();
        $data = array(
            'create_date' => $create_date,
            'update_date' => $update_date,
            'name' => $name, 'sex' => $radiogroup1,
            'tel' => $tel,
            'phone' => $phone,
            'email' => $email,
            'subject' => $subject,
            'content' => $content,
            'content_re' => $content_re,
            'isread' => $isread,
        );
        $a = $db->insert('apply', $data);
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
        'title' => '狀態',
        'type' => 'select',
        'name' => 'isread',
        'options' => $arr_isread1,
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '姓名',
        'type' => 'text',
        'name' => 'name',
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '連絡電話',
        'type' => 'text',
        'name' => 'tel',
    )
    );
    array_push($data, array(
        'title' => '行動電話',
        'type' => 'text',
        'name' => 'phone',
    )
    );
    array_push($data, array(
        'title' => '電子郵件',
        'type' => 'text',
        'name' => 'email',
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '內容',
        'type' => 'textarea',
        'name' => 'content',
        "required" => true,
    )
    );
    array_push($data, array(
        'title' => '備註',
        'type' => 'textarea',
        'name' => 'content_re',
        'value' => '',
        'rows' => 5,
    )
    );
    $arr_form1 = array(
        "func" => 'insert',
        "form_name" => 'form1',
        "form_title" => '問題設定',
        "elements" => $data,
    );
    break;
default:
    $arr_data = array();
    $andSQL = '';
    $strSQL = "SELECT * FROM apply WHERE 1 $andSQL ORDER BY create_date desc";
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
