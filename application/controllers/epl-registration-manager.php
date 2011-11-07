<?php

class EPL_Registration_Manager extends EPL_Controller {
    const post_type = 'epl_registration';


    function __construct() {

        parent::__construct();
        global $_on_admin;
        $_on_admin = true;

        epl_log( 'init', get_class() . " initialized" );



        if ( isset( $_REQUEST['epl_ajax'] ) && $_REQUEST['epl_ajax'] == 1 ) {

            $this->run();
        }
        else {
            $this->ecm = $this->epl->load_model( 'epl-common-model' );
            add_action( 'default_title', array( &$this, 'pre' ) );
            add_action( 'add_meta_boxes', array( &$this, 'epl_add_meta_boxes' ) );
            add_action( 'save_post', array( &$this, 'save_postdata' ) );
            //post list manage screen columns - extra columns
            add_filter( 'manage_edit-' . self::post_type . '_columns', array( &$this, 'add_new_columns' ) );
            //post list manage screen - column data
            add_action( 'manage_' . self::post_type . '_posts_custom_column', array( &$this, 'column_data' ), 10, 2 );
        }
        //$this->m = $this->load_model( 'admin/epl-manage-events-model' );
    }


    function pre( $title ) {

        $title = strtoupper( $this->epl_util->make_unique_id( epl_nz( epl_get_regis_setting( 'epl_regis_id_length' ), 10 ) ) );

        return $title;
    }


