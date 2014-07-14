<?php

namespace Harp\MP\Test;

use Harp\MP\BelongsTo;
use Harp\Harp\Repo\LinkOne;
use Harp\Harp\Model\Models;

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
        $repo = Category::getRepo();
        $model1 = $this->getMock(__NAMESPACE__.'\Category', ['setPathAndUpdateDescendants']);
        $model2 = new Category(['id' => 6, 'path' => '1/4']);

        $models = new Models([$model2]);

        $model1
            ->expects($this->once())
            ->method('setPathAndUpdateDescendants')
            ->with('1/4/6')
            ->will($this->returnValue($models));


        $rel = new BelongsTo('test', $repo->getConfig(), $repo);

        $link = new LinkOne($model1, $rel, $model1);

        $result = $rel->update($link);

        $this->assertNull($result);

        $link->set($model2);

        $result = $rel->update($link);

        $this->assertSame($models, $result);
    }
}
