<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CTIMT\MyOrm\Visitor\Command\Format;

/**
 * Description of Null
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class Null implements FormatInterface
{
    public function format($value)
    {
        return null;
    }

    public function isRelevent($entity, $key, $value)
    {
        return ($value == '' || $value === null || $value === 'null') && !is_bool($value);
    }
}
