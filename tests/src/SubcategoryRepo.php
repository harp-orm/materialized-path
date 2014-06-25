<?php

namespace Harp\MP\Test;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class SubcategoryRepo extends CategoryRepo
{
    public function initialize()
    {
        parent::initialize();

        $this
            ->setModelClass(__NAMESPACE__.'\Subcategory')
            ->setRootRepo(CategoryRepo::get());
    }
}
