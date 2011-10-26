<div class="epl_cart_wrapper">
    <?php foreach ( ( array ) $cart_data['cart_items'] as $k => $event ): ?>
        <div class="epl_cart_section">


            <div class="event_name"><?php echo $event['title']; ?></div>

        <?php if ( isset( $cart_data['available_spaces'][$k] ) ): ?>

            <span>Available Spaces</span>

        <?php echo $cart_data['available_spaces'][$k]; ?>

        <?php endif; ?>


            <div class ="section_header">Event Dates</div>

            <div class="section">

            <?php echo $event['event_dates']; ?>

        </div>

        <!--<div class ="section_header">Event Times & Prices</div>-->

        <div class="section">
            <?php echo $event['event_time_and_prices']; ?>
        </div>


    </div>



    <?php endforeach; ?>
    <?php if ( !isset( $cart_data['free_event'] ) ): ?>

                <div id="epl_totals_wrapper">

                    <?php if (!$cart_data['view_mode'] != 'overview'): ?>
                    <a href="#" id="calculate_total_due">Calculate Total Due</a>
                    <?php endif; ?>

        <?php

                echo $cart_data['cart_totals'];
        ?>


            </div>
            <div id="epl_payment_choices_wrapper">


        <?php

                echo $cart_data['pay_options'];
        ?>


            </div>
    <?php endif; ?>

</div>




