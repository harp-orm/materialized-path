<?php

namespace Harp\MP\Test;

use Harp\Query\DB;
use PHPUnit_Framework_TestCase;
use Harp\Core\Repo\Container;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractTestCase extends PHPUnit_Framework_TestCase {

    /**
     * @var TestLogger
     */
    protected $logger;

    /**
     * @return TestLogger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    public function setUp()
    {
        parent::setUp();

        $this->logger = new TestLogger();

        DB::setConfig([
            'dsn' => 'mysql:dbname=harp-orm/materialized-path;host=127.0.0.1',
            'username' => 'root',
        ]);

        DB::get()->setLogger($this->logger);
        DB::get()->beginTransaction();

        Container::clear();
    }

    public function tearDown()
    {
        DB::get()->rollback();

        parent::tearDown();
    }

    public function assertQueries(array $query)
    {
        $this->assertEquals($query, $this->getLogger()->getEntries());
    }
}
