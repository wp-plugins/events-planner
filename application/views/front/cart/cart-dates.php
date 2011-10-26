<?php

foreach ($date as $k =>$field):
?>

<div style="">

    <?php echo $field['field'];?>

     <?php if (isset($time[$k])):?>

    <div style="padding:3px 10px;"> Time: <?php echo $time[$k]; ?></div>


    <?php endif; ?>
     <?php if (isset($price[$k])):?>

    <div style="padding:3px 10px;"> <?php echo $prices[$k]; ?></div>


    <?php endif; ?>
</div>


<?php
endforeach;

?>

