<?php

require(__DIR__.'/../lib/vendor/jackalope/src/Jackalope/autoloader.php');

require_once __DIR__.'/../src/PHPCRTree.php';

class PHPCRTreeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $node_mock_prototype = $this->getMockBuilder('Jackalope\Node')->
            disableOriginalConstructor()->
            setMethods(array('getPath', 'getNodes'));
        
        $anonimarmonisti = $node_mock_prototype->getMock();
        $anonimarmonisti->expects($this->once())->
                method('getPath')->
                will($this->returnValue('/com/anonimarmonisti'));
        $anonimarmonisti->expects($this->once())->
                method('getNodes')->
                will($this->returnValue(true));
        
        $romereview = $node_mock_prototype->getMock();
        $romereview->expects($this->once())->
                method('getPath')->
                will($this->returnValue('/com/romereview'));
        $romereview->expects($this->once())->
                method('getNodes')->
                will($this->returnValue(true));
        
        $_5etto = $node_mock_prototype->getMock();
        $_5etto->expects($this->once())->
                method('getPath')->
                will($this->returnValue('/com/5etto'));
        $_5etto->expects($this->once())->
                method('getNodes')->
                will($this->returnValue(true));
        
        $wordpress = $node_mock_prototype->getMock();
        $wordpress->expects($this->once())->
                method('getPath')->
                will($this->returnValue('/com/wordpress'));
        $wordpress->expects($this->once())->
                method('getNodes')->
                will($this->returnValue(true));
        
        $children = array(
            'anonimarmonisti' => $anonimarmonisti,
            'romereview' => $romereview,
            '5etto' => $_5etto,
            'wordpress' => $wordpress,
        );
        
        $root = $this->getMockBuilder('Jackalope\Node')->
            disableOriginalConstructor()->
            setMethods(array('getNodes'))->
            getMock();
        $root->expects($this->once())->
                method('getNodes')->
                with('*')->
                will($this->returnValue($children));
                
        $session = $this->getMockBuilder('Jackalope\Session')->
            disableOriginalConstructor()->
            setMethods(array('getNode'))->
            getMock();
        
        $session->expects($this->once())->
                method('getNode')->
                with('/com')->
                will($this->returnValue($root));
        
        $this->tree = new Ideato\TreeBundle\PHPCRTree($session);
    }
    
    public function testPHPCRChildrenToJSONChildren()
    {
        $this->assertEquals(
            '[{"text":"anonimarmonisti","id":"\/com\/anonimarmonisti","hasChildren":true},{"text":"romereview","id":"\/com\/romereview","hasChildren":true},{"text":"5etto","id":"\/com\/5etto","hasChildren":true},{"text":"wordpress","id":"\/com\/wordpress","hasChildren":true}]',
            $this->tree->getJSON('/com')
        );
    }
}