<?php

namespace Threefilms\LaravelQueryDump\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Threefilms\LaravelQueryDump\QueryDump
 */
class QueryDump extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'querydump';
    }

}
