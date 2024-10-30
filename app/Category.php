<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-08-27
 * Time: 11:23
 */

namespace Edlin\ContentChecklist\App;


class Category
{
    /** @var \WP_Term $wp_term */
    private $wp_term;

    /**
     * @param array $args
     *
     * @return Category[]
     */
    public static function where($args = []): array
    {
        /** @var \WP_Term[] $wp_terms */
        $wp_terms = get_categories($args);

        $categories = [];
        foreach ($wp_terms as $wp_term) {
            $categories[] = new Category($wp_term);
        }

        return $categories;
    }

    /**
     * Category constructor.
     *
     * @param \WP_Term $wp_term
     */
    public function __construct(\WP_Term $wp_term)
    {
        $this->wp_term = $wp_term;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->wp_term->term_id;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->wp_term->slug;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->wp_term->name;
    }

    /**
     * @return string
     */
    public function getPermalink(): string
    {
        return \get_category_link($this->getId());
    }
}