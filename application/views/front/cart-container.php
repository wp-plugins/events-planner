<div id="epl_main_container" class="<?php echo $mode;?>">
    <div id="epl_ajax_content">
        <!-- -->
        <form autocomplete="off" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="events_planner_shopping_cart">
            
            <?php echo $content; ?>

            <input type="hidden" name="epl_action" value="<?php echo $next_step; ?>" >
            <input type="submit" name="submit" value="<?php echo (isset($next_step_label))?$next_step_label:epl_e('Next'); ?>" >
        </form>

    </div>
</div>
