<?php namespace CTIMT\MyOrm\Model;

/**
 * Description of SubjectInterface
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
interface SubjectInterface
{

    function attach(ObserverInterface $observer);

    function detach(ObserverInterface $observer);

    function notify();
}
