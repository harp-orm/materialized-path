<?php

namespace Harp\MP\Test\Model;

use Harp\Harp\AbstractModel;
use Harp\MP\Test\Repo;
use Harp\MP\MPModelTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Subcategory extends Category
{
    /**
     * @return Repo\Subcategory
     */
    public function getRepo()
    {
        return Repo\Subcategory::get();
    }
}
