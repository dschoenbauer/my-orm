<?php namespace CTIMT\MyOrm\Visitor\DataType;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-06 at 18:39:25.
 */
class NumericTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Numeric
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Numeric;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testVisitModel()
    {
        
        $entity = $this->getMockBuilder('\CTIMT\MyOrm\Entity\HasNumericFieldsInterface')->getMock();
        $model = $this->getMockBuilder('\CTIMT\MyOrm\Model\Model')->disableOriginalConstructor()->getMock();
        $model->expects($this->once())->method('getEntity')->willReturn($entity);
        $model->expects($this->once())->method('attach');
        $this->object->visitModel($model);
    }
    
    public function testVisitModelInCorrectType()
    {
        
        $model = $this->getMockBuilder('\CTIMT\MyOrm\Model\Model')->disableOriginalConstructor()->getMock();       
        $model->expects($this->never())->method('attach');
        $this->object->visitModel($model);
    }


    public function testValidateSuccess()
    {
        $data  = [
            'number'=>1,
            'text'=>'someText',
            'boolean'=> true,
        ];
        $fields = ['number'];
        $this->assertTrue($this->object->validate($data, $fields));
    }
    
    /**
     * @expectedException CTIMT\MyOrm\Exception\Visitor\DataType\InvalidDataTypeException
     * @expectedExceptionCode 422
     * @expectedExceptionMessage text is expected to be a number
     */
    
    public function testValidateFailure()
    {
        $data  = [
            'number'=>1,
            'text'=>'someText',
            'boolean'=> true,
        ];
        $fields = ['number','text'];
        $this->assertTrue($this->object->validate($data, $fields));
    }
    
    public function testUpdateSuccess()
    {
        $entity = $this->getMockBuilder('\CTIMT\MyOrm\Entity\HasNumericFieldsInterface')->getMock();
        $entity->expects($this->once())->method('getNumericFields')->willReturn([]);
        $model = $this->getMockBuilder('\CTIMT\MyOrm\Model\Model')->disableOriginalConstructor()->getMock();
        $model->expects($this->once())->method('getEntity')->willReturn($entity);
        $model->expects($this->once())->method('getData')->willReturn([]);
        $this->object->setEventNames(['test'])->update($model, 'test');
    }
    
    public function testUpdateInvalidEventName()
    {
        $entity = $this->getMockBuilder('\CTIMT\MyOrm\Entity\HasNumericFieldsInterface')->getMock();
        $entity->expects($this->never())->method('getNumericFields')->willReturn([]);
        $model = $this->getMockBuilder('\CTIMT\MyOrm\Model\Model')->disableOriginalConstructor()->getMock();
        $model->expects($this->never())->method('getEntity')->willReturn($entity);
        $model->expects($this->never())->method('getData')->willReturn([]);
        $this->object->setEventNames(['testNotMe'])->update($model, 'test');
    }
}