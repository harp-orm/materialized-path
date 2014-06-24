<?php

namespace Harp\MP\Test\Repo;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Subcategory extends Category
{
    public function initialize()
    {
        parent::initialize();

        $this
            ->setModelClass('Harp\MP\Test\Model\Subcategory')
            ->setRootRepo(Category::get());
    }
}
