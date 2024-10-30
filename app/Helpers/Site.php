<?php

namespace Edlin\ContentChecklist\App\Helpers;

/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-10-14
 * Time: 11:43
 */

class Site
{
    /**
     * @return string
     */
    public static function getCurrentUrl(): string
    {
        return (string)$_SERVER['REQUEST_URI'];
    }
}