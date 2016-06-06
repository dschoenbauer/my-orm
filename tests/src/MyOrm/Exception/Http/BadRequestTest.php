<?php namespace CTIMT\MyOrm\Exception\Http;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-05-26 at 22:48:21.
 */
class BadRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BadRequest
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new BadRequest;
    }

    /**
     * @expectedException CTIMT\MyOrm\Exception\Http\BadRequest
     * @expectedExceptionCode 400
     * @expectedExceptionMessage someMessage
     */
    public function testBadRequest()
    {
        throw new BadRequest('someMessage');
    }
    
    protected function tearDown()
    {
        
    }
}
