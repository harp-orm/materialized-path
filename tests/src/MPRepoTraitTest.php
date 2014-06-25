<?php

namespace Harp\MP\Test;

use Harp\MP\Test\AbstractTestCase;

/**
 * @coversDefaultClass Harp\MP\MPRepoTrait
 */
class MPRepoTraitTest extends AbstractTestCase
{
    /**
     * @covers ::initializeMaterializedPath
     */
    public function testInitialize()
    {
        $cat = new CategoryRepo();

        $this->assertInstanceOf('Harp\Harp\Rel\BelongsTo', $cat->getRel('parent'));
        $this->assertInstanceOf('Harp\Harp\Rel\HasMany', $cat->getRel('children'));
    }
}
