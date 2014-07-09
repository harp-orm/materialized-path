<?php

namespace Harp\MP\Test;

use Harp\Harp\AbstractModel;
use Harp\Core\Model\InheritedTrait;
use Harp\MP\MaterializedPathTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Category extends AbstractModel
{
    use MaterializedPathTrait;
    use InheritedTrait;

    public static function initialize($repo)
    {
        MaterializedPathTrait::initialize($repo);
        InheritedTrait::initialize($repo);
    }

    public $id;
    public $name;
}
