<?php
/**
 * Benchmark tests for array_aggregate().
 */
require_once './src/array_aggregate.php';

$rows = 1e6;
echo ($rows / 1e6) . 'M rows' . PHP_EOL;

function run(int $total, int $i): void
{
    // Generate test rows
    $rows = [];
    array_push($rows, array(
        'id' => 1,
        'group_id' => rand(1, 20),
        'city_id' => rand(1, 20),
        'name' => substr(str_shuffle(md5(time())),0, rand(4, 12))
    ));

    for ($ii = 1; $ii <= $total; $ii++) {
        array_push($rows, array(
            'id' => $ii + 1,
            'group_id' => (rand(1, 20) % 3) === 0 ?
                $rows[$ii - 1]['group_id'] + 1 :
                $rows[$ii - 1]['group_id'],
            'city_id' => (rand(1, 20) % 5) === 0 ?
                $rows[$ii - 1]['city_id'] + 1 :
                $rows[$ii - 1]['city_id'],
            'name' => substr(str_shuffle(md5(time())),0, rand(4, 12))
        ));
    }

    // Start taking time
    $time = -microtime(true);

    array_aggregate(array('group_id', 'city_id'), $rows, function (array $group): array {
        return array(
            'ids' => implode(',',array_column($group, 'id')),
            'group_id' => $group[0]['group_id'],
            'city_id' => $group[0]['city_id'],
            'names' => implode(',', array_column($group, 'name'))
        );
    });

    $time += microtime(true);
    echo "T$i $time" . "s" . PHP_EOL;
}

for ($i = 0; $i < 5; $i++) {
    run($rows, $i + 1);
}
