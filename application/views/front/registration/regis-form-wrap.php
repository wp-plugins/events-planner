<div id="stylized" class="regis_form">
    <!-- selected ticket name -->
    <?php if ( isset( $ticket_number ) ): ?>

        <h1><?php echo epl__( 'Attendee #' ) . $ticket_number; ?>: <?php echo $price_name; ?></h1>

    <?php endif; ?>

        <!-- form label -->
    <?php if ( isset( $form_label ) ): ?>

            <h1><?php echo $form_label; ?></h1>

    <?php endif; ?>
            <!-- form description -->
    <?php if ( isset( $form_descr ) ): ?>

                <p><?php echo $form_descr; ?></p>

    <?php endif; ?>
                <!-- registration form -->
                <fieldset class="epl_fieldset">

        <?php echo $fields; ?>


    </fieldset>
</div>