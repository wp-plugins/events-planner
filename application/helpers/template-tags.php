<?php



function get_the_event_title( $post_ID = null ) {


    return EPL_util::get_instance()->get_the_event_title( $post_ID );
}

function get_the_event_dates( ) {


    return EPL_util::get_instance()->get_the_event_dates( );
}
function get_the_event_dates_cal(  ) {


    return EPL_util::get_instance()->get_the_event_dates_cal(  );
}


function get_the_event_times( $post_ID = null ) {

    return EPL_util::get_instance()->get_the_event_times( $post_ID );
}

function get_the_event_prices( $post_ID = null ) {

    return EPL_util::get_instance()->get_the_event_prices( $post_ID );
}


function get_the_add_button() {

    return EPL_util::get_instance()->get_the_add_button( );
}


function the_event_meta( $post_ID ) {

    return EPL_util::get_instance()->the_event_meta( $post_ID );
}


function epl_get_the_field($field,  $fields) {

    return $fields[$field]['field'];


}
function epl_get_the_label($field,  $fields) {

    return $fields[$field]['label'];


}
function epl_get_the_desc($field,  $fields) {

    return $fields[$field]['description'];


}
?>
