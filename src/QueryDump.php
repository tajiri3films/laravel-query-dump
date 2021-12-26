<?php

namespace ThreeFilms\LaravelQueryDump;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use Doctrine\SqlFormatter\SqlFormatter;
use Doctrine\SqlFormatter\NullHighlighter;
use Symfony\Component\VarDumper\VarDumper;

use const PHP_SAPI;

class QueryDump
{
    /**
     * Enable the query log on the connection.
     */
    public static function enableQueryLog(): void
    {
        DB::enableQueryLog();
    }

    /**
     * Disable the query log on the connection.
     */
    public static function disableQueryLog(): void
    {
        DB::disableQueryLog();
    }

    /**
     * Get the connection query log.
     *
     * @return array
     */
    public static function getQueryLog(): array
    {
        return DB::getQueryLog();
    }

    /**
     * SQL Dump
     *
     * @param array $query_log_result
     */
    public static function dd(): void
    {
        $query_log_result = self::getQueryLog();

        $highlighter = (PHP_SAPI === 'cli' ? new NullHighlighter() : null);
        $result = [];
        foreach ($query_log_result as $ar_query_log) {
            if (! isset($ar_query_log['query']) && ! isset($ar_query_log['bindings'])) {
                continue;
            }
            $sql = $ar_query_log['query'];
            $bindings = $ar_query_log['bindings'];

            foreach ($bindings as $binding) {
                if (is_string($binding)) {
                    $binding = "'{$binding}'";
                } elseif (is_bool($binding)) {
                    $binding = $binding ? '1' : '0';
                } elseif (is_int($binding)) {
                    $binding = (string)$binding;
                } elseif ($binding === null) {
                    $binding = 'NULL';
                } elseif ($binding instanceof Carbon) {
                    $binding = "'{$binding->toDateTimeString()}'";
                } elseif ($binding instanceof DateTime) {
                    $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                }

                $sql = preg_replace('/\\?/', $binding, $sql, 1);
            }
            $result[] = (new SqlFormatter($highlighter))->format($sql);
        }

        if (PHP_SAPI === 'cli') {
            VarDumper::dump(implode("\n", $result));
        } else {
            echo implode("\n", $result);
        }
        exit(1);
    }
}
