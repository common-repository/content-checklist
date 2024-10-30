<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-12-15
 * Time: 11:07
 */

namespace Edlin\ContentChecklist\App;


class Settings
{
    /**
     * @param int $default
     *
     * @return int
     */
    public static function getWordLimitGreen($default = 1000): int
    {
        return (int)esc_attr(get_option('wpcc_word_limit_green', $default));
    }

    /**
     * @param int $default
     *
     * @return int
     */
    public static function getWordLimitOrange($default = 750): int
    {
        return (int)esc_attr(get_option('wpcc_word_limit_orange', $default));
    }
}