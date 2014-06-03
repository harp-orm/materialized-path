<?php

namespace Harp\MP\Test\Repo;

use Harp\Harp\AbstractRepo;
use Harp\MP\Test\Model;
use Harp\MP\MPRepoTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Category extends AbstractRepo
{
    use MPRepoTrait;

    private static $instance;

    /**
     * @return Category
     */
    public static function get()
    {
        if (self::$instance === null) {
            self::$instance = new Category('Harp\MP\Test\Model\Category');
        }

        return self::$instance;
    }

    public function initialize()
    {
        $this->initializeMaterializedPath();
    }
}
