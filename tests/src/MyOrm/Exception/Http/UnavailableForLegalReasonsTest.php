<?php namespace CTIMT\MyOrm\Exception\Http;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-05-26 at 22:48:22.
 */
class UnavailableForLegalReasonsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \CTIMT\MyOrm\Exception\Http\UnavailableForLegalReasons
     * @expectedExceptionCode 451
     * @expectedExceptionMessage someMessage
     */
    public function testUnavailableForLegalReasons()
    {
        throw New UnavailableForLegalReasons('someMessage');
    }
}
