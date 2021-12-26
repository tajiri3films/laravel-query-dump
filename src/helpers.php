<?php

use ThreeFilms\LaravelQueryDump\QueryDump;

if (!function_exists('qd_enable')) {
    function qd_enable()
    {
        QueryDump::enableQueryLog();
    }
}

if (!function_exists('qd_dd')) {
    function qd_dd()
    {
        QueryDump::dd();
    }
}
