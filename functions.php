<?php

function ds_theme_assets(){
 //Main css

    wp_enqueue_style(
        'ds-style',
        get_stylesheet_uri(),
        array(),
        '1.0',
        'all'
    );

 //Main css

    wp_enqueue_style(
        'slider-style',
        get_template_directory_uri().'/css/slider.css'
        array(),
        '1.0',
        'all'
    );

 //js

    wp_enqueue_style(
        'ds-script',
        get_template_directory_uri().'/js/custom.js',
        array('jquery'),
        '1.0',
        true
    );

    if(is_singular()&& comments_opne()&& get_option('threadz_comments')){
        wp_enqueue_scripts('comment-replay');
    }
}

add_action('wp_enqueue_scripts','ds_theme_assets');

?>