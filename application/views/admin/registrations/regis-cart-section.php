<div class="epl_cart_wrapper">
    <input name="event_id" type ="hidden" value ="<?php echo $event_id; ?>" />
    <?php

    /*
     * This loop grabs each one of the forms and displays.
     */
    if ( is_array( $cart_data['cart_items'] ) ):
        foreach ( $cart_data['cart_items'] as $event ):
    ?>
            <div class="epl_cart_section">

                <div class="event_name"><?php echo $event['title']; ?></div>
                <div class="epl_event_section">


                    <p class="message"></p>
                    <div class="content">
                <?php //echo $ev['event_dates']['field']; ?>
<?php echo $event['event_dates']; ?>
            </div>

        </div>
        <div class="epl_event_section">


            <div class="content">
<?php echo $event['event_time_and_prices']; ?>
            </div>


        </div>


    </div>



    <?php endforeach;
            endif; ?>

</div>
