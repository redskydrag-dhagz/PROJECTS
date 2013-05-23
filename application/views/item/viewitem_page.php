<style type="text/css">
    table{font-size: 13px; }
    #message{
        background-color: #A7C942;
        color: #FFF;
        font-size: 16px;
        padding: 2px;
    }
    .textwrap{
        width: 250px;
    }
    .status{ width: 25px;}
    
</style>
<script type="text/javascript">
$(function(){
   $(".delete").click(function(e){
       var index = $(this).index(".delete");
       var code = document.getElementsByClassName("itemcode").item(index).innerHTML;
       var ui_message = confirm( "You want to delete all the data of " + code );
       if( ui_message ){
        $.post("<?=base_url()?>item/delete",{itemcode:code},function(e){
            var message = e ? "Deleted!" : "It is already deleted";
            alert(message);
            window.location = "<?=base_url().uri_string()?>";
        });
       }
       
       return ui_message;
   });
   $("#viewall").click(function(e){
   window.location = "<?=base_url()?>item/viewitem"; 
   });
});
</script>

<?php
    $uri = base_url()."item/updateitem/"; $title = '<i class="icon-pencil icon-white"></i> Edit'; $attributes = 'class="edit btn btn-info btn-mini" ';
    $uri1 = "#"; $title1 = "Delete"; $attributes1 = 'class="delete"';
?>
<table><?=form_open("item/viewitem")?>
    <tr><td>Search by: <select name="search" class="input-medium">
            <option value="itemcode">Item Code</option>
            <option value="description">Description</option>
            </select>
        </td><td class="input-append">
            <input type="text" name="searchvalue" value="<?=set_value('searchvalue')?>" class="span2" id="appendedInputButtons" />
            <input type="submit" name="submitsearch" value="Search" class="btn btn-medium" /><input type="button" id="viewall" value="View All" class="btn" />
        </td>
    </tr></form>
</table>
<br />
<?php if( count($datus) > 0 ){ ?>
<table class="table table-bordered table-hover">
    <tr><th>Image</th><th>Item Code</th><th>Description</th><th>Client</th><th>Status</th><th>Price</th><th>Date</th><th>Action</th></tr>
<?php foreach ($datus as $key => $value) { ?>
    <tr><td><img src="<?=base_url()?>public/images/contents/<?=$value['image']?>" alt="photo" width="100" height="80" class="img-polaroid" /></td>
        <td class="itemcode"><?=$value['itemcode']?></td>
        <td class="textwrap"><?=$value['description']?></td>
        <td><?=$stat_client[$key]['client']?></td>
        <td class="status"><?=$stat_client[$key]['status']?></td> 
        <td align="right">&#8369; <?=number_format($value['price'],2)?></td>
        <td><?=date("M j, Y", strtotime($value['date']))?></td>
        <td><?=anchor($uri.strtoupper($value['itemcode']), $title, $attributes)."&nbsp;&nbsp;"?><a href="#" class="delete btn btn-warning btn-mini"  ><i class="icon-trash icon-white"></i>Delete</a></td>
    </tr>
<?php } ?>
    <tr><td colspan="8"><?=$links?></td>
</table>
<?php }else{ ?>
<span id="message">No result found!</span>
<?php } ?>
