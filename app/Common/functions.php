<?php
use Illuminate\Support\Facades\DB;

function test ()
{
    return 123;
}

//得到查询的慢日志
function getQuerySlow ($sql)
{
    \DB::connection()->enableQueryLog();

    // 执行你的sql
    $sql =   $sql;

    // 获取查询日志
    $queries = \DB::getQueryLog();

    // 即可查看执行的sql，传入的参数等等
    dd($queries);
}