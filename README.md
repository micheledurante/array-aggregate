# array_aggregate

[![Build Status](https://travis-ci.org/micheledurante/array-aggregate.svg?branch=master)](https://travis-ci.org/micheledurante/array-aggregate) [![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

A PHP, SQL-like stream aggregate function to group a set of rows by any number of columns. You can also define how to 
compute groups. Rows are expected to be already sorted on the columns used to aggregate results.

```php
function array_aggregate(array $columns, array $rows, callable $compute_func = null): array
```

The order in which columns are given to the function does not affect the output. Columns must comparable with the `===` 
operator.

Inspired by Craig Freedman's SQL articles on MS dev blog 
https://blogs.msdn.microsoft.com/craigfr/2006/09/13/stream-aggregate.

## Usage

```php
$rows = [
    0 => [
        'store_id' => 1,
        'manager_id' => 2,
        'name' => 'Alice'
    ],
    1 => [
        'store_id' => 2,
        'manager_id' => 3,
        'name' => 'Bob'
    ],
    2 => [
        'store_id' => 2,
        'manager_id' => 3,
        'name' => 'Eve'
    ],
    3 => [
        'store_id' => 2,
        'manager_id' => 4,
        'name' => 'Foobar'
    ]
];

$groups = array_aggregate(array('store_id', 'manager_id'), $rows, function (array $group): array {
    return [
        'store_id' => $group[0]['store_id'],
        'manager_id' => $group[0]['manager_id'],
        'people' => implode(',', array_column($group, 'name'))
    ];
});

var_export($groups);
```

Results in:
```php
/*
array (
    0 => array (
        'store_id' => 1,
        'manager_id' => 2,
        'people' => 'Alice'
    ),
    1 => array (
        'store_id' => 2,
        'manager_id' => 3,
        'people' => 'Bob,Eve'
    ),
    2 => array (
        'store_id' => 2,
        'manager_id' => 4,
        'people' => 'Foobar'
    )
)
*/
```

## Similar Projects

### `array_group_by()`
By [jakezatecky](https://github.com/jakezatecky/array_group_by). Main difference is that 
`array_aggregate()` won't change the structure of the array by creating new keys/nested groups. It behaves like the SQL 
`GROUP BY` clause, which returns the aggregates of the input rows. Both functions can work with multiple keys. 
`array_aggregate()` doesn't allow a callable to match columns.
