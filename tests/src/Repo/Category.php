<?php

namespace Harp\MP\Test\Repo;

use Harp\Harp\AbstractRepo;
use Harp\MP\Test\Model;
use Harp\MP\Repo\MPTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Category extends AbstractRepo
{
    use MPTrait;

    public function initialize()
    {
        $this
            ->setModelClass('Harp\MP\Test\Model\Category')
            ->initializeMaterializedPath();
    }
}
