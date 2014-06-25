<?php

namespace Harp\MP\Test;

use Harp\Harp\AbstractModel;
use Harp\Core\Model\InheritedTrait;
use Harp\MP\MPTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Category extends AbstractModel
{
    const REPO = 'Harp\MP\Test\CategoryRepo';

    use MPTrait;
    use InheritedTrait;

    public $id;
    public $name;
}
