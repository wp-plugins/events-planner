
   <?php echo epl_show_ad ('Two or more days (the user registers for all days) and Course registration in PRO version.'); ?>
<div class="epl_box epl_ov_a" style="">

    <div class="epl_box_content">

        <ul class="epl_event_type">
            <?php

            foreach ( $epl_event_type as $ev_k => $ev_v ){
                echo $ev_v;
            }
            ?>
            <?php echo $epl_event_duplicate_x['field']; ?>
        </ul>
    </div>
</div>