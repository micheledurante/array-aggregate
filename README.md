# array_group_by
A PHP, SQL-like function to group a set of rows by any number of columns. 

Rows are expected to be already sorted on the columns needed for grouping. The order in which columns are given to the 
function does not affect the output of grouping. Column values are expected to be comparable by the `===` operator.

## Usage

```php
$people = [
    0 => [
        'store_id' => 1,
        'manager_id' => 2,
        'name' => 'foo'
    ],
    1 => [
        'store_id' => 2,
        'manager_id' => 3,
        'name' => 'bar'
    ],
    2 => [
        'store_id' => 2,
        'manager_id' => 3,
        'name' => 'baz'
    ]
];

$uniqueManagersPerStores = array_group_by(array('store_id', 'manager_id'), $people);
```

Would result in:
```php
var_dump($uniqueManagersPerStores);

/*
array(2) { 
    [0]=> array (2) { 
        ["store_id"]=> int(1) 
        ["manager_id"]=> int(2) 
        ["name"]=> string(3) "foo"
    } 
    [1]=> array(2) { 
        ["store_id"]=> int(2) 
        ["manager_id"]=> int(3) 
        ["name"]=> string(3) "bar" 
    }
}
*/
```

You can additionally apply a function to each group. You can here perform additional operations or calculation on the 
data before it is returned.

```php
$callback = function (array $group): array {
    return [
        // the value is unique for the group
        'store_id' => $group[0]['store_id'],
        // concat the list of names
        'names' => implode(',', array_column($group, 'name')),
        // total of names
        'no_of_names' => count(array_column($group, 'name'))
    ];
};

$stores = array_group_by(array('store_id'), $people, $callback);
```

Would result in:
```php
var_dump($stores);

/*
array(2) { 
    [0]=> array (2) { 
        ["store_id"]=> int(1) 
        ["names"]=> string(3) "foo" 
        ["no_of_people"]=> int(1) 
    } 
    [1]=> array(2) { 
        ["store_id"]=> int(2) 
        ["names"]=> string(7) "bar,baz" 
        ["no_of_names"]=> int(3) 
    }
}
*/
```