    function save_postdata( $post_ID ) {
        return;
        if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) || empty( $_POST ) )
            return;


        /*
         * if initial save
         * --set up __epl
         * if isset event id
         * --add the event id to __epl
         */
        $this->get_values();

        $this->rm->__in( $this->event_meta + $this->regis_meta )
                ->__update_from_post( 'dates' )
                ->__update_from_post( 'regis-info' );

        if ( $this->event_id != '' )
            $this->rm->__update_from_post( 'events' );


        if ( !$this->edit_mode ) {

            $this->rm->__update_from_post( 'initial-save' );
        }
        $this->rm->__out();
    }


    function run() {
        $this->get_values();
        /*
         * can
         * -add event to cart
         * -delete event from cart
         * -add attendee
         * -edit everything
         * -delete attendee
         * -set regis status (cancel...)
         * -
         */
        //epl_log( "debug", "<pre>" . print_r( $_SESSION, true ) . "</pre>" );


        $defined_actions = array(
            'show_event_list',
            'process_cart_action',
            'delete_item_from_cart',
            'show_cart',
            'regis_form',
            'show_cart_overview',
            'add_regis_info',
            'overview',
            'payment_page',
            'epl_regis_snapshot',
            'attendee_list',
            'process_payment',
            'send_email',
            'event_details',
            'widget_cal_next_prev'
        );

        if ( isset( $_REQUEST['epl_action'] ) ) {

            //POST has higher priority
            $epl_action = esc_attr( $_POST['epl_action'] ? $_POST['epl_action'] : $_GET['epl_action'] );
            if ( in_array( $epl_action, $defined_actions ) ) {
                if ( method_exists( $this, $epl_action ) ) {

                    $epl_current_step = $epl_action;

                    $r = $this->$epl_action();
                }
            }
        }
        else {
            
        }

        echo $this->epl_util->epl_response( array( 'html' => $r ) );
        die();
    }


    function epl_regis_snapshot() {

        return "Snapshot here";
    }


    function regis_meta_box( $post, $values ) {

        /*
         * if new,
         * -show the event list and an add button
         *
         */

         //echo "<pre class='prettyprint'>" . print_r($this->event_meta + $this->regis_meta, true). "</pre>";
        $data['event_id'] = $this->event_id;

        //events, dates, times, prices, quantities
        $data['cart_data'] = $this->rm->__in( $this->event_meta + $this->regis_meta )->show_cart();
        $data['cart_data'] = $this->epl->load_view( 'admin/registrations/regis-cart-section', $data, true );

        $data['cart_totals'] =
                        $this->rm
                        ->__in( $this->event_meta + $this->regis_meta )
                        ->calculate_totals();

        //totals
        $data['cart_totals'] = $this->epl->load_view( 'admin/registrations/regis-totals-section', $data, true );

        //registration form
        $data['attendee_info'] = $this->rm->__in( $this->event_meta + $this->regis_meta )->regis_form();


        if ( !$this->edit_mode ) {
            $data['message'] = epl__( "This feature will be coming soon." );
        }

        $this->epl->load_view( 'admin/registrations/registration-attendee-meta-box', $data );
    }


    function process_cart_action() {

        /*
         * -add new item to cart
         * --save
         * -calculate totals
         * --save
         * -get regis form
         * --save
         * --add to db
         * --return cart
         */


        /*
         * if add
         * -- send regis id, post id to model
         * --- model adds to db
         * -- get the cart
         * --- model return the cart
         * -- make selections and get totals
         * --- model adds to db and gets totals
         * -- get the regis form
         * --- save the regis details to db
         */


        $cart_actions = array(
            'add_event' => 'add_event',
            'delete_event' => 'delete_event',
            'calc_total' => 'calc_total',
            'regis_form' => 'regis_form',
            'add_attendee' => 'add_attendee',
            'del_attendee' => 'del_attendee',
        );

        if ( isset( $_REQUEST['cart_action'] ) ) {

            //POST has higher priority
            $cart_action = esc_attr( $_POST['cart_action'] ? $_POST['cart_action'] : $_GET['cart_action'] );
            if ( in_array( $cart_action, $cart_actions ) ) {
                if ( method_exists( $this, $cart_action ) ) {

                    $epl_current_step = $cart_action;

                    $r = $this->$cart_action();
                }
            }
        }
        else {
            //Hmm
        }

        return $r;



        echo $this->epl_util->epl_response( array( 'html' => $r ) );
        die();

        //$meta = array();
//        $data['content'] .= $rm->regis_form( $v );
//        $data['content'] = $this->epl->load_view( 'admin/registrations/regis-cart-section', $data, true );

        echo $this->epl_util->epl_response( array( 'html' => $data['content'] ) );
        die();



        if ( !$GLOBALS['epl_ajax'] || $GLOBALS['_on_admin'] ) {
            $this->rm->show_cart();
            return;
        }
        echo $this->epl_util->epl_response( array( 'html' => $r ) );
        die();
    }

    /*
     * can be event, or product ;o)
     */


    function add_event() {
        $post_id = ( int ) $_POST['post_ID'];
        $regis_id = $_POST['post_title'];
        $event_id = ( int ) $_POST['event_list_id'];

//$this->regis_meta['__epl'][$regis_id]['events'][$event_id] = array();

        $data['event_id'] = $event_id;
        //$this->rm->_data = $meta;

        $data['cart_data'] = $this->rm->
                        __in( $this->event_meta + $this->regis_meta )
                        ->add_event( $event_id )
                        ->show_cart();

        //$this->rm->__out();
        //$data['cart_data'] = $this->rm->_process_cart( )->show_cart();



        return $this->epl->load_view( 'admin/registrations/regis-cart-section', $data, true );
    }


    function regis_form() {
        $post_id = ( int ) $_POST['post_ID'];
        $regis_id = $_POST['post_title'];
        $event_id = ( int ) $_POST['event_id'];


        $event_meta = $this->ecm->get_post_meta_all( $event_id );
        $regis_meta['__epl'] = get_post_meta( $post_id, '__epl', true );


        if ( empty( $meta['__epl'] ) ) {


            $regis_meta['__epl']['regis_id'] = $regis_id;
            $regis_meta['__epl']['post_id'] = $post_id;
            //$meta['__epl'][$regis_ID] = array( );
        }


        //$this->rm->_data = $meta;

        return $this->rm->__in( $event_meta + $regis_meta )->__update_from_post()->regis_form();
    }


    function calc_total() {

        /*
         * get the post, event meta
         */


        $data['cart_totals'] =
                        $this->rm
                        ->__in( $this->event_meta + $this->regis_meta )
                        ->__update_from_post( 'dates' )
                        ->calculate_totals();



        return $this->epl->load_view( 'admin/registrations/regis-totals-section', $data, true );
    }

    /*
     * This is fired only when necessary
     */


    function get_values() {
        global $epl_fields;
        $this->epl->load_config( 'regis-fields' );
        $this->ecm = $this->epl->load_model( 'epl-common-model' );
        $this->epl_fields = $epl_fields; //this is a multi-dimensional array of all the fields
        $this->ind_fields = $this->epl_util->combine_array_keys( $this->epl_fields ); //this is each individualt field array


        $this->data['values'] = $this->ecm->get_post_meta_all( ( int ) $post_ID );



        $this->rm = $this->epl->load_model( 'epl-regis-admin-model' );
        $this->ecm = $this->epl->load_model( 'epl-common-model' );


        $post_ID = '';
        if ( isset( $_GET['post'] ) )
            $post_ID = $_GET['post'];
        elseif ( isset( $_POST['post_ID'] ) )
            $post_ID = $_POST['post_ID'];
        $this->edit_mode = $post_ID != '';

        $this->regis_meta = ( array ) $this->ecm->get_post_meta_all( $post_ID );
        $this->data['values'] = $this->regis_meta;
        //$this->regis_meta['__epl'] = get_post_meta( $post_ID, '__epl', true );

        $this->post_ID = ( int ) $post_ID;

        if ( $_POST ) {
            $this->regis_id = $_POST['post_title'];
            $this->event_id = ( int ) $_POST['event_id'];
        }
        else {

            $this->regis_id = $this->regis_meta['__epl']['regis_id'];
            $this->event_id = key( ( array ) $this->regis_meta['__epl'][$this->regis_id]['events'] );
        }

        $this->event_meta = ( array ) $this->ecm->setup_event_details( $this->event_id );

        //if a brand new regis, set up minimum structure.
        if ( empty( $this->regis_meta['__epl'] ) ) {

            $this->regis_meta['__epl']['regis_id'] = $this->regis_id;
            $this->regis_meta['__epl']['post_id'] = $this->post_ID;
            $this->regis_meta['__epl'][$this->regis_id] = array( );

            //update_post_meta( $post_ID, '__epl', $this->regis_meta['__epl'] );
        }
    }


    function epl_add_meta_boxes() {
        $this->get_values();
        add_meta_box( 'epl-regis-meta-box', epl__( 'Registration Information' ), array( &$this, 'regis_meta_box' ), self::post_type, 'normal', 'core' );
        add_meta_box( 'epl-payment-meta-box', epl__( 'Payment Information' ), array( &$this, 'payment_meta_box' ), self::post_type, 'side', 'low' );
        // add_meta_box( 'epl-regis-action-meta-box', epl__( 'Available Actions' ), array( &$this, 'action_meta_box' ), self::post_type, 'side', 'low' );
    }


    function payment_meta_box() {

        $epl_fields_to_display = array_keys( $this->epl_fields['epl_regis_payment_fields'] );

        $_field_args = array(
            'section' => $this->epl_fields['epl_regis_payment_fields'],
            'fields_to_display' => $epl_fields_to_display,
            'meta' => array( '_view' => 3, '_type' => 'row', 'value' => $this->data['values'] )
        );

        $data['epl_regis_payment_fields'] = $this->epl_util->render_fields( $_field_args );


        $this->epl->load_view( 'admin/registrations/regis-payment-meta-box', $data );
    }


    function action_meta_box() {
        echo "Send email, cancel, ";
    }


    function add_new_columns( $current_columns ) {

        $new_columns['cb'] = '<input type="checkbox" />';

        //$new_columns['id'] = __( 'ID' );
        $new_columns['title'] = _x( 'Registration ID', 'column name' );
        $new_columns['event'] = epl__( 'Event' );
        $new_columns['attendees'] = epl__( 'Attendees' );
        $new_columns['payment_amount'] = epl__( 'Payment Amount' );
        //$new_columns['payment'] = epl__( 'Payment Status' );
        //$new_columns['images'] = __( 'Images' );
        //$new_columns['author'] = __( 'Author' );
        //$new_columns['categories'] = __( 'Categories' );
        //$new_columns['events_planner_categories'] = __( 'Categories' );
        //$new_columns['tags'] = __( 'Tags' );

        $new_columns['date'] = _x( 'Date', 'column name' );

        return $new_columns;
    }

    /*
     * Data for the modified cols
     */


    function column_data( $column_name, $id ) {


        $meta = $this->ecm->get_post_meta_all( $id );
        //echo "<pre class='prettyprint'>meta" . print_r($meta, true). "</pre>";
        $event_id = '';
        $event_name = '';
        $num_attendees = '';

        if ( isset( $meta['_epl_events'] ) && !empty( $meta['_epl_events'] ) ) {
            $event_id = key( $meta['_epl_events'] );
            $event_name = get_post( $event_id )->post_title;
            $num_attendees = $meta['_total_att_' . $event_id];

            //if ( $num_attendees > 0 )
            //    $num_attendees = '<span class="num_attendees">' . $num_attendees . '</span> <img id = "' . $id . '" class="epl_regis_snapshot" src="' . EPL_FULL_URL . 'images/application_view_list.png" />';
        }
        switch ( $column_name )
        {
            case 'id':
                echo $id;
                break;


            case 'event':

                echo $event_name;

                break;
            case 'attendees':


                echo $num_attendees;
                break;
            case 'payment_amount':


                echo epl_get_currency_symbol() . epl_get_formatted_curr( epl_nz($meta['_epl_payment_amount'], 0));
                break;
            case 'payment':

                echo "Payment Info";

                break;
            default:
                break;
        } // end switch
    }

}
