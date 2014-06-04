<?php

namespace Harp\MP\Test;

/**
 * @coversDefaultClass Harp\MP\MPRepoTrait
 */
class MPRepoTraitTest extends AbstractTestCase
{
    /**
     * @covers ::initializeMaterializedPath
     * @covers ::getMpRepo
     * @covers ::setMpRepo
     */
    public function testInitialize()
    {
        $cat = new Repo\Category('Harp\MP\Test\Model\Category');

        $this->assertInstanceOf('Harp\Harp\Rel\BelongsTo', $cat->getRel('parent'));
        $this->assertInstanceOf('Harp\Harp\Rel\HasMany', $cat->getRel('children'));

        $this->assertSame($cat, $cat->getMpRepo());
    }
}
