<?php

namespace Harp\MP\Test\Repo;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Subcategory extends Category
{
    public static function newInstance()
    {
        return new Subcategory('Harp\MP\Test\Model\Subcategory');
    }

    public function initialize()
    {
        parent::initialize();

        $this->setRootRepo(Category::get());
    }
}
