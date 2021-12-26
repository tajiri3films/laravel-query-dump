# laravel-query-dump
DB Query Dump for Laravel.

notice: `@dev-master`


## Install

```shell
composer require --dev threefilms/laravel-query-dump
```


## Usage

```php
<?php

use ThreeFilms\LaravelQueryDump\QueryDump;
use Illuminate\Support\Facades\DB;

// [1/2] enable QueryLog
QueryDump::enableQueryLog();

DB::table('posts')->where('author_id', '=', 12)->limit(10);

// [2/2] Query Dump
QueryDump::dd();
```

### Result
```sql
 select
  `*`
from
  `posts`
where
  `author_id` = 12
limit 10
```


## Short Hand Helper

```php
<?php

use Illuminate\Support\Facades\DB;

// [1/2] enable QueryLog
qd_enable();

DB::table('posts')->where('author_id', '=', 12)->limit(10);

// [2/2] Query Dump
qd_dd();
```
