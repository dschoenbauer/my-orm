<?php namespace CTIMT\MyOrm\Exception\Platform;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-05-26 at 22:48:27.
 */
class OverflowExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException OverflowException
     * @expectedExceptionMessage someMessage
     */
    public function testOverflowException()
    {
        throw New OverflowException('someMessage');
    }
}
