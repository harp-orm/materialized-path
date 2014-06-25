<?php

namespace Harp\MP\Test;

use Harp\Harp\AbstractRepo;
use Harp\MP\Test\Model;
use Harp\MP\MPRepoTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class CategoryRepo extends AbstractRepo
{
    use MPRepoTrait;

    public function initialize()
    {
        $this
            ->setModelClass(__NAMESPACE__.'\Category')
            ->setInherited(true)
            ->initializeMaterializedPath();
    }
}
