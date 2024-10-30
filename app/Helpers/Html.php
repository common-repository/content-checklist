<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-10-14
 * Time: 13:35
 */

namespace Edlin\ContentChecklist\App\Helpers;


use Edlin\ContentChecklist\App\Heading;

class Html
{
    /**
     * @param $content
     * @param $start
     * @param $end
     *
     * @return string
     */
    public static function extractContentFromTag($content, $start, $end)
    {
        $content = ' ' . $content;
        $ini     = strpos($content, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($content, $end, $ini) - $ini;

        return substr($content, $ini, $len);
    }

    /**
     * @param $content
     *
     * @return array
     */
    public static function extractHeading($content): array
    {
        $structure = [];
        $h2s       = explode('<!-- wp:heading -->', $content);

        /**
         * H2
         */
        foreach ($h2s as $h2) {
            $h2k = Html::extractContentFromTag($h2, '<h2>', '</h2>');
            if (trim($h2k) !== '') {
                $structure[$h2k] = [];

                /**
                 * H3
                 */
                $h3s = explode('<!-- wp:heading {"level":3} -->', $h2);
                foreach ($h3s as $h3) {
                    $h3k = Html::extractContentFromTag($h3, '<h3>', '</h3>');
                    if (trim($h3k) !== '') {
                        $structure[$h2k][$h3k] = [];

                        /**
                         * H4
                         */
                        $h4s = explode('<!-- wp:heading {"level":4} -->', $h3);
                        foreach ($h4s as $h4) {
                            $h4k = Html::extractContentFromTag($h4, '<h4>', '</h4>');
                            if (trim($h4k) !== '') {
                                $structure[$h2k][$h3k][$h4k] = [];

                                /**
                                 * H5
                                 */
                                $h5s = explode('<!-- wp:heading {"level":5} -->', $h4);
                                foreach ($h5s as $h5) {
                                    $h5k = Html::extractContentFromTag($h5, '<h5>', '</h5>');
                                    if (trim($h5k) !== '') {
                                        $structure[$h2k][$h3k][$h4k][$h5k] = [];

                                        /**
                                         * H6
                                         */
                                        $h6s = explode('<!-- wp:heading {"level":6} -->', $h5);
                                        foreach ($h6s as $h6) {
                                            $h6k = Html::extractContentFromTag($h6, '<h6>', '</h6>');
                                            if (trim($h6k) !== '') {
                                                $structure[$h2k][$h3k][$h4k][$h5k][$h6k] = [];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $structure;
    }

    /**
     * @param $content
     *
     * @return array
     */
    public static function extractHeadingChild($content, $level = 1): array
    {
        $structure = [];
        $h2s       = explode('<!-- wp:heading -->', $content);

        /**
         * H2
         */
        foreach ($h2s as $h2) {
            $h2k = Html::extractContentFromTag($h2, '<h2>', '</h2>');
            if (trim($h2k) !== '') {
                $structure[$h2k] = new Heading();
            }
        }

        return $structure;
    }

    /**
     * @param $content
     *
     * @return array
     */
    public static function OLD__extractHeading($content): array
    {
        $structure = [];
        $h2s       = explode('<!-- wp:heading -->', $content);

        /**
         * H2
         */
        foreach ($h2s as $h2) {
            $h2k = Html::extractContentFromTag($h2, '<h2>', '</h2>');
            if (trim($h2k) !== '') {
                $structure[$h2k] = [];

                /**
                 * H3
                 */
                $h3s = explode('<!-- wp:heading {"level":3} -->', $h2);
                foreach ($h3s as $h3) {
                    $h3k = Html::extractContentFromTag($h3, '<h3>', '</h3>');
                    if (trim($h3k) !== '') {
                        $structure[$h2k][$h3k] = [];

                        /**
                         * H4
                         */
                        $h4s = explode('<!-- wp:heading {"level":4} -->', $h3);
                        foreach ($h4s as $h4) {
                            $h4k = Html::extractContentFromTag($h4, '<h4>', '</h4>');
                            if (trim($h4k) !== '') {
                                $structure[$h2k][$h3k][$h4k] = [];

                                /**
                                 * H5
                                 */
                                $h5s = explode('<!-- wp:heading {"level":5} -->', $h4);
                                foreach ($h5s as $h5) {
                                    $h5k = Html::extractContentFromTag($h5, '<h5>', '</h5>');
                                    if (trim($h5k) !== '') {
                                        $structure[$h2k][$h3k][$h4k][$h5k] = [];

                                        /**
                                         * H6
                                         */
                                        $h6s = explode('<!-- wp:heading {"level":6} -->', $h5);
                                        foreach ($h6s as $h6) {
                                            $h6k = Html::extractContentFromTag($h6, '<h6>', '</h6>');
                                            if (trim($h6k) !== '') {
                                                $structure[$h2k][$h3k][$h4k][$h5k][$h6k] = [];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $structure;
    }
}