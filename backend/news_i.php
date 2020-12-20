<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary"><?=$func_title?></h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">首頁</a></li>
            <li class="breadcrumb-item">公告系統</li>
            <li class="breadcrumb-item active"><?=$func_title?></li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="col-xs-12">
                <a class="btn btn-pink" href="javascript:history.back()" ><i class="fa fa-reply"></i></a>
                <a href="javascript:window.location.reload();" class="btn btn-pink pull-right">
                    <i class="fa fa-refresh"></i>
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-validation">
                        <?php
                            FuncSite::makeForm($arr_form1);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<!-- footer -->
<footer class="footer">
    <?php
    echo __FOOTER_COPYRIGHT;
    ?>
</footer>
<!-- End footer -->