<div id="epl_event_type_0">
    <?php

    $m = 'Available in the Pro Version:
<ul>
<li>- Give your user the option to select a different <span class="epl_font_red">time</span> for different days.</li>
<li>- Give your user the option to select a different <span class="epl_font_red">price</span> for different days.</li>
<li>- Ability to have <span class="epl_font_red">time specific pricing</span>.</li>
</ul>

';
    echo epl_show_ad( $m );
    ?>


    <div class="epl_box epl_highlight">
        <div class="epl_box_content">
            <?php

            echo epl_get_the_label( '_epl_free_event', $price_option_fields );
            echo epl_get_the_field( '_epl_free_event', $price_option_fields );
            ?>
        </div>

    </div>

    <div class="epl_box epl_highlight">
        <div class="epl_box_content">
            <?php

            echo epl_get_the_label( '_epl_price_per', $price_option_fields );
            echo epl_get_the_field( '_epl_price_per', $price_option_fields );
            ?>
        </div>

    </div>


    <?php if ( !empty( $epl_pricing_type ) ): ?>

                <div class="epl_box epl_highlight">
                    <div class="epl_box_content">
                        <span class="epl_highlight">
                <?php epl_e( 'Please note that once you make this selection and save the event, you will NOT be able to change this.' ); ?>
            </span>

            <?php echo current( $epl_pricing_type ); ?>
            </div>

        </div>
    <?php endif; ?>


    <div id="epl_time_price_section" class="">

        <?php echo $time_price_section; ?>


        </div>

</div>
