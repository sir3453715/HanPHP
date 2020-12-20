<?php
//    $strSQL = "SELECT count(*) FROM `orders` WHERE `isread`  = '0'";
//    $count_orders = $db->Execute($strSQL);
?>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="通知"> <i class="fa fa-bell"></i>
        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
    </a>
    <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
        <ul>
            <li>
                <div class="drop-title">通知</div>
            </li>
            <li>
                <div class="message-center">
                    <a href="orders.php">
                        <div class="btn btn-danger btn-circle m-r-10"><i class="fa fa-edit"></i></div>
                        <div class="mail-contnet">
                            <h5>一般訂單</h5> <span class="mail-desc">您有 1 筆新訂單</span>
                        </div>
                    </a>
                    <a href="contact.php">
                        <div class="btn btn-info btn-circle m-r-10"><i class="fa fa-comment"></i></div>
                        <div class="mail-contnet">
                            <h5>留言</h5> <span class="mail-desc">您有 1 筆客戶留言</span>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</li>
<!-- End Comment -->

<li class="nav-item">
    <a href="javascript:void(0);" class="nav-link dropdown-toggle text-muted text-muted  ">
        <i class="fa fa-user fa-fw"></i><?=Session::get('member_name',SESSION_BACKEND)?>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link dropdown-toggle text-muted text-muted  " href="start.php" title="資訊後台"> 
        <i class="fa fa-tachometer"></i>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link dropdown-toggle text-muted text-muted  " target="_blank" href="../index.php" title="網站前台">
        <i class="fa fa-external-link"></i>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link dropdown-toggle text-muted text-muted  " href="logout.php" title="登出">
        <span class="fa fa-power-off" aria-hidden="true"></span>
    </a>
</li>