<?php namespace CTIMT\MyOrm\Exception\DataProvider;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-05-26 at 22:48:27.
 */
class MissingParameterExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedExceptionMessage You need to provide field: one
     * @expectedException CTIMT\MyOrm\Exception\DataProvider\MissingParameterException
     */
    public function testThrowWIthOneMissing()
    {
        throw new MissingParameterException(['one']);
    }

    /**
     * @expectedExceptionMessage You need to provide one of the following fields: one, two
     * @expectedException CTIMT\MyOrm\Exception\DataProvider\MissingParameterException
     */
    public function testThrowWIthManyMissing()
    {
        throw new MissingParameterException(['one','two']);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }
}