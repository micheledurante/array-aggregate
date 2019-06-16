<?php
/**
 * Group rows of an array that have the same value for the provided column(s). If no aggregate function is provided,
 * the first matching item of the group will be returned.
 *
 * array_group_by() expects the rows to be ordered on the columns used for the grouping.
 *
 * @param array $columns
 * @param array $rows
 * @param callable|null $aggregate_func
 * @return array
 */

function array_group_by(array $columns, array $rows, callable $aggregate_func = null): array
{
    if (empty($rows)) return [];

    if (empty($columns)) return $rows;

    $groups = [];
    $bucket[] = $rows[0]; // initialize bucket

    for ($i = 1, $max = count($rows); $i < $max; $i++) {
        $match = false;

        foreach ($columns as $column) {
            if ($rows[$i][$column] === $rows[$i - 1][$column]) {
                $match = true;
            } else {
                $match = false;
                break; // all columns must be equal
            }
        }

        if (!$match) {
            $groups[] = $aggregate_func !== null ? $aggregate_func($bucket) : $bucket[0];
            $bucket = [];
        }

        $bucket[] = $rows[$i];
    }

    $groups[] = $aggregate_func !== null ? $aggregate_func($bucket) : $bucket[0]; // empty whatever is left
    return $groups;
}
