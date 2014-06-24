<?php

namespace Harp\MP\Test\Model;

use Harp\Harp\AbstractModel;
use Harp\MP\Test\Repo;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Dummy extends AbstractModel
{
    const REPO = 'Harp\MP\Test\Repo\Category';

    public $id;
}
