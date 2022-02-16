<?php
/**
 * Created by PhpStorm.
 * User: deep
 * Date: 12/22/2015
 * Time: 12:54 PM
 */
interface Responder
{
    public function onError($error);
    public function onSuccess($status,$msg,$response);
}
