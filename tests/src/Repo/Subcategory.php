<?php

namespace Harp\MP\Test\Repo;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Subcategory extends Category
{
    private static $instance;

    /**
     * @return Subcategory
     */
    public static function get()
    {
        if (self::$instance === null) {
            self::$instance = new Subcategory('Harp\MP\Test\Model\Subcategory');
        }

        return self::$instance;
    }

    public function initialize()
    {
        parent::initialize();

        $this->setRootRepo(Category::get());
    }
}
