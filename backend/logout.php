<?php
require('public_include.php');
Session::destory(SESSION_BACKEND);
header("Location:./index.php" );