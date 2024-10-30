<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-10-14
 * Time: 11:19
 */

namespace Edlin\ContentChecklist\App;


class Filter
{
    private $url  = '';
    private $name = '';

    /**
     * Filter constructor.
     *
     * @param $url
     * @param $name
     */
    public function __construct(string $url, string $name)
    {
        $this->url  = $url;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isCurrent(): bool
    {
        if ('/wp-admin/' . $this->getUrl() == Helpers\Site::getCurrentUrl()) {
            return true;
        }

        return false;
    }
}