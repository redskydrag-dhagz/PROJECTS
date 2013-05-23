<style type="text/css">
    #itemcode{ text-transform: uppercase;}
    #message{color:#F00;}
</style>

<span id="message"><?=validation_errors().$message?></span>
<?=form_open_multipart("images/insert")?>
<table>
    <tr><td>Item Code:</td><td><input type="text" name="itemcode" value="<?=set_value('itemcode')?>" id="itemcode" /> </td></tr>
    <tr><td valign="top">Image:</td><td><div class="fileupload fileupload-new" data-provides="fileupload">
<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" /></div>
<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
<div>
<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="image" /></span>
<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
</div>
</div></td></tr>
    <tr><td><input type="submit" name="submit" value="submit" class="btn" /></td></tr>
</table> 
</form>

