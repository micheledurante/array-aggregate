<?php
/**
 * Groups sorted rows of an array with a stream aggregate function into a single row for each group of rows that have
 * the same value for the provided column. If no user function is provided, the first matching item in a group will be
 * returned.
 *
 * Note that array_group_by() expects the array rows to be sorted on the column to be used for grouping and columns are
 * checked strictly.
 *
 * @param mixed $column
 * @param array $array
 * @param callable|null $group_func
 * @return array
 */

function array_group_by($column, array $array, callable $group_func = null): array
{
    if (empty($array)) return [];

    $groups = [];
    $bucket[] = $array[0]; // initialize bucket

    for ($i = 1, $max = count($array); $i < $max; $i++) {
        if ($array[$i][$column] === $array[$i - 1][$column]) {
            $bucket[] = $array[$i];
            continue;
        } else {
            $groups[] = $group_func !== null ? $group_func($bucket) : $bucket[0];
            $bucket = [];
            $bucket[] = $array[$i];
        }
    }

    $groups[] = $group_func !== null ? $group_func($bucket) : $bucket[0];
    return $groups;
}
