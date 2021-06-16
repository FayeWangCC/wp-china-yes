<?php

namespace LitePress\WP_China_Yes\Inc\Controller\Web;

use function LitePress\WP_China_Yes\Inc\get_template_part;
use const LitePress\WP_China_Yes\LPSTORE_BASE_URL;

final class Store_Controller {

    public function plugins() {
        $paged = absint( isset( $_GET['paged'] ) && $_GET['paged'] > 0 ? $_GET['paged'] : 1 );

        $category = '15';
        $category .= isset( $_GET['sub_cat'] ) ? $_GET['sub_cat'] : '';

        $args = array(
            'orderby'  => 'popularity',
            'page'     => $paged,
            'category' => $category,
        );

        if ( isset( $_GET['min_price'] ) ) {
            $args['min_price'] = $_GET['min_price'];
        }

        if ( isset( $_GET['max_price'] ) ) {
            $args['max_price'] = $_GET['max_price'];
        }

        $r = wp_remote_get( add_query_arg( $args, LPSTORE_BASE_URL . 'products' ) );
        if ( is_wp_error( $r ) ) {
            echo $r->get_error_message();
            exit;
        }

        $body = json_decode( $r['body'] );

        $projects   = $body->data;
        $cats       = $body->cats;
        $total      = $body->total;
        $totalpages = $body->totalpages;

        $all_local_active_projects = get_option( 'active_plugins' );
        $all_local_projects        = array();
        foreach ( get_plugins() as $key => $item ) {
            if ( in_array( $key, $all_local_active_projects ) ) {
                $item['Status'] = 'Activated';
            } else {
                $item['Status'] = 'Deactivated';
            }

            $item['Plugin'] = $key;

            $all_local_projects[ $item['TextDomain'] ] = $item;
        }

        $args = array(
            'projects'           => $body->data,
            'all_local_projects' => $all_local_projects,
            'cats'               => $body->cats,
            'total'              => $body->total,
            'totalpages'         => $body->totalpages,
            'paged'              => $paged,
        );

        get_template_part( 'plugins', '', $args );
    }

    public function themes() {
        $paged = absint( isset( $_GET['paged'] ) && $_GET['paged'] > 0 ? $_GET['paged'] : 1 );

        $category = '17';
        $category .= isset( $_GET['sub_cat'] ) ? $_GET['sub_cat'] : '';

        $args = array(
            'orderby'  => 'popularity',
            'page'     => $paged,
            'category' => $category,
            'type'     => 'theme',
        );
        $r    = wp_remote_get( add_query_arg( $args, LPSTORE_BASE_URL . 'products' ) );
        if ( is_wp_error( $r ) ) {
            echo $r->get_error_message();
            exit;
        }

        $body = json_decode( $r['body'] );

        $args = array(
            'projects'           => $body->data,
            // 'all_local_projects' => $all_local_projects,
            'cats'               => $body->cats,
            'total'              => $body->total,
            'totalpages'         => $body->totalpages,
            'paged'              => $paged,
        );

        get_template_part( 'themes', '', $args );
    }

}
