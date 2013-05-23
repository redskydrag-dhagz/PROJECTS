<style type="text/css">
    .itemtbl tr td{
        vertical-align: top;
    }
    #error{
        color: #F00;
    }
    #searchitemcode{
        text-transform: uppercase;
    }
</style>

<script type="text/javascript">
$(function(){
    function clrscreen(){
        $("#itemcodehid").val('');
        $("#itemcode").val('');
        $("#description").text('');
        $("#package").val('');
        $("#price").val('');
    }
    var itemcodehid = $("#searchitemcode").val();
    get_data(itemcodehid);
    function get_data(itemcodehid){
        if( $.trim(itemcodehid).length > 0 ){
            $.post('<?=base_url()?>post/search',{itemcode : itemcodehid}, function(e){
                var items = $.parseJSON(e);
                if( Object.keys(items).length > 0 ){
                    $("#itemcodehid").val(items['itemcode']);
                    $("#itemcode").val(items['itemcode']);
                    $("#description").text(items['description']);
                    $("#package").val(items['package']);
                    $("#price").val(items['price']);
                    $(".data").attr('disabled',false);
                    $("#searchitemcode").popover('hide');
                }else{
                    $("#searchitemcode").popover('show');
                    clrscreen();
                    $(".data").attr('disabled',true);
                }
            });
        }
    }
    
    
    $(".data").attr('disabled',true);
    $("#search").click(function(e){
        var itemcodehid = $("#searchitemcode").val();
        get_data(itemcodehid);
        
    });
    
    $("#delbutton").click(function(e){
        var itimcode = $("#itemcodehid").val();
        var ans = confirm("Are you sure in deleting " + itimcode + "?");
        if( ans ){
            $.post('<?=base_url()?>post/deleted',{itemcode:itimcode},function(echo){
                if( echo === "Deleted"){
                    clrscreen();
                }
                alert(echo);
            });
        }
    });
    
    $("#submit").click(function(e){
        var itimcode = $("#itemcodehid").val();
        var ans = confirm('You want to update '+ itimcode + '? ');
        return ans;
    });
    
    $("#clrscr").click(function(e){
        clrscreen();
        $(".data").attr('disabled', true);
    });
})
</script>

<span id="error">
    <?php echo validation_errors().$success;?>
</span>
<table>
    <tr><td class="input-append" >Search: &nbsp;<input type="text" id="searchitemcode" value="<?=$itemcode?>" class="input-small" data-title="Message" data-content="No data found!" data-placement="bottom" data-trigger="manual" /><input type="button" id="search" value="Edit" class="btn" /></td></tr>
</table>
<br />
<form action="<?=base_url()?>item/updateitem" method="post" >
    <table class="itemtbl">
        <tr><td>Item Code:</td><td><input type="text" name="itemcode" value="<?=set_value('itemcode')?>" id="itemcode" class="data input-small" /></td></tr>
        <tr><td>Description:</td><td><textarea name="description" id="description" class="data"><?=set_value('description')?></textarea></td></tr>
        <tr><td>Package:</td><td><input type="text" name="package" value="<?=set_value('package')?>" id="package" class="data" /></td></tr>
        <tr><td>Price:</td><td class="input-prepend"><span class="add-on">&#8369;</span><input type="text" name="price" value="<?=set_value('price')?>" id="price" class="data input-small" /></td></tr>
        <tr><td colspan="2">
        <input type="hidden" name="itemcodehid" value="<?=set_value('itemcodehid')?>" id="itemcodehid" /><input type="submit" name="submit" value="Update" class="data btn btn-success" id="submit" />
        <input type='button' id='delbutton' value='Delete' class="data btn btn-danger" />&nbsp;<input type="reset" name="clr" value="Clear" id="clrscr" class="btn btn-info" /></td></tr>
    </table>
</form>