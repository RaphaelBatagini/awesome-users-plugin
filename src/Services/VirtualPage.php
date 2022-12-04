<?php

// -*- coding: utf-8 -*-

declare(strict_types=1);

namespace RaphaelBatagini\AwesomeUsersPlugin\Services;

use stdClass;

class VirtualPage
{
    private string $pageSlug;
    private string $pageTitle;
    private string $pageTemplate;

    /**
     * @param string $slug the virtual page slug
     * @param string $title the virtual page title
     * @param string $templatePath the file path to virtual page template
     *
     * @return self
     */
    public function __construct(string $slug, string $title, string $templatePath)
    {
        $this->pageSlug = $slug;
        $this->pageTitle = $title;
        $this->pageTemplate = $templatePath;
    }

    /**
     * Add init action
     *
     * @return void
     */
    public function init(): void
    {
        add_action('init', [$this, 'registerFilters']);
    }

    /**
     * Register WP Filters
     *
     * @return void
     */
    public function registerFilters(): void
    {
        add_filter('the_posts', [$this, 'createPage'], 10, 2);
    }

    /**
     * Create virtual page on the fly if current url matches the page slug
     *
     * @param \WP_Post[] $wpPosts
     * @param \WP_Query $wpQuery
     *
     * @return \WP_Post[]
     */
    public function createPage(array $wpPosts, \WP_Query $wpQuery): array
    {
        if (
            $this->getCurrentPageSlug() !== $this->pageSlug
            || !empty($wpQuery->query['post_type'])
        ) {
            return $wpPosts;
        }

        $wpPost = $this->createWpPostObject();
        array_push($wpPosts, $wpPost);

        wp_cache_add($wpPost->ID, $wpPost, 'posts');
        
        $this->insertWpPostInWpQuery($wpPost, $wpPosts, $wpQuery);

        return $wpPosts;
    }

    /**
     * Retrieve current page slug
     *
     * @return string current page slug
     */
    private function getCurrentPageSlug(): string
    {
        $requestUri = $this->getCurrentRequestUri();

        if (get_option('permalink_structure')) {
            return trim(parse_url($requestUri, PHP_URL_PATH), '/');
        }

        parse_str(parse_url($requestUri, PHP_URL_QUERY), $params);
        return isset($params['page_id']) ? $params['page_id'] : false;
    }

    /**
     * Retrieve current URI
     *
     * @return string current URI escaped and unslashed
     */
    private function getCurrentRequestUri(): string
    {
        if (empty($_SERVER['REQUEST_URI'])) {
            return '';
        }

        return esc_url_raw(stripslashes($_SERVER['REQUEST_URI']));
    }

    /**
     * Add post to WP_Query
     *
     * @param \WP_Post $wpPost
     * @param \WP_Post[] $wpPosts
     * @param \WP_Query $query
     *
     * @return void
     */
    private function insertWpPostInWpQuery(\WP_Post $wpPost, array $wpPosts, \WP_Query $wpQuery): void
    {
        $wpQuery->post = $wpPost;
        $wpQuery->posts = $wpPosts;
        $wpQuery->queried_object = $wpPost;
        $wpQuery->queried_object_id = $wpPost->ID;
        $wpQuery->found_posts = 1;
        $wpQuery->post_count = 1;
        $wpQuery->max_num_pages = 1;
        $wpQuery->is_page = true;
        $wpQuery->is_singular = true;
        $wpQuery->is_single = false;
        $wpQuery->is_attachment = false;
        $wpQuery->is_archive = false;
        $wpQuery->is_category = false;
        $wpQuery->is_tag = false;
        $wpQuery->is_tax = false;
        $wpQuery->is_author = false;
        $wpQuery->is_date = false;
        $wpQuery->is_year = false;
        $wpQuery->is_month = false;
        $wpQuery->is_day = false;
        $wpQuery->is_time = false;
        $wpQuery->is_search = false;
        $wpQuery->is_feed = false;
        $wpQuery->is_comment_feed = false;
        $wpQuery->is_trackback = false;
        $wpQuery->is_home = false;
        $wpQuery->is_embed = false;
        $wpQuery->is_404 = false;
        $wpQuery->is_paged = false;
        $wpQuery->is_admin = false;
        $wpQuery->is_preview = false;
        $wpQuery->is_robots = false;
        $wpQuery->is_posts_page = false;
        $wpQuery->is_post_type_archive = false;
    }

    /**
     * Generate the wp post object dynamically
     *
     * @return \WP_Post
     */
    private function createWpPostObject(): \WP_Post
    {
        $post = new \stdClass();
        $post->ID = 0;
        $post->post_author = 1;
        $post->post_date = current_time('mysql');
        $post->post_date_gmt = current_time('mysql', 1);
        $post->post_content = $this->templateToString();
        $post->post_title = $this->pageTitle;
        $post->post_excerpt = '';
        $post->post_status = 'publish';
        $post->comment_status = 'closed';
        $post->ping_status = 'closed';
        $post->post_password = '';
        $post->post_name = $this->pageSlug;
        $post->to_ping = '';
        $post->pinged = '';
        $post->modified = $post->post_date;
        $post->modified_gmt = $post->post_date_gmt;
        $post->post_content_filtered = '';
        $post->post_parent = 0;
        $post->guid = get_home_url(null, '/' . $this->pageSlug);
        $post->menu_order = 0;
        $post->post_type = 'page';
        $post->post_mime_type = '';
        $post->comment_count = 0;
        $post->filter = 'raw';

        return new \WP_Post($post);
    }

    /**
     * Get template content as string
     *
     * @return string template content
     */
    private function templateToString(): string
    {
        ob_start();
        include($this->pageTemplate);
        $templateRendered = ob_get_contents();
        ob_end_clean();
        return $templateRendered;
    }
}
