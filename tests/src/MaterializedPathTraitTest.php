<?php

namespace Harp\MP\Test;

use Harp\MP\MaterializedPathTrait;

/**
 * @coversDefaultClass Harp\MP\MaterializedPathTrait
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class MaterializedPathTraitTest extends AbstractTestCase
{
    /**
     * @covers ::initialize
     */
    public function testInitialize()
    {
        $repo = Category::getRepo();

        $this->assertInstanceOf('Harp\Harp\Rel\BelongsTo', $repo->getRel('parent'));
        $this->assertInstanceOf('Harp\Harp\Rel\HasMany', $repo->getRel('children'));
    }

    /**
     * @covers ::getParent
     * @covers ::isRoot
     */
    public function testParent()
    {
        $cat1 = Category::find(1);
        $cat2 = Category::find(2);
        $cat3 = Category::find(4);

        $this->assertTrue($cat1->getParent()->isVoid());
        $this->assertFalse($cat2->isRoot());

        $this->assertSame($cat1, $cat2->getParent());
        $this->assertSame($cat2, $cat3->getParent());
        $this->assertSame($cat1, $cat3->getParent()->getParent());
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::setParent
     */
    public function testSetParentException()
    {
        $cat = Category::find(1);
        $dummy = new Dummy();

        $cat->setParent($dummy);
    }

    /**
     * @covers ::setParent
     */
    public function testSetParent()
    {
        $parent = Category::find(2);
        $child = Category::find(6);

        $child->setParent($parent);

        Category::save($child);

        $this->assertSame('1/2', $child->path);

        $leaf1 = Category::find(7);
        $this->assertSame('1/2/6', $leaf1->path);

        $leaf2 = Category::find(8);
        $this->assertSame('1/2/6', $leaf2->path);
    }

    public function dataIsDescendantOf()
    {
        return [
            [1, 1, false],
            [2, 1, true],
            [3, 1, true],
            [4, 1, true],
            [5, 1, true],
            [6, 1, true],
            [7, 1, true],
            [8, 1, true],
            [4, 3, false],
            [4, 2, true],
        ];
    }

    /**
     * @dataProvider dataIsDescendantOf
     * @covers ::isDescendantOf
     */
    public function testIsDescendantOf($descendantId, $ansestorId, $expected)
    {
        $descendant = Category::find($descendantId);
        $ansestor = Category::find($ansestorId);

        $this->assertSame($expected, $descendant->isDescendantOf($ansestor));
    }

    public function dataIsAnsestorOf()
    {
        return [
            [1, 1, false],
            [1, 2, true],
            [1, 3, true],
            [1, 4, true],
            [1, 5, true],
            [1, 6, true],
            [1, 7, true],
            [1, 8, true],
            [3, 4, false],
            [2, 4, true],
        ];
    }

    /**
     * @dataProvider dataIsAnsestorOf
     * @covers ::isAnsestorOf
     */
    public function testIsAnsestorOf($ansestorId, $descendantId, $expected)
    {
        $ansestor = Category::find($ansestorId);
        $descendant = Category::find($descendantId);

        $this->assertSame($expected, $ansestor->isAnsestorOf($descendant));
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::isAnsestorOf
     */
    public function testIsAnsestorOfException()
    {
        $cat = Category::find(1);
        $dummy = new Dummy();

        $cat->isAnsestorOf($dummy);
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::isDescendantOf
     */
    public function testIsDescendantOfException()
    {
        $cat = Category::find(1);
        $dummy = new Dummy();

        $cat->isDescendantOf($dummy);
    }

    /**
     * @covers ::setPathAndUpdateDescendants
     * @covers ::updateDescendants
     * @covers ::getChildrenPath
     */
    public function testPath()
    {
        $root = Category::find(1);
        $sub = Category::find(6);
        $leaf1 = Category::find(7);
        $leaf2 = Category::find(8);

        $this->assertEquals('1', $root->getChildrenPath());
        $this->assertEquals('1/3/6', $sub->getChildrenPath());

        $sub->parentId = 2;
        $sub->setPathAndUpdateDescendants('1/2');

        Category::saveArray([$sub, $leaf1, $leaf2]);


        $this->assertEquals('1/2', $sub->path);
        $this->assertEquals('1/2/6', $sub->getChildrenPath());

        $this->assertEquals('1/2/6', $leaf1->path);
        $this->assertEquals('1/2/6', $leaf2->path);

        $sub->parentId = 0;
        $sub->setPathAndUpdateDescendants('');

        Category::saveArray([$sub, $leaf1, $leaf2]);

        $this->assertEquals('', $sub->path);
        $this->assertEquals('6', $leaf1->path);
        $this->assertEquals('6', $leaf2->path);
    }

    public function dataGetPathIds()
    {
        return [
            [null, []],
            ['1/3', [1, 3]],
            ['1/3/8/5', [1, 3, 8, 5]],
        ];
    }

    /**
     * @covers ::getPathIds
     * @dataProvider dataGetPathIds
     */
    public function testGetPathIds($path, $expected)
    {
        $model = new Category(['path' => $path]);

        $this->assertEquals($expected, $model->getPathIds());
    }

    /**
     * @covers ::getDescendants
     */
    public function testGetDescendants()
    {
        $root = Category::find(1);
        $cat1 = Category::find(2);
        $cat2 = Category::find(3);
        $sub1 = Category::find(4);
        $sub2 = Category::find(5);
        $sub3 = Category::find(6);
        $leaf1 = Category::find(7);
        $leaf2 = Category::find(8);

        $this->assertSame([$leaf1, $leaf2], $sub3->getDescendants()->toArray());
        $this->assertSame([$sub1, $sub2], $cat1->getDescendants()->toArray());
        $this->assertSame([$sub3, $leaf1, $leaf2], $cat2->getDescendants()->toArray());
        $this->assertSame([$cat1, $cat2, $sub1, $sub2, $sub3, $leaf1, $leaf2], $root->getDescendants()->toArray());
    }

    /**
     * @covers ::getChildren
     */
    public function testChildren()
    {
        $root = Category::find(1);
        $cat2 = Category::find(2);
        $cat3 = Category::find(3);
        $sub = Category::find(6);
        $leaf1 = Category::find(7);
        $leaf2 = Category::find(8);

        $this->assertInstanceOf('Harp\Harp\Repo\LinkMany', $root->getChildren());
        $this->assertSame([$cat2, $cat3], $root->getChildren()->toArray());

        $root
            ->getChildren()
                ->remove($cat2);

        $root
            ->getChildren()
                ->add($sub);

        Category::save($root);

        $this->assertEquals([3, 6, 7, 8], $root->getDescendants()->getIds());

        $this->assertEquals(0, $cat2->parentId);
        $this->assertEquals('', $cat2->path);

        $this->assertEquals(6, $leaf1->parentId);
        $this->assertEquals('1/6', $leaf1->path);

        $this->assertEquals(6, $leaf2->parentId);
        $this->assertEquals('1/6', $leaf2->path);
    }

    /**
     * @covers ::getAnsestors
     */
    public function testGetAnsestors()
    {
        $cat1 = Category::find(1);
        $cat2 = Category::find(2);
        $cat3 = Category::find(4);

        $parents = $cat3->getAnsestors();

        $this->assertInstanceOf('Harp\Harp\Model\Models', $parents);
        $this->assertSame([$cat1, $cat2], $parents->toArray());

        $parents = $cat1->getAnsestors();

        $this->assertInstanceOf('Harp\Harp\Model\Models', $parents);
        $this->assertCount(0, $parents->toArray());
    }}
