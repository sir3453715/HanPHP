<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Colorlib">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>數位後台管理系統</title>
    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- All Jquery -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
  <!-- Preloader - style you can find in spinners.css -->
  <div class="preloader">
      <svg class="circular" viewBox="25 25 50 50">
    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
  </div>
  <!-- Main wrapper  -->
  <div id="main-wrapper">
      <!-- header header  -->
      <div class="header">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- Logo -->
            <div class="navbar-header">
                <a class="navbar-brand" href="./index.php">
                    <!-- Logo icon -->
                    <b>Logo</b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span>Logo</span>
                </a>
            </div>
            <!-- End Logo -->
            <div class="navbar-collapse">
              <!-- toggle and nav items -->
              <ul class="navbar-nav mr-auto mt-md-0">
                  <!-- This is  -->
                  <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                  <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
              </ul>
              <ul class="navbar-nav my-lg-0">
                <?php
                  require 'top.php';
                ?>
              </ul>
            </div>
        </nav>
      </div>
      <!-- End header header -->
      <!-- Left Sidebar  -->
      <div class="left-sidebar">
          <!-- Sidebar scroll-->
          <div class="scroll-sidebar">
              <!-- Sidebar navigation-->
              <nav class="sidebar-nav">
              <?php
                require 'menu.php';
              ?>
              </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </div>
    <!-- End Left Sidebar  -->
    <!-- Page wrapper  -->
    <div class="page-wrapper">
      <?php
        require $content_page;
      ?>
    </div>
        <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/lib/toastr/toastr.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
