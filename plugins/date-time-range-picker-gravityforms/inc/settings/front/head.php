<?php if ( ! defined( 'ABSPATH' ) ) {exit;}
wp_enqueue_script( 'moment' );
wp_enqueue_style('daterangepicker-style', plugins_url( 'assets/css/daterangepicker.css' , DTRPG_FILE ));
wp_enqueue_script( 'daterangepicker-script', plugins_url( 'assets/js/daterangepicker.min.js' , DTRPG_FILE ),array(),false, true);
$inline_dtp_style = "
.daterangepicker * {
    direction: ltr !important;
}
.daterangepicker table th, table td, .table th, .table td {
    padding:0 !important;
}
#{$field_id}{
    text-align: left;
    direction: ltr;
}
";
wp_add_inline_style( 'daterangepicker-style', $inline_dtp_style );