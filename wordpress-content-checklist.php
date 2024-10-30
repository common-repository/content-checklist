<?php
/**
 * Plugin Name: Content Checklist
 * Plugin URI: http://www.codewithross.com/wordpress-content-checklist
 * Description: Creates a table which will give you a checklist of items for each article
 * Version: 0.1.3
 * Author: Ross Edlin
 * Author URI: http://www.codewithross.com
 */

require_once(__DIR__ . '/app/Post.php');
require_once(__DIR__ . '/app/Settings.php');

/**
 *
 */
function wpcc_init()
{
    wp_register_style('wpcc', plugins_url('style.css', __FILE__), [], md5(__DIR__ . '/style.css'));
    wp_enqueue_style('wpcc');
}

add_action('admin_init', 'wpcc_init');

/**
 *
 */
function wpcc_add_settings_page()
{
    add_options_page(
        'Content Checklist',
        'Content Checklist',
        'manage_options',
        'wpcc',
        'wpcc_settings_page'
    );
}

/**
 *
 */
function wpcc_settings_page()
{
    include(__DIR__ . '/view/settings.php');
}

add_action('admin_menu', 'wpcc_add_settings_page');

/**
 * Register Setting Options
 */
function wpcc_register_settings()
{
    register_setting('wpcc', 'wpcc_word_limit_green');
    register_setting('wpcc', 'wpcc_word_limit_orange');
}

add_action('admin_init', 'wpcc_register_settings');

/**
 * @param $defaults
 *
 * @return mixed
 */
function content_checklist_columns_head($defaults)
{
//    $defaults['wpcc-headings-count']         = 'Headings';
    $defaults['wpcc-word-count']   = 'Words';
    $defaults['wpcc-except-count'] = 'Ex';
    $defaults['wpcc-image-count']  = 'Img';

    return $defaults;
}

/**
 * @param $column_name
 * @param $post_ID
 */
function content_checklist_columns_content($column_name, $post_ID)
{
    $post = new \Edlin\ContentChecklist\App\Post(get_post($post_ID));

    /**
     * Headings
     */
//    if ($column_name == 'cc_headings_count') {
//        echo sprintf('<span style="%s">%s</span>', $post->getHeadingsCountStyle(), $post->getHeadingsStructure());
//    }

    /**
     * Word Count
     */
    if ($column_name == 'wpcc-word-count') {
        echo sprintf(
            '<span style="%s">%s</span>',
            $post->getWordCountStyle(),
            $post->getWordCount()
        );
    }

    /**
     * Excerpt Count
     */
    if ($column_name == 'wpcc-except-count') {
        echo sprintf('<span style="%s">%s</span>', $post->getExceptCountStyle(), $post->getExcerptCount());
    }

    /**
     * Image Count
     */
    if ($column_name == 'wpcc-image-count') {
        echo sprintf(
            '<span style="%s">%s</span>',
            $post->getExceptCountStyle(),
            $post->getImageCount()
        );
    }
}

add_filter('manage_posts_columns', 'content_checklist_columns_head');
//add_filter('manage_pages_columns', 'content_checklist_columns_head');
add_action('manage_posts_custom_column', 'content_checklist_columns_content', 10, 2);
//add_action('manage_pages_custom_column', 'content_checklist_columns_content', 10, 2);
