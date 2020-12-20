<!-- <link href="js/kartik-v-bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="js/kartik-v-bootstrap-fileinput/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="js/kartik-v-bootstrap-fileinput/fileinput.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/themes/explorer/theme.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/locales/zh-TW.js" type="text/javascript"></script> -->

<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="js/kartik-v-bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/> -->
<link href="js/kartik-v-bootstrap-fileinput/themes/explorer-fa/theme.css" media="all" rel="stylesheet" type="text/css"/>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
<script src="js/kartik-v-bootstrap-fileinput/js/plugins/sortable.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/js/locales/fr.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/js/locales/es.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/themes/explorer-fa/theme.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/themes/fa/theme.js" type="text/javascript"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" type="text/javascript"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script> -->
<?php
?>
<!-- <script>
    $(document).ready(function () {
        $("#<?=$vv['name']?>").fileinput({
            language: "zh-TW",
            showCancel: false,
            showRemove: false,
            showUpload: false,
            showCaption: false,
            dropZoneEnabled: false,
            // 'theme': 'explorer',
            allowedFileExtensions: ["jpg", "png", "gif","jpeg"],
            maxFileCount: '<?=$vv['maxFileCount']?>',
            maxImageWidth: '<?=$vv['maxImageWidth']?>',
            maxImageHeight: '<?=$vv['maxImageHeight']?>',
        });
    });
</script>

<input id="input-b5" name="input-b5[]" type="file" multiple> -->
<script>
$(document).on('ready', function() {
    $("#<?=$vv['name']?>").fileinput({
        showCaption: false,
        dropZoneEnabled: false,
        maxFileCount: 1,
        allowedFileExtensions: ["jpg", "png", "gif","jpeg"],
    });
});
</script>


<?php

echo '
<div class="form-group">
<label class="control-label col-sm-2">' . ($vv['title']) . '</label>
<div class="col-sm-10">

<input id="' . $vv['name'] . '" name="' . $vv['name'] . '" type="file" onchange="readURL(this);" multiple accept="image/*">
';
if ($vv['value'] != '')
{
    // $size = @filesize(__SERVER_IMAGES_FOLDER.'/'.$vv['value']);
    $data = getimagesize(__SERVER_IMAGES_FOLDER . '/' . $vv['value']);
    // print_r($data);
    // exit;
    //print_r($size);
    //exit;
    if ($size > 300000)
    {
        $q = 0.5;
    }
    else
    {
        $q = 1;
    }
    $q = 1;
    /* echo '
      <img src="'.__SERVER_WEB_IMAGEG_PATH.'/'.$vv['value'].'" class="img-thumbnail">';
     */
    /*
      if($vv['w']!=''){
      $andPara .= '&w='.$vv['w'];
      }
      if($vv['h']!=''){
      $andPara .= '&h='.$vv['h'];
      }
     */
    if ($data[0] / 200 > 1)
    {
        $andPara .= '&w=' . ($data[0] / (ceil($data[0] / 200)));
        $andPara .= '&h=' . ($data[1] / (ceil($data[0] / 200)));
        $tmp = 'width=' . ($data[0] / (ceil($data[0] / 200)));
    }
    else
    {
        $andPara .= '&w=' . $data[0];
        $andPara .= '&h=' . $data[1];
        $tmp = 'width=' . $data[0];
    }
    //echo '<label><a href="'.__SERVER_WEB_IMAGEG_PATH.'/'.$vv['value'].'" target="_blank" class="btn btn-warning">view</a></label><br />';
    //echo '<img src="/webimages/timthumb.php?src='.__SERVER_WEB_IMAGEG_PATH.'/'.$vv['value'].'&q='.$q.'&size='.$size.$andPara.'&zc=0" class="img-thumbnail" /><br />';
    // echo '<img src="/backend/webimages/timthumb.php?src='.__WEB_IMAGES_FOLDER.'/'.$vv['value'].'&size='.$size.$andPara.'&zc=0" class="img-thumbnail" /><br />';

    echo '<img id="' . $vv['name'] . '_img" src="' . __WEB_IMAGES_FOLDER . '/' . $vv['value'] . '" ' . $tmp . ' class="img-thumbnail" />';
    if ($vv['delete'])
    {
        echo '<label>&nbsp;&nbsp;<input type="checkbox" value="true" name="del_' . $vv['name'] . '">&nbsp;<i class="fa fa-trash"></i></label>';
    }
}
else
{
    echo '<img id="' . $vv['name'] . '_img" src="#" class="img-thumbnail" style="display: none;">';
}
echo '
<p class="help-block">' . $vv['help'] . '</p>
<p class="text-warning" id="' . $vv['name'] . '_warning"></p>
</div>
</div>
';
?>