</body>
</html>
<script>
    function upd(id){
      location.href="<?=$func_page?>.php?func=update&id="+id;
      return false;
    }
    function upd1(id){
        location.href="<?=$func_page?>.php?func=update&id="+id+"&<?=$tmp?>";
        return false;
    }
    function copy(id) {
        location.href = "<?=$func_page;?>.php?&func=copy&id=" + id;
        return false;
    }
    function copy1(id) {
        location.href = "<?=$func_page;?>.php?&func=copy&id=" + id + '&class_id=<?=$class_id;?>';
        return false;
    }
    function permissions(id){
      location.href="<?=$func_page?>.php?func=permissions&id="+id;
      return false;
    }
    function del(id){
      swal({
        title: '確定要刪除?',
        // text: 'You will not be able to recover this imaginary file!',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("刪除完成!", {
            icon: "success",
          });
          location.href="<?=$func_page?>.php?func=delete&id="+id;
        } else {
          swal(
            'Cancelled',
            '你已點選取消！',
            'error'
          )
        }
      });
    }
    function del1(id){
      swal({
        title: '確定要刪除?',
        // text: 'You will not be able to recover this imaginary file!',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("刪除完成!", {
            icon: "success",
          });
          location.href="<?=$func_page?>.php?func=delete&id="+id+"&<?=$tmp?>";
        } else {
          swal(
            'Cancelled',
            '你已點選取消！',
            'error'
          )
        }
      });
    }
     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            $('#'+input.id+'_img').show();
            reader.onload = function (e) {
                $('#'+input.id+'_img')
                        .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    function selAll(name){
      //變數checkItem為checkbox的集合
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        checkItem[i].checked=true;   
      }
    }
    function unselAll(name){
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        checkItem[i].checked=false;
      }
    }
    function usel(name){
      //變數checkItem為checkbox的集合
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        checkItem[i].checked=!checkItem[i].checked;
      }
    }
    function addnumber(id,table,field){
      var number = 'number_' + id;
      var numberValue = document.getElementById(number).value;
      reset();
      toastr.confirm("確定要增加數量?", function (e) {
        console.log(e);
        if (e) {
           $.ajax({type: "POST", dataType: "text", url: "addnumber.php", data: {id: id, value: numberValue, table:table, field:field}, success: function (data) {
            toastr.success('數量新增成功！');          
                    }, beforeSend: function () {
                    }, complete: function () {
                      window.location.reload();
                    }})
        } else {
          toastr.error("你已點選取消!");
        }
      }); 
      return false;
    }
    function changesort(id,table){
      var sort = 'sort_' + id;
      var sortValue = document.getElementById(sort).value;
       $.ajax({type: "POST", dataType: "text", url: "changesort.php", data: {id: id, value: sortValue, table:table}, success: function (data) {
                      toastr.success('排序更新成功！');    
                    }, beforeSend: function () {
                    }, complete: function () {
                      window.location.reload();
                    }})

    }
    function changeon(name,table,field){
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
          var id = checkItem[i].value;
           $.ajax({type: "POST", dataType: "text", url: "changestatus.php", data: {id: id, table:table, field: field, status:'1'}, success: function (data) {
            //  console.log(data);
            toastr.success('狀態更新成功！');        
                      }, beforeSend: function () {
                      }, complete: function () {
                        window.location.reload();
          }})
          }
      }
    }
    function changeoff(name,table,field){
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
          var id = checkItem[i].value;
           $.ajax({type: "POST", dataType: "text", url: "changestatus.php", data: {id: id, table:table, field: field, status:'0'}, success: function (data) {
            
            toastr.success('狀態更新成功！');        
                      }, beforeSend: function () {
                      }, complete: function () {
                        window.location.reload();
          }})
        }
      }
    }
    function changestatus(name,table,field,val){
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
          var id = checkItem[i].value;
           $.ajax({type: "POST", dataType: "text", url: "changestatus.php", data: {id: id, table:table, field: field, status:val}, success: function (data) {
            toastr.success('狀態更新成功！');        
                      }, beforeSend: function () {
                      }, complete: function () {
                        window.location.reload();
          }})
        }
      }
    }
    function batchdelete(name,table){
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
          var id = checkItem[i].value;
           $.ajax({type: "POST", dataType: "text", url: "batchdelete.php", data: {id: id, table:table}, success: function (data) {
            //  console.log(data);
            toastr.success('刪除成功！');        
                      }, beforeSend: function () {
                      }, complete: function () {
                        window.location.reload();
          }})
        }
      }
    }
    function batchecinvoice(name,table){
      var checkItem = document.getElementsByName(name);
      for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
          var id = checkItem[i].value;
           $.ajax({type: "POST", dataType: "text", url: "batch_ec_invoice.php", data: {id: id, table:table}, success: function (data) {
                      
                      }, beforeSend: function () {
                      }, complete: function () {
                        window.location.reload();
          }})
        }
      }
      toastr.success('發票開立成功！');
    }
    function clear_time(name){
      $('#'+name).val('');
      return false;
    }
    $(document).ready(function(){
      <?php
      //alert
      if(is_array($_SESSION['client']['alert'])){
        // echo 'reset();';
        $tmp = '';
        foreach ($_SESSION['client']['alert'] as $kk => $vv) {
            $tmp .= $vv.'<br />';
        }
        // echo "toastr.success('".$tmp."');";
        echo "toastr.success('".$tmp."');";
        unset($_SESSION['client']['alert']);
      }
      if(is_array($_SESSION['client']['alert1'])){
        // echo 'reset();';
        $tmp = '';
        foreach ($_SESSION['client']['alert1'] as $kk => $vv) {
            $tmp .= $vv.'<br />';
        }
        echo "toastr.error('".$tmp."');";
        unset($_SESSION['client']['alert1']);
      }
      ?>
    });
    $('.datepicker').daterangepicker({
        autoUpdateInput:false,
        showDropdowns: true,
        singleDatePicker: true,
        locale: {
        format: 'YYYY-MM-DD',
            "separator": " - ",
            "applyLabel": "允許",
            "cancelLabel": "取消",
            "fromLabel": "From",
            "toLabel": "至",
            "customRangeLabel": "Custom",
            "weekLabel": "週",
            "daysOfWeek": [
                "日",
                "一",
                "二",
                "三",
                "四",
                "五",
                "六"
            ],
            "monthNames": [
                "一月",
                "二月",
                "三月",
                "四月",
                "五月",
                "六月",
                "七月",
                "八月",
                "九月",
                "十月",
                "十一月",
                "十二月"
            ],
            "firstDay": 1
        }
    });
    $('.datetime_class').daterangepicker({
        autoUpdateInput:false,
        showDropdowns: true,
        timePicker: true,
        singleDatePicker: true,
        locale: {
        format: 'YYYY-MM-DD HH:mm',
            "separator": " - ",
            "applyLabel": "允許",
            "cancelLabel": "取消",
            "fromLabel": "From",
            "toLabel": "至",
            "customRangeLabel": "Custom",
            "weekLabel": "週",
            "daysOfWeek": [
                "日",
                "一",
                "二",
                "三",
                "四",
                "五",
                "六"
            ],
            "monthNames": [
                "一月",
                "二月",
                "三月",
                "四月",
                "五月",
                "六月",
                "七月",
                "八月",
                "九月",
                "十月",
                "十一月",
                "十二月"
            ],
            "firstDay": 1
        }
    });
</script>
<script type="text/javascript">
    $(function() { 
        $(".table tbody").sortable({
            opacity: 0.6,    //拖曳時透明
            cursor: 'move',  //游標設定
            axis: 'y',       //只能垂直拖曳
            cancel: '.unsortable', //除外項目
            items: ">tr:not(.unsortable)",
            tolerance: 'pointer',
            revert: 'invalid',
            placeholder: 'vertical-md-middle',
            forceHelperSize: true,
            // start: function (event, ui) {
            //     var start_pos = ui.item.index();
            //     ui.item.data('start_pos', start_pos);
            // },
            update: function(event, ui) { 
              // var oldIndex = ui.item.data('start_pos');
              // var newIndex = ui.item.context.rowIndex;
              var productOrder = $('.table tbody').sortable('toArray').toString();
              // console.log(productOrder);
              $.ajax({
                type: "POST",
                dataType: "text",
                url: "sortable.php",
                data: {
                  data: productOrder,
                  table:'<?=$func_page?>',
                  // oldIndex: oldIndex + 1,
                  // newIndex: newIndex,
                  page: <?=($_GET['curr_page']!='')?$_GET['curr_page']:1?>
                },
                success: function (data) {
                  // console.log(data);
                  toastr.success('排序更新成功！');          
                }, beforeSend: function () {
                }, complete: function () {
                  window.location.reload();
                }
              })
            }
        });
    });
</script>