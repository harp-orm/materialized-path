<?php

namespace Harp\MP\Test\Repo;

use Harp\MP\Test\AbstractTestCase;
use Harp\MP\Test\Repo;

/**
 * @coversDefaultClass Harp\MP\Repo\MPTrait
 */
class MPTraitTest extends AbstractTestCase
{
    /**
     * @covers ::initializeMaterializedPath
     */
    public function testInitialize()
    {
        $cat = new Repo\Category('Harp\MP\Test\Model\Category');

        $this->assertInstanceOf('Harp\Harp\Rel\BelongsTo', $cat->getRel('parent'));
        $this->assertInstanceOf('Harp\Harp\Rel\HasMany', $cat->getRel('children'));
    }
}
