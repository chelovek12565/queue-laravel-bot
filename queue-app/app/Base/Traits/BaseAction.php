<?php


namespace App\Base\Traits;


use LogicException;

abstract class BaseAction
{
    public static function call()
    {
        $action = app()->make(static::class);

        if (method_exists($action, 'handle')) {
            return $action->handle(...func_get_args());
        }

        throw new LogicException('Cannot call handle() on ' . static::class);
    }
}
