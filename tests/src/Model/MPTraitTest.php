<?php

namespace Harp\MP\Test\Model;

use Harp\MP\Model\MPTrait;
use Harp\MP\Test\Repo;
use Harp\MP\Test\AbstractTestCase;

/**
 * @coversDefaultClass Harp\MP\Model\MPTrait
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class MPTraitTest extends AbstractTestCase
{
    /**
     * @covers ::getParent
     * @covers ::isRoot
     */
    public function testParent()
    {
        $cat1 = Repo\Category::get()->find(1);
        $cat2 = Repo\Category::get()->find(2);
        $cat3 = Repo\Category::get()->find(4);

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
        $cat = Repo\Category::get()->find(1);
        $dummy = new Dummy();

        $cat->setParent($dummy);
    }

    /**
     * @covers ::setParent
     */
    public function testSetParent()
    {
        $parent = Repo\Category::get()->find(2);
        $child = Repo\Category::get()->find(6);

        $child->setParent($parent);

        Repo\Category::get()->save($child);

        $this->assertSame('1/2', $child->path);

        $leaf1 = Repo\Category::get()->find(7);
        $this->assertSame('1/2/6', $leaf1->path);

        $leaf2 = Repo\Category::get()->find(8);
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
        $descendant = Repo\Category::get()->find($descendantId);
        $ansestor = Repo\Category::get()->find($ansestorId);

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
        $ansestor = Repo\Category::get()->find($ansestorId);
        $descendant = Repo\Category::get()->find($descendantId);

        $this->assertSame($expected, $ansestor->isAnsestorOf($descendant));
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::isAnsestorOf
     */
    public function testIsAnsestorOfException()
    {
        $cat = Repo\Category::get()->find(1);
        $dummy = new Dummy();

        $cat->isAnsestorOf($dummy);
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::isDescendantOf
     */
    public function testIsDescendantOfException()
    {
        $cat = Repo\Category::get()->find(1);
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
        $root = Repo\Category::get()->find(1);
        $sub = Repo\Category::get()->find(6);
        $leaf1 = Repo\Category::get()->find(7);
        $leaf2 = Repo\Category::get()->find(8);

        $this->assertEquals('1', $root->getChildrenPath());
        $this->assertEquals('1/3/6', $sub->getChildrenPath());

        $sub->parentId = 2;
        $sub->setPathAndUpdateDescendants('1/2');

        Repo\Category::get()
            ->newSave()
                ->addArray([$sub, $leaf1, $leaf2])
                ->execute();

        $this->assertEquals('1/2', $sub->path);
        $this->assertEquals('1/2/6', $sub->getChildrenPath());

        $this->assertEquals('1/2/6', $leaf1->path);
        $this->assertEquals('1/2/6', $leaf2->path);

        $sub->parentId = 0;
        $sub->setPathAndUpdateDescendants('');

        Repo\Category::get()
            ->newSave()
                ->addArray([$sub, $leaf1, $leaf2])
                ->execute();

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
        $root = Repo\Category::get()->find(1);
        $cat1 = Repo\Category::get()->find(2);
        $cat2 = Repo\Category::get()->find(3);
        $sub1 = Repo\Category::get()->find(4);
        $sub2 = Repo\Category::get()->find(5);
        $sub3 = Repo\Category::get()->find(6);
        $leaf1 = Repo\Category::get()->find(7);
        $leaf2 = Repo\Category::get()->find(8);

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
        $root = Repo\Category::get()->find(1);
        $cat2 = Repo\Category::get()->find(2);
        $cat3 = Repo\Category::get()->find(3);
        $sub = Repo\Category::get()->find(6);
        $leaf1 = Repo\Category::get()->find(7);
        $leaf2 = Repo\Category::get()->find(8);

        $this->assertInstanceOf('Harp\Core\Repo\LinkMany', $root->getChildren());
        $this->assertSame([$cat2, $cat3], $root->getChildren()->toArray());

        $root
            ->getChildren()
                ->remove($cat2);

        $root
            ->getChildren()
                ->add($sub);

        Repo\Category::get()->save($root);

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
        $cat1 = Repo\Category::get()->find(1);
        $cat2 = Repo\Category::get()->find(2);
        $cat3 = Repo\Category::get()->find(4);

        $parents = $cat3->getAnsestors();

        $this->assertInstanceOf('Harp\Core\Model\Models', $parents);
        $this->assertSame([$cat1, $cat2], $parents->toArray());

        $parents = $cat1->getAnsestors();

        $this->assertInstanceOf('Harp\Core\Model\Models', $parents);
        $this->assertCount(0, $parents->toArray());
    }}
