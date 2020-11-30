<?php if ( ! defined( 'ABSPATH' ) ) {exit;}
    $render_script = '';
    ob_start();
        include("script.php"); 
    $render_script = str_replace(['<script>','</script>'],['',''],ob_get_clean());
    
    $before_render = 'jQuery(document).ready(function () {';
    $before_render .=  $render_script;
    $before_render .= "}); jQuery(document).bind('gform_post_render', function(){";
    $before_render .=  $render_script;
    $before_render .= "});";
    
    wp_add_inline_script('daterangepicker-script' , $before_render);
?>