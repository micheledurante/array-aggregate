<?php
/**
 * Group rows of an array that have the same value for the provided column(s). If no compute function is provided, the
 * first item of the group will be returned.
 *
 * array_aggregate() expects the rows to be ordered on the columns used for the grouping.
 *
 * @param array $columns
 * @param array $rows
 * @param callable|null $compute_func
 * @return array
 */

function array_aggregate(array $columns, array $rows, callable $compute_func = null): array
{
    if (empty($rows)) return [];

    if (empty($columns)) return $rows;

    $aggregates = [];
    $group[] = $rows[0]; // initialize group

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
            $aggregates[] = $compute_func !== null ? $compute_func($group) : $group[0];
            $group = [];
        }

        $group[] = $rows[$i];
    }

    $aggregates[] = $compute_func !== null ? $compute_func($group) : $group[0]; // grab whatever is left
    return $aggregates;
}
