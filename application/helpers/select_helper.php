<?php

function sel_action($select_name,$data,$orig_val = '', $param = ''){
    ?>
<select name="<?php echo $select_name; ?>" <?=$param?> ><option value="">Action</option><?php
    foreach ($data as $value) {
    ?>
    <option value="<?=$value['actionid']?>" <?php echo $orig_val === $value['actionid'] ? 'selected = "selected"' : ''; ?> ><?=$value['description']?></option>
    <?php
    }
    ?>
</select>
<?php
}

function sel_consign($select_name ,$data , $orig_val = '', $param =''){
    ?>
<select name="<?php echo $select_name; ?>" <?=$param?> ><option value="">Consign</option><?php
    foreach ($data as $value) {
    ?>
    <option value="<?=$value['consignid']?>" <?php echo $orig_val === $value['consignid'] ? 'selected = "selected"' : ''; ?> ><?=$value['description']?></option>
    <?php
    }
    ?>
</select>
<?php
}