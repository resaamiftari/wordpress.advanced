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
        get_template_directory_uri().'/css/slider.css',
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

function ds_setup(){
    //kem me leju me pas meny
    add_theme_support('menus');

    //register primary menu
    register_nav_menu('primary',"Primary menu");
    
}

add_action('init','ds_setup');

function ds_theme_set(){
    add_theme_support('post-thumbnails');

    add_theme_support('post-formats',array('aside','image','video'));

    add_theme_support('title-tag');
}

add_action('after_setup_theme','ds_theme_set');






function themename_widgets_init(){
    register_sidebar(
        array(
            'name'            =>__('Primary Sidebar','theme_name'),
            'id'              =>  'sidebar-1',
            'before_widget'   => '<aside id="%1$s" class="widget %2$s"> </aside>' 
            'after_widget'    => '</aside>',
            'before_tittle'   => '<h2 class="widget-tittle">',
            'after_tittle'    => '</h2>'
            
        );
    )
}

add_action('widgets_init','themename_widgets_init');

class Foo_Widget extends WP_Widget{
    public function __construct(){
        parent::__construct(
            'foo_widget',
            'A Foo Widget'
        );

    }
    public function widget($args,$instance){
        echo $args['before_widget'];
        echo '<p> Hello World </p>';
        echo $args ['after_widget'];
    }
    public function form($instance){
        echo '<p> No options yet </p>';
        
    }
    public function update($new_instance,$old_instance){
        return $new_instance;
    }
}

function register_foo_widget(){
    register_widget('Foo_Widget');
}

add_action('widgets_init','register_foo_widget');


?>







