<?php
    ///////////////////////start content type////////////////////////////////////////

    function galleryCat() {
        // create a new taxonomy



        register_taxonomy(
        'gallery_categories',
        'mp3s',
        array(
        'label' => __('Gallery Categories'),
        'sort' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'args' => array('orderby' => 'term_order'),
        'rewrite' => array('slug' => 'galCat'),
        )
        );
    }

    add_action( 'init', 'galleryCat' );

    function create_my_post_types2() {


        register_post_type( 'gallery',
        array(
        'labels' => array(
        'name' => __( 'Galleries' ),
        'singular_name' => __( 'gallery' )
        ),
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions'),

        //'supports' => array( 'title'),
        'public' => true,
        //'taxonomies' => array( 'post_tag', 'category'),
        'taxonomies' => array( "gallery_categories"),

        )
        );









    }






?>
