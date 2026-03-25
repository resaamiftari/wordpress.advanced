<?php

function ds_theme_assets() {

 
    wp_enqueue_style(
        'ds-style',
        get_stylesheet_uri(),
        array(),
        '1.0',
        'all'
    );

  
    wp_enqueue_style(
        'slider-style',
        get_template_directory_uri() . '/css/slider.css',
        array(),
        '1.0',
        'all'
    );

   
    wp_enqueue_script(
        'ds-script',
        get_template_directory_uri() . '/js/custom.js',
        array('jquery'),
        '1.0',
        true
    );

 
    if ( is_singular() && comments_open() && get_option('thread_comments') ) {
        wp_enqueue_script('comment-reply');
    }
}


add_action('wp_enqueue_scripts', 'ds_theme_assets');


function ds_setup() {

    add_theme_support('menus');

   
    register_nav_menu('primary', 'Primary Menu');

}

add_action('init', 'ds_setup');

function ds_theme_setup() {
    add_theme_support('post-thumbnails');

    add_theme_support('post-formats', array('aside', 'image', 'video'));

    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'ds_theme_setup');



function ds_add_bootstrap_cdn() {

    
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css',
        array(),
        '4.6.2',
        'all'
    );

    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '4.6.2',
        true
    );
}

add_action('wp_enqueue_scripts', 'ds_add_bootstrap_cdn');


function themename_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Primary Sidebar', 'theme_name' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

}
add_action( 'widgets_init', 'themename_widgets_init' );



class Foo_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'foo_widget',
            'A Foo Widget'
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<p>Hello World</p>';
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        echo '<p>No options yet</p>';
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}

function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );





function my_limit_posts_on_index($query) {
    if ( !is_admin() && $query->is_main_query() && is_home() ) {
        $query->set('posts_per_page', 5);
    }
}
add_action('pre_get_posts', 'my_limit_posts_on_index');





function our_custom_movie() {
    $labels = array(
        'name'               => _x( 'Movies', 'post type general name' ),
        'singular_name'      => _x( 'Movie', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'movie' ),
        'add_new_item'       => __( 'Add New Movie' ),
        'edit_item'          => __( 'Edit Movie' ),
        'new_item'           => __( 'New Movie' ),
        'all_items'          => __( 'All Movies' ),
        'view_item'          => __( 'View Movie' ),
        'search_items'       => __( 'Search Movies' ),
        'not_found'          => __( 'No movies found' ),
        'not_found_in_trash' => __( 'No movies found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Movies'
    );

    $args = array(
        'labels'             => $labels,
        'description'        => 'Movies and single movie details',
        'public'             => true,
        'publicly_queryable' => true,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'movies' ),
        'show_in_rest'       => true
    );

    register_post_type( 'movies', $args );
}

add_action( 'init', 'our_custom_movie' );

function register_taxonomy_movie_genres(){
    $labels = array (
        'name'               => _x('Movie genres', 'taxonomy general name'),
        'singular_name'      => _x( 'Movie', 'taxonomy singular name' ),
        'search_items'       => __('Search Movie genre'),
        'all_items'          => __('all Movie genre'),
        'parent_item'        => __('Parent Movie genre'),
        'parent_item_colon'  => __('Parent Movie genre:'),
        'edit_item'          => __('Edit Movie genre'),
        'update_item'        =>__('Edit Movie genre'),
        'add_new_item'       =>__('Add New Movie genre'),
        'new_item_name'      =>__('New Movie genre Name'),
        'menu_name'          =>__('Movie genre')
    );

    $args = array(
        'hierarchical'       =>true,
        'labels'             =>$labels,
        'show_ui'            =>true,
        'show_admin_column'  =>true,
        'query_var'          =>true,
        'show_in_rest'       =>true,
        'rewrite'            =>array('slug'=>'movie_genre')
    );

    register_taxonomy('movie_genres',array('movies'),$args);

    register_taxonomy('movietags','movies',array(
        'label'             => 'Movie tags',
        'rewrite'           =>array('slug' =>'movie_tags'),
        'hierarchical'      =>false,
        'show_ui'           =>true,
        'show_admin_column' =>true,
        'show_in_rest'      =>true
    ));

}
add_action('init','register_taxonomy_movie_genres');


function ds_seed_fast_and_furious_movie() {
    $existing_movie = get_page_by_title( 'Fast and Furious', OBJECT, 'movies' );

    if ( ! $existing_movie ) {
        $movie_id = wp_insert_post(
            array(
                'post_title'   => 'Fast and Furious',
                'post_content' => 'Street racing, heists, and a crew that turns into family.',
                'post_status'  => 'publish',
                'post_type'    => 'movies'
            )
        );
    } else {
        $movie_id = $existing_movie->ID;
    }

    if ( is_wp_error( $movie_id ) || ! $movie_id ) {
        return;
    }

    $action_term = term_exists( 'action', 'movie_genres' );
    if ( ! $action_term ) {
        $action_term = wp_insert_term( 'Action', 'movie_genres', array( 'slug' => 'action' ) );
    }

    if ( ! is_wp_error( $action_term ) ) {
        $term_id = is_array( $action_term ) ? $action_term['term_id'] : $action_term;
        wp_set_object_terms( $movie_id, array( (int) $term_id ), 'movie_genres', false );
    }
}
add_action( 'init', 'ds_seed_fast_and_furious_movie', 30 );




?>