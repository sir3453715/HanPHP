<?
echo '
<div class="form-group">
<label>'.($vv['title']).'</label>';
?>
<input type="hidden" name="showImg" id="showImg"/><?=$vv['file_name'];?><br />
<input name="Submit" type="button" class="font02" onClick="window.open('fupload1.php?useForm=form1&amp;prevImg=showImg&amp;upUrl=./webimages&amp;ImgS=&amp;ImgW=&amp;ImgH=&amp;reItem=rePic&amp;reName=rfile','fileUpload','width=400,height=180')" value="<?	if($vv['files']!=null){echo "重新上傳";}else{echo "準備上傳";}?>" />
<input name="rePic" type="hidden" id="rePic" value="<?=$vv['files']; ?>" size="20" />
<input name="rfile" type="hidden" id="rfile" value="<?=$vv['file_name']; ?>" size="20" />
<?
	if($vv['delete']){
		echo '<label>
	                    <input type="checkbox" value="true" name="del_'.$vv['name'].'">
	                    delete ?
	                  </label>';
	}
?>