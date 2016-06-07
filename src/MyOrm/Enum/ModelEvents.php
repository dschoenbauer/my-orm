<?php namespace CTIMT\MyOrm\Enum;

/**
 * Description of ModelEvents
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class ModelEvents
{
    
    const TRAMSACTION_START = 'transaction_start';
    const TRAMSACTION_COMPLETE = 'transaction_commit';
    const ERROR = 'transaction_rollBack';

    const VALIDATE = 'validate';
    const LAYOUT_ENTITY_APPLIED = "layoutEntity";
    const LAYOUT_COLLECTION_APPLIED = "layoutCollectionApplied";
    const PRIMARY_DATA_PULLED = "primaryDataPulled";

}
