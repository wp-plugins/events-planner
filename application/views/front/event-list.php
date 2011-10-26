<div id="event_list_wrapper">


    <?php

    //echo "<pre class='prettyprint'>" . print_r( $event_list, true ) . "</pre>";
    if ( $event_list->have_posts() ):

        while ( $event_list->have_posts() ) :

            $event_list->the_post();

            /*
             * after $event_list->the_post(), a global var called $event_details is created with all the event
             * meta information (dates, times, ...).  The template tags below go off of that variable
             */
    ?>

            <div class="event_wrapper clearfix">


                <div class ="event_thumbnail">
            <?php

            if ( has_post_thumbnail ( ) ) {

                the_post_thumbnail( '150x150' );
            }
            else {

                echo '<img src="' . EPL_FULL_URL . '/images/default_event_list_image.png" />';
            } ?>

        </div>
        <?php //the_content(); ?>

            <div class="event_info_wrapper">

                <div class="event_title clearfix">

                <?php

                //If you don't want to use the_title, use
                //http://...../events/?event_id=637&epl_action=event_details
                //echo get_the_event_title();
                ?>

                <a href ="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>


            </div>


            <div class="event_description clearfix">

                <?php the_content(); ?>

            </div>

            <div class ="event_dates">
                <span class="">Dates</span>
                <?php echo get_the_event_dates( ); ?>

            </div>


            <div class ="event_times">
                <span class="">Times</span>
                <?php echo get_the_event_times( ); ?>
            </div>

        </div>
    </div>
    <?php

                endwhile;
            else:
    ?>
                <div> Sorry, there are no events currently available</div>
    <?php endif; ?>

</div>
