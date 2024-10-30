<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-08-27
 * Time: 11:52
 */

namespace Edlin\ContentChecklist\App;


class Author
{
    /** @var int $wp_user_id */
    private $wp_user_id;

    /**
     * Author constructor.
     *
     * @param $wp_user_id
     */
    public function __construct($wp_user_id)
    {
        $this->wp_user_id = $wp_user_id;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return \get_the_author_meta('display_name', $this->wp_user_id);
    }

    /**
     * @return string
     */
    public function getPermalink(): string
    {
        return get_author_posts_url($this->wp_user_id);
    }
}