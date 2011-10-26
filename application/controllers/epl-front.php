<?php

/**
 * This controller handles all the calls from the front of the website, uses multiple models
 *
 * @package		Events Planner for Wordpress
 * @author		Abel Sekepyan
 * @link		http://wpeventsplanner.com
 */
if ( !class_exists( 'EPL_front' ) ) {

    class EPL_front extends EPL_Controller {


        function __construct() {
            global $_on_admin, $current_step;
            $_on_admin = false;

            parent::__construct();


            epl_log( 'init', get_class() . " initialized" );
            $this->rm = $this->epl->load_model( 'epl-registration-model' );
            $this->ecm = $this->epl->load_model( 'epl-common-model' );

            if ( isset( $_REQUEST['epl_action'] ) ) {
                $this->run();
            }
            //add_filter( 'the_title', array( &$this, '__return_empty_string' ) );
        }


        function __return_empty_string( $string ) {

            return $string;
        }


        function run() {

            global $epl_fields, $epl_next_step, $epl_current_step;

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
                'complete',
                '_exp_checkout_payment_success',
                '_exp_checkout_payment_cancel',
                '_exp_checkout_do_payment',
                'thank_you_page',
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


                /*
                 * get the event list
                 * in the loop, a global var $event_list is set for the the template tags
                 */
                add_action( 'the_post', array( &$this, 'set_event_list' ) );

                return $this->the_event_list();
            }
        }


        function set_event_list( $param ) {
            $this->epl_util->set_the_event_details();
        }


        function the_event_list() {

            global $event_list;
            $this->ecm->events_list();

            $data['event_list'] = $event_list;

            return $this->epl->load_view( 'front/event-list', $data, true );
        }

        /*
         * add, delete, calc total ON CART
         */


        function process_cart_action() {

            $r = $this->rm->_process_session_cart();

            if ( !$GLOBALS['epl_ajax'] ) {
                $this->show_cart();
                return;
            }
            echo $this->epl_util->epl_response( array( 'html' => $r ) );
            die();
        }


        function widget_cal_next_prev() {
            $r = $this->epl_util->get_widget_cal();
            echo $this->epl_util->epl_response( array( 'html' => $r ) );
            die();
        }


        function event_details() {

            echo "here";
        }


        function show_cart() {

            $this->rm->set_mode( 'edit' );
            $data['cart_data'] = $this->rm->show_cart();

            $data['content'] = $this->epl->load_view( 'front/cart/cart', $data, true );
            $data['next_step'] = 'regis_form';
            $data['next_step_label'] = 'Next: Attendee Information';
            $data['mode'] = 'edit';
            $this->epl->load_view( 'front/cart-container', $data );
        }


        function regis_form() {

            $this->rm->set_mode( 'edit' );
            $data['mode'] = 'edit';
            $data['content'] = $this->rm->regis_form();


            $data['next_step'] = 'show_cart_overview';

            $this->epl->load_view( 'front/cart-container', $data );
        }


        function show_cart_overview( $next_step = null ) {
            //global $mode;

            //in case they come back from thank you page.
            if ( $this->rm->epl_is_empty_cart() ) {

                echo $this->epl_util->epl_invoke_error( 20, null, false );
            }
            else {
                $this->rm->set_mode( 'overview' );

                $data['cart_data'] = $this->rm->show_cart();

                $data['content'] = $this->epl->load_view( 'front/cart/cart', $data, false );


                $data['content'] .= $this->rm->regis_form();
                $data['next_step'] = $next_step;

                if ( is_null( $data['next_step'] ) )
                    $data['next_step'] = 'payment_page';

                if ( epl_is_free_event ( ) ) {

                    $data['next_step'] = 'thank_you_page';
                    $data['next_step_label'] = 'Confirm and Complete';
                }


                $data['mode'] = 'overview';
                $this->epl->load_view( 'front/cart-container', $data );
            }
        }


        function payment_page() {

            /* $this->rm->set_mode( 'overview' );
              $data['cart_data'] = $this->rm->show_cart();

              $data['content'] = $this->epl->load_view( 'front/cart/cart', $data, true );

              $data['mode'] = 'overview';
              $this->epl->load_view( 'front/cart-container', $data );
             */

            /*
             * find out what kind of payment from _epl_selected_payment
             * then redirect to correct page
             * --if free, complete, send email, show overview
             * --if ppexp, redirect
             * --if cc, show the billing form
             * --if check or invoice, complete and show overview
             *
             */


            if ( epl_is_free_event ( ) ) {

                echo "HERE FOR FREE EVENT";
            }

            //$egp = $this->epl->load_model( 'epl-gateway-model' );
            //$egp->_express_checkout_redirect();
        }


        function thank_you_page() {
            $this->rm->set_mode( 'thank_you_page' );
            /*
             * display payment info
             * display overview
             * send email
             * destry session
             */
            $_SESSION['__epl'] = array( );
            session_regenerate_id();
            echo "Thank you very much";
        }


        function _exp_checkout_payment_success() {

            $egp = $this->epl->load_model( 'epl-gateway-model' );

            if ( $egp->_exp_checkout_payment_success() )
                $this->show_cart_overview( '_exp_checkout_do_payment' );
        }


        function _exp_checkout_do_payment() {


            $egp = $this->epl->load_model( 'epl-gateway-model' );


            $egp->_exp_checkout_do_payment();

            if ( $egp->_exp_checkout_do_payment() ) {
                $_SESSION['__epl'] = array( );
                unset( $_SESSION['__epl'] );
                session_regenerate_id();

                echo "Payment Successfull.  Thank you very much.";
            }
        }


        function validate_data() {
            $v = $_SESSION['events_planner']['POST_EVENT_VARS'];

            foreach ( ( array ) $v['epl_start_date'] as $event_id => $event_dates ) {

            }
        }

    }

}