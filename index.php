<?php

/**
 * Plugin Name: Awesome Users Plugin
 * Plugin URI: https://github.com/RaphaelBatagini/awesome-users-plugin
 * Description: Users listing plugin.
 * Author: Raphael Batagini
 * Author URI: https://github.com/RaphaelBatagini
 * Version: 1.0.0
 * License: GPLv2 or later
 * Text Domain: awesome-users
 * Domain Path: /languages/
 */

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin;

defined('ABSPATH') || exit;

require_once(__DIR__ . '/vendor/autoload.php');

define('USERS_PAGE_URL', 'my-awesome-users');

add_action('after_setup_theme', static function () {
    $core = AwesomeUsers::instance();
    $core->init();
});

// add_action( 'template_redirect', function ( ) {
//     global $wp, $wp_query;

//     if ($wp->request === USERS_PAGE_URL) {
//         $wp_query->is_404 = false;
//         add_filter('the_title', function () { return 'Olá'; });
//         add_filter('the_content', function () { return 'Olá'; });
//         include(__DIR__ . '/templates/users-list.php');die;
//     }
// });

new My_Virtual_Page();
class My_Virtual_Page {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
    }

    /**
     * Hook to add the virtual page
     */
    public function init() {
       if ( get_option( 'permalink_structure' ) ) {
            $param = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
        } else {
            parse_str( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ), $params );
            $param = ( isset( $params['page_id'] ) ? $params['page_id'] : false );
        }

        if( $param === USERS_PAGE_URL ) {
            //Enqueue any page specific styles and scripts here
            add_filter( 'the_posts', array( $this, 'my_virtual_page' ), 10, 2 );
        }
    }

    /**
     * @param $posts
     * The virtual page filter
     *
     * @return array
     */
    function my_virtual_page( $posts, $query ) {
        global $wp, $wp_query;

        if (!empty($query->query['post_type'])) {
            return $posts;
        }

        //Just double checking. Can be ignored.
        if ( strcasecmp( $wp->request, USERS_PAGE_URL ) !== 0 ) {
            return $posts;
        }

        $content = '<p>HTML Page content here!</p>';
        // $content = '';

        $post = $this->my_virtual_post_object( USERS_PAGE_URL, __( 'Virtual page', 'awesome-users' ), $content );

        // set filter results
        $wp_post = new \WP_Post($post);
        $posts = array($wp_post);
        wp_cache_add( $wp_post->ID, $wp_post, 'posts' );

        // reset wp_query properties to simulate a found page
        $wp_query->post = $wp_post;
        $wp_query->posts = array( $wp_post );
        $wp_query->queried_object = $wp_post;
        $wp_query->queried_object_id = $wp_post->ID;
        $wp_query->found_posts = 1;
        $wp_query->post_count = 1;
        $wp_query->max_num_pages = 1; 
        $wp_query->is_page = true;
        $wp_query->is_singular = true; 
        $wp_query->is_single = false; 
        $wp_query->is_attachment = false;
        $wp_query->is_archive = false; 
        $wp_query->is_category = false;
        $wp_query->is_tag = false; 
        $wp_query->is_tax = false;
        $wp_query->is_author = false;
        $wp_query->is_date = false;
        $wp_query->is_year = false;
        $wp_query->is_month = false;
        $wp_query->is_day = false;
        $wp_query->is_time = false;
        $wp_query->is_search = false;
        $wp_query->is_feed = false;
        $wp_query->is_comment_feed = false;
        $wp_query->is_trackback = false;
        $wp_query->is_home = false;
        $wp_query->is_embed = false;
        $wp_query->is_404 = false; 
        $wp_query->is_paged = false;
        $wp_query->is_admin = false; 
        $wp_query->is_preview = false; 
        $wp_query->is_robots = false; 
        $wp_query->is_posts_page = false;
        $wp_query->is_post_type_archive = false;

        return $posts;
    }

    /**
     * @param $slug
     * @param $title
     * @param $content
     *
     * Generate the post object dynamically
     *
     * @return stdClass
     */
    function my_virtual_post_object( $slug, $title, $content ) {
        $post                        = new \stdClass;
        $post->ID                    = -1;
        $post->post_author           = 1;
        $post->post_date             = current_time( 'mysql' );
        $post->post_date_gmt         = current_time( 'mysql', 1 );
        $post->post_content          = $content;
        $post->post_title            = $title;
        $post->post_excerpt          = '';
        $post->post_status           = 'publish';
        $post->comment_status        = 'closed';
        $post->ping_status           = 'closed';
        $post->post_password         = '';
        $post->post_name             = $slug;
        $post->to_ping               = '';
        $post->pinged                = '';
        $post->modified              = $post->post_date;
        $post->modified_gmt          = $post->post_date_gmt;
        $post->post_content_filtered = '';
        $post->post_parent           = 0;
        $post->guid                  = get_home_url( 1, '/' . $slug );
        $post->menu_order            = 0;
        $post->post_type             = 'page';
        $post->post_mime_type        = '';
        $post->comment_count         = 0;
        $post->filter = 'raw';

        return $post;
    }
}