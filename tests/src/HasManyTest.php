<?php

namespace Harp\MP\Test;

use Harp\MP\HasMany;
use Harp\Harp\Repo\LinkMany;
use Harp\Harp\Model\Models;

/**
 * @coversDefaultClass Harp\MP\HasMany
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class HasManyTest extends AbstractTestCase
{
    /**
     * @covers ::update
     */
    public function testUpdate()
    {
        $repo = Category::getRepo();
        $model = new Category(['id' => 6, 'path' => '1/4']);

        $model1 = $this->getMock(
            __NAMESPACE__.'\Category',
            ['setPathAndUpdateDescendants'],
            [['id' => 1]]
        );

        $model2 = $this->getMock(
            __NAMESPACE__.'\Category',
            ['setPathAndUpdateDescendants'],
            [['id' => 2]]
        );

        $added = new Models([$model1]);
        $removed = new Models([$model2]);

        $model1
            ->expects($this->once())
            ->method('setPathAndUpdateDescendants')
            ->with('1/4/6')
            ->will($this->returnValue($added));

        $model2
            ->expects($this->once())
            ->method('setPathAndUpdateDescendants')
            ->with('')
            ->will($this->returnValue($removed));

        $rel = new HasMany('test', $repo->getConfig(), $repo);

        $link = new LinkMany($model, $rel, [$model2]);

        $result = $rel->update($link);

        $this->assertCount(0, $result);

        $link
            ->add($model1)
            ->remove($model2);

        $result = $rel->update($link);

        $this->assertSame([$model2, $model1], $result->toArray());
    }
}
