<script type='text/javascript'>
$(function(){
    $('.itemcode').blur(function(e){
       var index = $('.itemcode').index(this);
       var value = $(this).val();
       $.post('<?=base_url()?>post/check_code',{ itemcode:value },function(dhagz){
           var dhags = $.parseJSON(dhagz);
           if( Object.keys(dhags).length > 0 ){
               if( dhags['itemcode'] ){
                    $("#itemcode"+index).css('color','#000');
                    $("#price" + index).val(dhags['price']);
                    $.post('<?=base_url()?>post/get_img',{itemcode:value},function(hello){
                        $("#img"+index).attr('src',"<?=base_url()?>/public/images/contents/" + hello);
                    });
               }
           }else{
               $("#itemcode"+index).css('color','#F00');
           }
       });
    });
    
    var autocompleteval = [<?php echo $string_all; ?>];
    $( "#client" ).autocomplete({
        source:autocompleteval
    });
    
});
</script>
<style type="text/css">
    .itemcode, .ids{ text-transform: uppercase; vertical-align: top; }
    #error{color: #F00;}
</style>
<span id="error"><?=validation_errors().$errors?></span>
<form action="" method="post">
    <table>
        <tr>
            <td colspan="3" >Action: <?php echo sel_action("action", $action, set_value('action'),'class="input-medium"'); ?>
            &nbsp;&nbsp;&nbsp;Client: <input type="text" name="consign" value="<?=set_value('consign')?>" id='client' />
            <input type='text' name='date' value='<?php echo set_value('date'); ?>' id='date' size='10' class="input-small" readonly /></td> 
        </tr>
        <tr>
            <td colspan="3" class="input-append">No. of Item? <input type="text" name="nos" value="<?=$nos?>" size="5" class="input-mini" /> <input type='submit' name='nosgo' value='Go' class="btn" /> </td>
        </tr>
    </table>
        <?php
        if( $nos > 0 ){?>
    <table><tr><td>Code</td><td>Price</td><td>Image</td></tr>
      <?php 
            for ($index = 0; $index < $nos; $index++) { ?>
            <tr class="ids">
                <td><input type="text" name="itemcode[]" value="<?=set_value('itemcode[]')?>" class="itemcode input-medium" id="itemcode<?=$index?>" /></td>
                <td class="input-prepend"><span class="add-on">&#8369;</span><input type="text" name="price[]" value="<?=set_value('price[]')?>" class='price input-small' id="price<?=$index?>" /></td>
                <td><img src='' alt='photo' class="image img-polaroid" id="img<?=$index?>" width="100px" height="120px" /></td>
            </tr>
      <?php } ?>
        <tr><td colspan="3"><input type="submit" name="submit" value="Done" id="submit" class="btn btn-primary" /> &nbsp;&nbsp; <input type="reset" value="Clear" class="btn" /></td></tr>
    </table>
 <?php } ?>
</form>