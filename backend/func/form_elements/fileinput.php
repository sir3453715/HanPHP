<link href="js/kartik-v-bootstrap-fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="js/kartik-v-bootstrap-fileinput/themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="js/kartik-v-bootstrap-fileinput/plugins/sortable.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/fileinput.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/themes/explorer/theme.js" type="text/javascript"></script>
<script src="js/kartik-v-bootstrap-fileinput/locales/zh-TW.js" type="text/javascript"></script>
<?php
    foreach ($vv['value'] as $value) {
        $initialPreview1 .=  "'";
        // $initialPreview1 .= '<img src="' . __WEB_IMAGES_FOLDER . '/' . $value['img'] . '" class="file-preview-image kv-preview-data">';
        
        $initialPreview1 .=  'http://'.$_SERVER['HTTP_HOST'].'/webimages/' . $value['img'];
        // $initialPreview1 .=  __SERVER_IMAGES_FOLDER .DIRECTORY_SEPARATOR. $value['img'];
        $initialPreview1 .=  "',";
    }
?>
<script>
    $(document).ready(function () {
        $("#<?=$vv['name']?>").fileinput({
            uploadUrl: "../webimages/",
            uploadAsync: false,
            language: "zh-TW",
            showCancel: false,
            showRemove: false,
            showUpload: false,
            autoReplace: false,
            showCaption: true,
            initialPreviewFileType: 'image',
            overwriteInitial: false,
            // 'theme': 'explorer',
            allowedFileExtensions: ["jpg", "png", "gif"],
            maxFileCount: '<?=$vv['maxFileCount']?>',
            maxImageWidth: '<?=$vv['maxImageWidth']?>',
            maxImageHeight: '<?=$vv['maxImageHeight']?>',
            initialPreview: [
                <?=$initialPreview1?>
            ],
            initialPreviewShowDelete: true,
            initialPreviewAsData: true
        });
        /*
         $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
         alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
         });
         */
    });
</script>
<?php

echo '
<div class="form-group">
<label class="control-label col-sm-2">' . ($vv['title']) . '</label>
<div class="col-sm-10">
<input id="'. ($vv['name']) .'" name="'. ($vv['name']) .'[]" type="file"  multiple=true class="file-loading" accept="image/*">
<p class="help-block">' . $vv['help'] . '</p>
</div>
</div>
';
?>
