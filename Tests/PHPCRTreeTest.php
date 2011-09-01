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
            'anonimarmonisti'   => $anonimarmonisti,
            'romereview'        => $romereview,
            '5etto'             => $_5etto,
            'wordpress'         => $wordpress,
        );
        
        $properties = array(
            'jcr:createdBy'     => 'user',
            'jcr:created'       => new DateTime("2011-08-31 11:02:39"),
            'jcr:primaryType'   => 'nt:folder',
        );
        
        $com = $this->getMockBuilder('Jackalope\Node')->
            disableOriginalConstructor()->
            getMock();
        $com->expects($this->once())->
                method('getNodes')->
                will($this->returnValue($children));
        $com->expects($this->once())->
                method('getPropertiesValues')->
                will($this->returnValue($properties));
                
        $session = $this->getMockBuilder('PHPCR\SessionInterface')->
            disableOriginalConstructor()->
            getMock();
        
        $session->expects($this->once())->
                method('getNode')->
                with('/com')->
                will($this->returnValue($com));
        
        // This is just temporary code to be removed.
        // It just makes it easier to investigate PHPCR internals
//        $repository = Jackalope\RepositoryFactoryJackrabbit::getRepository(array(
//            'jackalope.jackrabbit_uri' => 'http://localhost:8080/server'
//        ));
//        $credentials = new PHPCR\SimpleCredentials('jakuza', 'jakuza');
//        $session = $repository->login($credentials, 'default');
        
        $this->tree = new Ideato\TreeBundle\PHPCRTree($session);
    }
    
    public function testPHPCRChildrenToJSON()
    {
        $this->assertEquals(
            '[{"text":"anonimarmonisti","id":"\/com\/anonimarmonisti","hasChildren":true},{"text":"romereview","id":"\/com\/romereview","hasChildren":true},{"text":"5etto","id":"\/com\/5etto","hasChildren":true},{"text":"wordpress","id":"\/com\/wordpress","hasChildren":true}]',
            $this->tree->getChildrenJSON('/com')
        );
    }

    public function testPHPCRPropertiesToJSON()
    {
        $this->assertEquals(
            '[{"name":"jcr:createdBy","value":"user"},{"name":"jcr:created","value":{"date":"2011-08-31 11:02:39","timezone_type":3,"timezone":"Europe\/Berlin"}},{"name":"jcr:primaryType","value":"nt:folder"}]',
            $this->tree->getPropertiesJSON('/com')
        );
    }
}