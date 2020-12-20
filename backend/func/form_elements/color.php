<!-- MiniColors -->
<script src="js/jquery.minicolors.js"></script>
<link rel="stylesheet" href="js/jquery.minicolors.css">
<script>
        $(document).ready( function() {

            $('.demo').each( function() {
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
                    change: function(hex, opacity) {
                        var log;
                        try {
                            log = hex ? hex : 'transparent';
                            if( opacity ) log += ', ' + opacity;
                            console.log(log);
                        } catch(e) {}
                    },
                    theme: 'default'
                });

            });
        });
    </script>
<?php
if($vv['value']==''){
	$vv['value'] ='#0088cc';
}
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
<div>
<input type="text"" id="' . $vv['name'] . '" name="' . $vv['name'] . '" data-position="bottom left" class="form-control demo" size="6" value="' . $vv['value'] . '" />
</div>
</div>
</div>
';
?>
