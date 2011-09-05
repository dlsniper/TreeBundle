<?php

namespace Ideato\TreeBundle\Tests;

use Ideato\TreeBundle\Tree;

require_once __DIR__.'/../src/TreeInterface.php';
require_once __DIR__.'/../src/Tree.php';

class TreeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->node = new Tree();
        $this->node->setLabel('Homepage');
    }

    public function testTreeImplementsRightInterfaces()
    {
        $this->assertInstanceOf('Ideato\TreeBundle\TreeInterface', $this->node);
        $this->assertInstanceOf('\RecursiveIterator', $this->node);
    }

    public function testLabelOfOneLeaf()
    {
        $this->assertEquals('[{"text":"Homepage","children":[]}]', $this->node->__toString());
    }

    public function testAddOneChild()
    {
        $child = new Tree();
        $child->setLabel('Child 1');

        $this->node->add($child);

        $this->assertEquals('[{"text":"Homepage","children":[{"text":"Child 1","children":[]}]}]', $this->node->__toString());
    }

    public function testAddTwoChildrenAndOneGrandchild()
    {
        $child = new Tree();
        $child->setLabel('Child 1');
        $child2 = new Tree();
        $child2->setLabel('Child 2');
        $grandchild = new Tree();
        $grandchild->setLabel('Granchild');

        $this->node->add($child);
        $this->node->add($child2);
        $child2->add($grandchild);

        $this->assertEquals('[{"text":"Homepage","children":[{"text":"Child 1","children":[]},{"text":"Child 2","children":[{"text":"Granchild","children":[]}]}]}]', $this->node->__toString());
    }

    public function testHasChildren()
    {
        $child = new Tree();
        $child->setLabel('Child 1');
        $child2 = new Tree();
        $child2->setLabel('Child 2');

        $this->assertFalse($this->node->hasChildren());

        $this->node->add($child);
        $this->node->add($child2);

        $this->assertTrue($this->node->hasChildren());
    }

    public function testGetChildren()
    {
        $child = new Tree();
        $child->setLabel('Child 1');
        $child2 = new Tree();
        $child2->setLabel('Child 2');

        $this->node->add($child);
        $this->node->add($child2);

        $this->assertEquals(array($child, $child2), $this->node->getChildren());
    }

    public function testGetNodeWithAPath()
    {
        $child1 = new Tree();
        $child1->setLabel('Child 1');
        $child2 = new Tree();
        $child2->setLabel('Child 2');
        $child3 = new Tree();
        $child3->setLabel('Child 3');
        $child4 = new Tree();
        $child4->setLabel('Child 4');
        $child5 = new Tree();
        $child5->setLabel('Child 5');
        $child6 = new Tree();
        $child6->setLabel('Child 6');


        $this->node->add($child1);
        $this->node->add($child2);
        $child2->add($child4);
        $child2->add($child3);
        $child4->add($child5);

        $this->assertEquals('[{"text":"Child 4","children":[{"text":"Child 5","children":[]}]}]', $this->node->getNode(array(1, 0))->__toString());
        $this->assertEquals('[{"text":"Child 3","children":[]}]', $this->node->getNode(array(1, 1))->__toString());
        $this->assertEquals('[{"text":"Child 5","children":[]}]', $this->node->getNode(array(1, 0, 0))->__toString());
    }
//
//    public function testPrune()
//    {
//        $child1 = new Tree();
//        $child1->setLabel('Child 1');
//        $child2 = new Tree();
//        $child2->setLabel('Child 2');
//        $child3 = new Tree();
//        $child3->setLabel('Child 3');
//        $child4 = new Tree();
//        $child4->setLabel('Child 4');
//        $child5 = new Tree();
//        $child5->setLabel('Child 5');
//        $child6 = new Tree();
//        $child6->setLabel('Child 6');
//
//
//        $this->node->add($child1);
//        $this->node->add($child2);
//        $child2->add($child4);
//        $child2->add($child3);
//        $child4->add($child5);
//
//        $this->assertEquals('[{"text":"Homepage","children":[]}]', $this->node->prune(0)->__toString());
//
//        $this->assertEquals('[{"text":"Homepage","children":[{"text":"Child 1","children":[]},{"text":"Child 2","children":[]}]}]', $this->node->prune(1)->__toString());
//
//    }

    public function testCloningLeafTree()
    {
        $tree = new Tree();
        $clone = clone $tree;

        $this->assertInstanceOf('\Ideato\TreeBundle\Tree', $clone);
        $this->assertEquals($tree->__toString(), $clone->__toString());
    }


    public function testCloningNodeTree()
    {
//        $tree = new Tree();
//        $child->setLabel('Child 1');
//        $child2 = new Tree();
//        $child2->setLabel('Child 2');
//
//        $this->node->add($child);
//        $this->node->add($child2);
//
//        $this->assertInstanceOf('\Ideato\TreeBundle\Tree', $tree);
    }

}

