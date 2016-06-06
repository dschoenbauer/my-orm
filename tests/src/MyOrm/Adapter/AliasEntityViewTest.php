<?php namespace CTIMT\MyOrm\Adapter;

use CTIMT\MyOrm\Enum\LayoutKeys;
use CTIMT\MyOrm\Enum\ModelEvents;
use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-02 at 22:09:56.
 */
class AliasEntityViewTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var AliasEntityView
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new AliasEntityView;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testAddAliasToEntityLayout()
    {
        $data = ["newKey" => "value"];
        $mapping = ['key' => 'newKey'];
        $this->object->setMapping($mapping);
        $result = $this->object->addAliasToEntityLayout($data);
        $this->assertArrayHasKey(LayoutKeys::META_KEY, $result);
        $this->assertArrayHasKey(Alias::FIELD, $result[LayoutKeys::META_KEY]);
        $this->assertEquals($mapping, $result[LayoutKeys::META_KEY][Alias::FIELD]);
    }

    public function testUpdateLayoutEntityApplied()
    {
        $model = $this->getMockBuilder('\CTIMT\MyOrm\Model\Model')
                ->disableOriginalConstructor()->setMethods(null)->getMock();

        $entity = $this->getMockBuilder('\CTIMT\MyOrm\Entity\AbstractEntity')
            ->getMock();
        $entity->method('getName')->willReturn('test');

        $model->setEntity($entity)->setData(['test' => [['test' => 'value1'], ['test' => 'value2']]]);
        $this->assertTrue($this->object->setEventNames([ModelEvents::LAYOUT_ENTITY_APPLIED])->update($model, ModelEvents::LAYOUT_ENTITY_APPLIED));
    }
    
    public function testUpdateLayoutEntityNeverApplied()
    {
        $model = $this->getMockBuilder('\CTIMT\MyOrm\Model\Model')
                ->disableOriginalConstructor()->setMethods(null)->getMock();
        $model->expects($this->never())
            ->method('getData');
        $entity = $this->getMockBuilder('\CTIMT\MyOrm\Entity\AbstractEntity')
            ->getMock();
        $entity->method('getName')->willReturn('test');

        $model->setEntity($entity)->setData(['test' => [['test' => 'value1'], ['test' => 'value2']]]);
        $this->assertTrue($this->object->setEventNames(['unknownEvent'])->update($model, ModelEvents::LAYOUT_ENTITY_APPLIED));
    }
}