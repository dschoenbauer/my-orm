<?php namespace CTIMT\MyOrm\Model;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-06 at 19:58:54.
 */
class ActionCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ActionCollection
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    
    protected function getMockModel()
    {
        $model = $this->getMockBuilder('\CTIMT\MyOrm\Model\Model')
            ->disableOriginalConstructor()->getMock();
        
        return $model;
    }
    
    protected function getMockModelVisitor(){
        return $this->getMock('\CTIMT\MyOrm\Model\ModelVisitorInterface');
    }


    protected function setUp()
    {
        $this->object = new ActionCollection($this->getMockModel());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testAdd()
    {
        $this->object->add('test', $this->getMockModelVisitor(), 100);
        $this->object->add('test', $this->getMockModelVisitor(), 100);
        $this->object->add('test', $this->getMockModelVisitor(), 100);
        $this->object->add('test', $this->getMockModelVisitor(), 100);
        $ref = new \ReflectionClass($this->object);
        /* @var $prop \ReflectionProperty */
        $prop = $ref->getProperties()[1];
        $prop->setAccessible(true);
        $values = $prop->getValue($this->object)['test'];
        $this->assertEquals(4, count($values),'all items added');
        $priority = array_column($values,  ActionCollection::PRIORITY);
        $this->assertEquals(100,max($priority),'max priority');
        $this->assertEquals(100,min($priority),'min priority');
        
    }

    public function testRun()
    {
        $this->object->getModel()
            ->expects($this->exactly(4))
            ->method('accept');
        $this->object->add('test', $this->getMockModelVisitor(),10);
        $this->object->add('test', $this->getMockModelVisitor(),10);
        $this->object->add('test', $this->getMockModelVisitor(),10);
        $this->object->add('test', $this->getMockModelVisitor(),10);
        $this->object->add('notInTest', $this->getMockModelVisitor(),10);
        $this->object->run('test');
    }

    public function testExtractEmptyQueue(){
        $this->assertEquals([],$this->object->extractQueue('test'));
    }
    
    public function testExtractLoadedQueue(){
        $first = $this->getMockModelVisitor();
        $second = $this->getMockModelVisitor();
        $third = $this->getMockModelVisitor();
        $fourth = $this->getMockModelVisitor();
        $last = $this->getMockModelVisitor();
        
        $this->object->add('test', $second, 100);
        $this->object->add('test', $third, 100);
        $this->object->add('test', $first, 0);
        $this->object->add('test', $last, 1000);
        $this->object->add('NotInTest', $fourth, 100);
        $this->object->add('test', $fourth, 100);
        
        $queue = $this->object->extractQueue('test');
        $this->assertSame($first,$queue[0]);
        $this->assertSame($second,$queue[1]);
        $this->assertSame($third,$queue[2]);
        $this->assertSame($fourth,$queue[3]);
        $this->assertSame($last,$queue[4]);
    }


    public function testModel()
    {
        $model = $this->getMockModel();
        $this->assertSame($model, $this->object->setModel($model)->getModel());
    }
}
