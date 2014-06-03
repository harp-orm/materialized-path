<?php

namespace Harp\MP\Test;

use Harp\MP\BelongsTo;
use Harp\Core\Repo\LinkOne;
use Harp\Core\Model\Models;

/**
 * @coversDefaultClass Harp\MP\BelongsTo
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class BelongsToTest extends AbstractTestCase
{
    /**
     * @covers ::update
     */
    public function testUpdate()
    {
        $repo = Repo\Category::get();
        $model1 = $this->getMock(
            __NAMESPACE__.'\Model\Category',
            ['setPathAndUpdateDescendants']
        );
        $model2 = new Model\Category(['id' => 6, 'path' => '1/4']);

        $models = new Models([$model2]);

        $model1
            ->expects($this->once())
            ->method('setPathAndUpdateDescendants')
            ->with('1/4/6')
            ->will($this->returnValue($models));


        $rel = new BelongsTo('test', $repo, $repo);

        $link = new LinkOne($rel, $model1);

        $result = $rel->update($model1, $link);

        $this->assertNull($result);

        $link->set($model2);

        $result = $rel->update($model1, $link);

        $this->assertSame($models, $result);
    }
}
