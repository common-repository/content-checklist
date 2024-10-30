<?php

namespace Edlin\ContentChecklist\App;

use \Edlin\ContentChecklist\App\Helpers\Html;

/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-08-27
 * Time: 11:06
 */
class Post
{
    /**
     * WordPress Variables
     *
     * @var \WP_Post $wp_post
     */
    private $wp_post = null;

    /**
     * Theme Variables
     *
     * @var Category $category
     * @var Author   $author
     */
    private $category = null;
    private $author   = null;

    /**
     * @param array $args
     *
     * @return Post[]
     *
     * @deprecated
     */
    public static function where($args = []): array
    {
        $query    = new \WP_Query($args);
        $wp_posts = $query->get_posts();

        $posts = [];
        foreach ($wp_posts as $wp_post) {
            $posts[] = new Post($wp_post);
        }

        return $posts;
    }

    /**
     * Post constructor.
     *
     * @param \WP_Post $wp_post
     */
    public function __construct(\WP_Post $wp_post)
    {
        $this->wp_post = $wp_post;
    }

    /**
     * @return Author|null
     */
    public function getAuthor()
    {
        if ($this->author instanceof Author) {
            return $this->author;
        }

        $this->author = new Author($this->wp_post->post_author);

        return $this->author;
    }

    /**
     * @return bool
     */
    public function hasCategory(): bool
    {
        if ($this->getCategory() instanceof Category) {
            return true;
        }

        return false;
    }

    /**
     * @return Category|null
     */
    public function getCategory()
    {
        if ($this->category instanceof Category) {
            return $this->category;
        }

        $wp_term = vr_get_post_category($this->getId());
        if ($wp_term instanceof \WP_Term) {
            $this->category = new Category($wp_term);

            return $this->category;
        }

        return null;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->wp_post->ID;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->wp_post->post_title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->wp_post->post_name;
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->wp_post->post_excerpt;
    }

    /**
     * @return string
     */
    public function getPermalink(): string
    {
        return \get_permalink($this->getId());
    }

    /**
     * @return string
     */
    public function getPermalinkWithoutDomain(): string
    {
        return str_replace(home_url(), '', \get_permalink($this->getId()));
    }

    /**
     * @return string
     */
    public function getAlt(): string
    {
        return get_post_meta(get_post_thumbnail_id($this->wp_post), '_wp_attachment_image_alt', true);
    }

    /**
     * @param string $size
     *
     * @return string
     */
    public function getImage($size = 'blog_post'): string
    {
        return get_the_post_thumbnail_url($this->wp_post->ID, $size);
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getDate($format = 'jS F Y'): string
    {
        $timestamp = strtotime($this->wp_post->post_date);

        if ($timestamp) {
            return date($format, $timestamp);
        }

        return "";
    }

    /**
     * @return int
     */
    public function getImageCount(): int
    {
        return (int)substr_count($this->wp_post->post_content, '<img');
    }

    /**
     * @return int
     */
    public function getImageRequired(): int
    {
        return $this->getWordCount() / 300;
    }

    /**
     * @return string
     */
    public function getImageCountStyle(): string
    {
        $count = $this->getImageCount();

        if ($count > $this->getImageRequired()) {
            return 'color: #7ad03a !important';
        } elseif ($count > $this->getImageRequired() / 2) {
            return 'color: #ee7c1b !important';
        }

        return 'color: #dc3232 !important';
    }

    /**
     * @return string
     */
    public function getHeadingsStructure(): string
    {
        return "";
//        return Html::extractHeading($this->wp_post->post_content);
    }

    /**
     * @return int
     */
    public function getHeadingsCount(): int
    {
        $h1 = (int)substr_count($this->wp_post->post_content, '<h1>');
        $h2 = (int)substr_count($this->wp_post->post_content, '<h2>');
        $h3 = (int)substr_count($this->wp_post->post_content, '<h3>');
        $h4 = (int)substr_count($this->wp_post->post_content, '<h4>');
        $h5 = (int)substr_count($this->wp_post->post_content, '<h5>');
        $h6 = (int)substr_count($this->wp_post->post_content, '<h6>');

        return $h1 + $h2 + $h3 + $h4 + $h5 + $h6;
    }

    /**
     * @return string
     */
    public function getHeadingsCountStyle(): string
    {
        $count = $this->getHeadingsCount();

        if ($count > 1000) {
            return 'color: #7ad03a !important';
        } elseif ($count > 800) {
            return 'color: #ee7c1b !important';
        }

        return 'color: #dc3232 !important';
    }

    /**
     * @return int
     */
    public function getWordCount(): int
    {
        $content    = get_post_field('post_content', $this->getId());
        $word_count = str_word_count(strip_tags($content));

        return $word_count;
    }

    /**
     * @return string
     */
    public function getWordCountClass(): string
    {
        $count = $this->getWordCount();

        if ($count > 1000) {
            return 'good';
        } elseif ($count > 800) {
            return 'ok';
        }

        return 'bad';
    }

    /**
     * @return string
     */
    public function getWordCountStyle(): string
    {
        $count = $this->getWordCount();

        if ($count > Settings::getWordLimitGreen()) {
            return 'color: #7ad03a !important';
        } elseif ($count > Settings::getWordLimitOrange()) {
            return 'color: #ee7c1b !important';
        }

        return 'color: #dc3232 !important';
    }

    /**
     * @return int
     */
    public function getExcerptCount(): int
    {
        return (int)str_word_count(strip_tags($this->getExcerpt()));
    }

    /**
     * @return string
     */
    public function getExcerptCountClass(): string
    {
        $count = $this->getExcerptCount();

        if ($count > 40) {
            return 'good';
        } elseif ($count > 20) {
            return 'ok';
        }

        return 'bad';
    }

    /**
     * @return string
     */
    public function getExceptCountStyle(): string
    {
        $count = $this->getExcerptCount();

        if ($count > 40) {
            return 'color: #7ad03a !important';
        } elseif ($count > 20) {
            return 'color: #ee7c1b !important';
        }

        return 'color: #dc3232 !important';
    }

    /**
     * @return string
     */
    public function getSessions()
    {
        try {
            $analytics = Analytics\Auth::init();
            if ($analytics instanceof \Google_Service_AnalyticsReporting) {
                $pages = Analytics\LandingPage\Sessions::get($analytics);
                if (isset($pages[$this->getPermalinkWithoutDomain()])) {
                    return $pages[$this->getPermalinkWithoutDomain()];
                }

            }
        } catch (\Google_Exception $e) {
            return "--";
        }

        return "-";
    }

    /**
     * @return string
     */
    public function getBounceRate()
    {
        try {
            $analytics = Analytics\Auth::init();
            if ($analytics instanceof \Google_Service_AnalyticsReporting) {
                $pages = Analytics\LandingPage\BounceRate::get($analytics);
                if (isset($pages[$this->getPermalinkWithoutDomain()])) {
                    return $pages[$this->getPermalinkWithoutDomain()];
                }

            }
        } catch (\Google_Exception $e) {
            return "--";
        }

        return "-";
    }

    /**
     * @return string
     */
    public function getTimeOnPage()
    {
        try {
            $analytics = Analytics\Auth::init();
            if ($analytics instanceof \Google_Service_AnalyticsReporting) {
                $pages = Analytics\LandingPage\TimeOnPage::get($analytics);
                if (isset($pages[$this->getPermalinkWithoutDomain()])) {
                    return $pages[$this->getPermalinkWithoutDomain()];
                }

            }
        } catch (\Google_Exception $e) {
            return "--";
        }

        return "-";
    }
}