<link href="js/kartik-v-bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="js/kartik-v-bootstrap-fileinput/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="js/kartik-v-bootstrap-fileinput/plugins/sortable.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/fileinput.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/themes/explorer/theme.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/locales/zh-TW.js" type="text/javascript"></script>
<?php
?>
<script>
    $(document).ready(function () {
        $("#<?=$vv['name']?>").fileinput({
            language: "zh-TW",
            showCancel: false,
            showRemove: false,
            showUpload: false,
            showCaption: false,
            // 'theme': 'explorer',
            allowedFileExtensions: ["jpg", "png", "gif","jpeg"],
            maxFileCount: '<?=$vv['maxFileCount']?>',
            maxImageWidth: '<?=$vv['maxImageWidth']?>',
            maxImageHeight: '<?=$vv['maxImageHeight']?>',
        });
    });
</script>
<?php

echo '
<div class="form-group">
<label class="control-label col-sm-2">' . ($vv['title']) . '</label>
<div class="col-sm-10">
<input id="' . $vv['name'] . '" name="' . $vv['name'] . '" type="file" onchange="readURL(this);" multiple class="file-loading" accept="image/*" data-show-preview="false">
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
