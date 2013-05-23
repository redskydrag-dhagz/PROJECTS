<style type="text/css">
</style>
<script type="text/javascript">
$(function(){
    
    function set_input(value){
       if( value === "client" ){
           $("#" + value).attr("disabled",false).css("display","inline");
           $("#date").attr("disabled",true).css("display","none");
           $("#date").val('');
       }else{
           $("#client").attr("disabled",true).css("display","none");
           $("#" + value).attr("disabled",false).css("display","inline");
           $("#client").val('');
       }
    }
    var value = $("#search").val(); 
    set_input(value);
   $(".delete").click(function(e){
       var code = $(this).attr("id");
       var answer_message = confirm('Are you want to delete this transaction?');
       if( answer_message ){
        $.post("<?=base_url()?>maneuver/delete",{itemcode:code},function(e){
            if( e ){
                alert("Deleted!")
                window.location = "<?=base_url().uri_string()?>";
            }else{
                alert("It is already deleted!");
            }
        });
       }
   });
   
   var autocompleteval = [<?php echo $string_all; ?>];
   $( "#client" ).autocomplete({
        source:autocompleteval
    });
   
   $("#search").change(function(e){
       var value = $(this).val();
       set_input(value);
   });
});
</script>
<?php
    $uri = base_url()."maneuver/update/"; $title = '<i class="icon-pencil icon-white"></i> Edit'; $attributes = 'class="edit btn btn-primary btn-mini"';
    $uri1 = "#"; $title1 = "Delete"; $attributes1 = 'class="delete"';
    $options = array("date" => "Date", "client" => "Client");
?>
<div>
<?=form_open("maneuver/edit")?>
    <table><tr>
    <td>Search By: <?=form_dropdown("search", $options, set_value('search'), 'id="search" class="input-small"')?></td>
        <td class="input-prepend"><input type="text" name="searchvalue" id="date" value="<?=set_value('searchvalue')?>" size='' readonly class="input-medium" /><input type="text" name="searchvalue" id="client" value="<?=set_value('searchvalue')?>" class="input-medium" />
<input type="submit" name='submit' value="Search" class="btn btn-primary" /></td></tr>
    </table>
</form>
</div>
<br />
<?php if( strlen($message) > 0 || count($datus) === 0 ){
    echo '<span id="message">'.(strlen($message) > 0 ? $message : "No Transactions Found!").'</span>';
}else{ ?>
<table class="table table-hover">
    <tr><th>Image</th><th>Item Code</th><th>Description</th><th>Client</th><th>Status</th><th>Price</th><th>Date</th><th>Action</th></tr>
<?php foreach ($datus as $key => $value) { ?>
    <tr><td><img src="<?=base_url()?>public/images/contents/<?=$value['image']?>" alt="photo" width="100" height="80" class="img-polaroid"/></td>
        <td class="itemcode"><?=$value['itemcode']?></td>
        <td width="250"><?=$value['description']?></td> 
        <td><?=$stat_client[$key]['client']?></td>
        <td width="50"><?=$stat_client[$key]['status']?></td> 
        <td>&#8369; <?=number_format($value['price'],2)?></td>
        <td><?=date('M j, Y',strtotime($value['date']))?></td>
        <td><?=anchor($uri.$value['operationid'], $title, $attributes)."&nbsp;&nbsp;"?><a href="#" class='delete btn btn-primary btn-mini btn-warning' id='<?=$value['operationid']?>' ><i class="icon-trash icon-white"></i>Delete</a></td>
    </tr>
<?php } ?>
    <tr><td colspan="8"><?=$links?></td>
</table>
<?php } ?>