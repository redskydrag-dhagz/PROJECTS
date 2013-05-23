<style type="text/css">
    .right{
        text-align: right;
        font-size: 12px;
        font-weight: bolder;
    }
</style>
<script type="text/javascript">
$(function(){ 
    var autocompleteval = [<?php echo $string_all; ?>];
    $( "#client" ).autocomplete({
        source:autocompleteval
    });
});
</script>
<?=$message?>
<form action="" method="post">
    <table>
        <tr><td class="right">Item Code:</td><td><input type="hidden" name="itemcode" value="<?=strtoupper($stat_oper['itemcode'])?>" /><?=strtoupper($stat_oper['itemcode'])?></td></tr>
        <tr><td class="right">Status:</td><td><?=sel_action("action",$action,$stat_oper['state'],'class="input-medium"')?></td></tr>
        <tr><td class="right">Client:</td><td><input type="text" value="<?=set_value('client',$client)?>" name="client" id="client" /></td></tr>
        <tr><td class="right">Date:</td><td><input type="text" value="<?=$stat_oper['date']?>" name="date" id="date" size="10" class="input-small" readonly /></td></tr>
        <tr><td class="right">Price:</td><td class="input-prepend"><span class="add-on">&#8369;</span><input type="text" value="<?=$stat_oper['price']?>" name="price" class="input-small" /></td></tr>
        <tr><td colspan="2"><input type="submit" value="Update" name="submit" class="btn btn-primary" /></td></tr> 
    </table>
</form>