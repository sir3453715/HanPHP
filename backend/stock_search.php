<?php
    require('public_include.php');
    
    //get search term
    // $searchTerm = $_GET['term'];
    
    // //get matched data from skills table
    // $strSQL = "select * from stock_information WHERE STOCK_DESC LIKE '%".$searchTerm."%' ORDER BY STOCK_DESC ASC";
    // $stock_information = $db->Execute($strSQL); 
    // foreach ($stock_information as $value) {
    //     $data[] = $row['STOCK_DESC'];
    // }
    
    // //return json data
    // echo json_encode($data);
    if(!empty($_POST["keyword"])) {
        $strSQL ="SELECT * FROM orders WHERE seccode like '%" . $_POST["keyword"] . "%' ORDER BY seccode desc limit 6";
        $result = $db->Execute($strSQL); 
        if(!empty($result)) {
?>
    <ul id="country-list" class="contact">
<?php
    $i = 0;
    foreach($result as $result1) {
        // if($i==0){
?>
    <!-- <li class="cp" onclick="selectval(<?=$result1["seccode"]?>);"><?=str_replace($_POST['keyword'], "<font color='red'>".$_POST['keyword']."</font>", $result1["seccode"]) ?></li> -->
<?php 
        // }else{
?>
    <li onclick="selectval(<?=$result1["seccode"]?>);"><?=str_replace($_POST['keyword'], "<font color='red'>".$_POST['keyword']."</font>", $result1["seccode"]) ?></li>
<?php           
        // }
        $i++;
    } 
?>
    </ul>
<?php 
        } 
    } 
?>