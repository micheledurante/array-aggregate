# array_group_by
A PHP, SQL-like function to group a set of rows by a column. Note that rows are expected to be  sorted on the column 
used for grouping.

## Usage
The function can be used to post-process results coming from a database. For instance:

```php
$people = [
    0 => [
        'store_id' => 1,
        'name' => 'foo'
    ],
    1 => [
        'store_id' => 2,
        'name' => 'bar'
    ],
    2 => [
        'store_id' => 2,
        'name' => 'baz'
    ]
];

$groupedByStore = array_group_by('store_id', $people);
```

Would result in:
```php
var_dump($groupedByStore);

/*
array(2) { 
    [0]=> array (2) { 
        ["store_id"]=> int(1) 
        ["name"]=> string(3) "foo"
    } 
    [1]=> array(2) { 
        ["store_id"]=> int(2) 
        ["name"]=> string(3) "bar" 
    }
}
*/
```

You can additionally apply a function to each group before it is returned, like so:

```php
$callback = function ($group) {
    return [
        // the value is unique for the group
        'store_id' => $group[0]['store_id'],
        // concat the list of names
        'names' => implode(',', array_column($group, 'name'))
    ];
};

$groupedByStore = array_group_by('store_id', $people, $callback);
```

Would result in:
```php
var_dump($groupedByStore);

/*
array(2) { 
    [0]=> array (2) { 
        ["store_id"]=> int(1) 
        ["names"]=> string(3) "foo"
    } 
    [1]=> array(2) { 
        ["store_id"]=> int(2) 
        ["names"]=> string(7) "bar,baz" 
    }
}
*/
```
