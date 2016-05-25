<?php
/*
 * Copyright 2015 Coe-Truman International.
 */
namespace CTIMT\MyOrm\Entity;

/**
 * A static value is a set value that will never be changed.
 *
 * @author David
 */
interface HasStaticValuesInterface
{

    public function getStaticValues();
}
