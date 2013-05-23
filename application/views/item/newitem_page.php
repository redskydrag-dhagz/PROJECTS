<style type="text/css">
    .itemtbl tr td{
        vertical-align: top;
    }
    #error{
        color: #F00;
    }
    #itemcode{text-transform: uppercase;}
</style>
<span id="error">
    <?php echo validation_errors();?>
</span>

<form action="" method="post" >
    <table class="itemtbl">
        <tr><td>Item Code:</td><td><input type="text" name="itemcode" class="input-medium" value="<?=set_value('itemcode')?>" id="itemcode" /></td></tr>
        <tr><td>Description:</td><td><textarea name="description"><?=set_value('description')?></textarea></td></tr>
        <tr><td>Package:</td><td><input type="text" name="package" value="<?=set_value('package')?>" /></td></tr>
        <tr><td>Price:</td><td class="input-prepend"><span class="add-on">&#8369;</span><input type="number" class="input-small" name="price" value="<?=set_value('price')?>" /></td></tr>
        <tr><td colspan="2" align="cente"><input type="submit" name="submit" value="Add" class="btn btn-primary btn-medium" />&nbsp;<input type="reset" name="clr" value="Clear" class="btn btn-primary btn-medium" /></td></tr>
    </table>
</form>