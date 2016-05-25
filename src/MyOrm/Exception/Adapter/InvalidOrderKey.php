<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CTIMT\MyOrm\Exception\Adapter;

use CTIMT\MyOrm\Enum\ErrorMessages;
use CTIMT\MyOrm\Exception\Http\UnprocessableEntity;

/**
 * Description of InvalidOrderKey
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class InvalidOrderKey extends UnprocessableEntity
{

    public function __construct($invalidKeys, $validKeys)
    {
        $invalidKeys = !is_array($invalidKeys) ? [$invalidKeys] : $invalidKeys;
        parent::__construct(sprintf(ErrorMessages::ADAPTER_ORDER_INVALID_KEYS, implode(',', $invalidKeys), implode(',', $validKeys)));
    }
}
