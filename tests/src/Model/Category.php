<?php

namespace Harp\MP\Test\Model;

use Harp\Harp\AbstractModel;
use Harp\MP\Model\MPTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Category extends AbstractModel
{
    const REPO = 'Harp\MP\Test\Repo\Category';

    use MPTrait;

    public $id;
    public $name;
}
