<?php

//phpinfo();
//exit;
switch ($_GET['func']):

    default:
    $strSQL = "SELECT * FROM desktop_list WHERE member_id not in(SELECT id FROM member WHERE m_name='亞葳執行長'and m_name='亞葳執行長') ORDER BY update_time DESC LIMIT 10";
    //   $strSQL = "SELECT * FROM desktop_list WHERE member_id='".Session::get('member_id',SESSION_NAME)."' ORDER BY update_time DESC LIMIT 10";
      $arr_data = $db->Execute($strSQL);
        /*
        $curr_page = $_GET['curr_page'];
        if (!is_numeric($curr_page))
        {
            $curr_page = 1;
        }
        $strSQL = "select * from shareman_login_log where shareman_id='" . GetSQLValueString($_SESSION['shareman']['id']) . "' order by id desc";

        //echo $strSQL;
        //exit;
        $rs = $db->Execute($strSQL);
        $rows = $db->Affected_Rows();
        $last_page = ceil($rows / __DATA_PER_PAGE);
        $rs = $db->PageExecute($strSQL, __DATA_PER_PAGE, $curr_page);
        $arr_data = $rs->GetArray();
        */

endswitch;
?>
