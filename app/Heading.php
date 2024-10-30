<?php
/**
 * @author Ross Edlin <contact@rossedlin.com>
 * Date: 2020-10-14
 * Time: 14:02
 */

namespace Edlin\ContentChecklist\App;


class Heading
{
    private $level = 1; //H1 - H6;

    private $childen = [];

    public function isValid(): bool
    {

    }

    /**
     * @return Heading[]
     */
    public function getChildren(): array
    {

    }
}