<?php

namespace LitePress\WP_China_Yes\Inc\Controller\Web;

use const LitePress\WP_China_Yes\LPSTORE_BASE_URL;

final class Account_Controller {

    public function index() {
        $r    = wp_remote_get( LPSTORE_BASE_URL . 'account' );
        if ( is_wp_error( $r ) ) {
            echo $r->get_error_message();
            exit;
        }

        $body = json_decode( $r['body'] );

        $apps   = $body->data;

        require_once WCY_ROOT_PATH . 'template/account.php';
    }

}
