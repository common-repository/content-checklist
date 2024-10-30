<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-08-27
 * Time: 13:15
 */

namespace Edlin\ContentChecklist\App;


class Query
{
    /**
     * @var \WP_Query $wp_query
     */
    private $wp_query = null;

    /**
     * @var Post[] $posts
     */
    private $posts = [];

    /**
     * @param array $args
     *
     * @return Query
     */
    public static function where($args = []): Query
    {
        return new Query(new \WP_Query($args));
    }

    /**
     * Query constructor.
     *
     * @param \WP_Query $wp_query
     */
    public function __construct(\WP_Query $wp_query)
    {
        $this->wp_query = $wp_query;
    }

    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        $wp_posts = $this->wp_query->get_posts();

        $posts = [];
        foreach ($wp_posts as $wp_post) {
            $posts[] = new Post($wp_post);
        }

        return $posts;
    }

    /**
     * @return int
     */
    public function getPreviousPage()
    {
        if ($this->getCurrentPage() <= 1) {
            return 1;
        }

        return $this->getCurrentPage() - 1;
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        if ($this->getCurrentPage() < $this->getMaxNumPages()) {
            return $this->getCurrentPage() + 1;
        }

        return $this->getMaxNumPages();
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return (int)\get_query_var('page', 1);
    }

    /**
     * @return int
     */
    public function getMaxNumPages()
    {
        return (int)$this->wp_query->max_num_pages;
    }
}