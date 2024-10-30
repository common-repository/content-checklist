<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-10-14
 * Time: 11:52
 */

namespace Edlin\ContentChecklist\App\Helpers;

/**
 * Class Request
 * @package Edlin\ContentChecklist\App\Helpers
 */
class Request
{
    /**
     * @return array
     */
    public static function getAll()
    {
        return filter_input_array(INPUT_GET);
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public static function get($key, $default = null)
    {
        $safeGet = self::getAll();

        if (isset($safeGet[$key])) {
            return $safeGet[$key];
        }

        return $default;
    }
}
