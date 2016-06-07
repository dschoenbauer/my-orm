<?php namespace CTIMT\MyOrm\Model;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-06 at 19:58:53.
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Model
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {

        $entity = $this->getMock('CTIMT\MyOrm\Entity\AbstractEntity');
        $query = $this->getMockBuilder('CTIMT\MyOrm\Adapter\Query')->disableOriginalConstructor()->getMock();
        $this->object = new Model($entity, $query);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::create
     * @todo   Implement testCreate().
     */
    public function testCreate()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::fetch
     * @todo   Implement testFetch().
     */
    public function testFetch()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::fetchAll
     * @todo   Implement testFetchAll().
     */
    public function testFetchAll()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::update
     * @todo   Implement testUpdate().
     */
    public function testUpdate()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::delete
     * @todo   Implement testDelete().
     */
    public function testDelete()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::setEntity
     * @todo   Implement testSetEntity().
     */
    public function testSetEntity()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::getEntity
     * @todo   Implement testGetEntity().
     */
    public function testGetEntity()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::getQuery
     * @todo   Implement testGetQuery().
     */
    public function testGetQuery()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::setQuery
     * @todo   Implement testSetQuery().
     */
    public function testSetQuery()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::getData
     * @todo   Implement testGetData().
     */
    public function testGetData()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::setData
     * @todo   Implement testSetData().
     */
    public function testSetData()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::getId
     * @todo   Implement testGetId().
     */
    public function testGetId()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::setId
     * @todo   Implement testSetId().
     */
    public function testSetId()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::getActions
     * @todo   Implement testGetActions().
     */
    public function testGetActions()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::setActions
     * @todo   Implement testSetActions().
     */
    public function testSetActions()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::accept
     * @todo   Implement testAccept().
     */
    public function testAccept()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::setAttribute
     * @todo   Implement testSetAttribute().
     */
    public function testSetAttribute()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::getAttribute
     * @todo   Implement testGetAttribute().
     */
    public function testGetAttribute()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::getAttributeObject
     * @todo   Implement testGetAttributeObject().
     */
    public function testGetAttributeObject()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::attach
     * @todo   Implement testAttach().
     */
    public function testAttach()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::detach
     * @todo   Implement testDetach().
     */
    public function testDetach()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers CTIMT\MyOrm\Model\Model::notify
     * @todo   Implement testNotify().
     */
    public function testNotify()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
