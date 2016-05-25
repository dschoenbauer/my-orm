<?php namespace CTIMT\MyOrm\Enum;

/**
 * Description of ModelExecutionPriority
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ModelExecutionPriority
{

    const PRIOR_TO_ACTION = -1000;
    const ACTION = 0;
    const AFTER_ACTION = 1000;

}
