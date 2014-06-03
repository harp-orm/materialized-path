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
    private static $instance;

    /**
     * @return Dummy
     */
    public static function get()
    {
        if (self::$instance === null) {
            self::$instance = new Dummy('Harp\MP\Test\Model\Dummy');
        }

        return self::$instance;
    }

    public function initialize()
    {
    }
}
