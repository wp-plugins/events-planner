<div id="stylized" class="myform">

    <?php if ( isset( $ticket_number ) ): ?>

        <h1><?php echo epl__( 'Ticket #' ) . $ticket_number; ?>: <?php echo $price_name; ?></h1>

    <?php endif; ?>
    <?php if ( isset( $form_label ) ): ?>

            <h1><?php echo $form_label; ?></h1>

    <?php endif; ?>

    <?php if ( isset( $form_descr ) ): ?>

                <p><?php echo $form_descr; ?></p>

    <?php endif; ?>

   <fieldset class="epl_fieldset">

        <?php echo $fields; ?>


    </fieldset>
</div>