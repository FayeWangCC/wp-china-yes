<?php

namespace LitePress\WP_China_Yes\Inc;

use const LitePress\WP_China_Yes\VERSION;

add_action( 'admin_enqueue_scripts', function ( $page ) {
    if ( 'toplevel_page_lpstore' !== $page ) {
        return;
    }

    add_thickbox();

    wp_enqueue_style( 'lpstore', WCY_ROOT_URL . 'assets/lpstore.css', array(), VERSION );
    wp_enqueue_script( 'lpstore', WCY_ROOT_URL . 'assets/lpstore.js', array(), VERSION );
} );
