<?php

namespace Harp\MP\Test\Repo;

use Harp\Harp\AbstractRepo;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Dummy extends AbstractRepo
{
    public static function newInstance()
    {
        return new Dummy('Harp\MP\Test\Model\Dummy');
    }


    public function initialize()
    {
    }
}
