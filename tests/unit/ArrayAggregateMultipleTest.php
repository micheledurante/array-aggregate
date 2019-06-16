<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class ArrayAggregateMultipleTest extends TestCase
{
    /**
     * For empty inputs the function should do nothing.
     *
     * @return array
     */
    public function anEmptyArrayReturnsEmpty(): array
    {
        return [
            'An empty array returns empty' => [
                [],
                []
            ]
        ];
    }

    /**
     * Single-element arrays cannot be grouped.
     *
     * @return array
     */
    public function singleItemArrayIsUnchanged(): array
    {
        return [
            'Single-item array is unchanged' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo']
                ]
            ]
        ];
    }

    /**
     * Types are respected when checking for rows equality.
     *
     * @return array
     */
    public function columnsAreCheckedStrictly(): array
    {
        return [
            'Columns are checked strictly' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => '1', 's_id' => 1, 'name' => 'bar']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => '1', 's_id' => 1, 'name' => 'bar']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function orderedGroupOfRowsAtTheBeginning(): array
    {
        return [
            'Ordered set at the beginning' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 1, 's_id' => 1, 'name' => 'bar'],
                    ['id' => 2, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 3, 's_id' => 2, 'name' => 'foobar'],
                    ['id' => 4, 's_id' => 3, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 3, 's_id' => 2, 'name' => 'foobar'],
                    ['id' => 4, 's_id' => 3, 'name' => 'barbaz']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function uniqueGroups(): array
    {
        return [
            'Unique groups #1' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar']
                ]
            ],
            'Unique groups #2' => [
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar'],
                    ['id' => 3, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 4, 's_id' => 3, 'name' => 'foobar'],
                    ['id' => 5, 's_id' => 3, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 's_id' => 1, 'name' => 'foo'],
                    ['id' => 2, 's_id' => 1, 'name' => 'bar'],
                    ['id' => 3, 's_id' => 2, 'name' => 'baz'],
                    ['id' => 4, 's_id' => 3, 'name' => 'foobar'],
                    ['id' => 5, 's_id' => 3, 'name' => 'barbaz']
                ]
            ]
        ];
    }

    /**
     * It must be possible to group rows by more than 1 column.
     *
     * @test
     * @covers       \array_aggregate
     * @dataProvider anEmptyArrayReturnsEmpty
     * @dataProvider singleItemArrayIsUnchanged
     * @dataProvider columnsAreCheckedStrictly
     * @dataProvider orderedGroupOfRowsAtTheBeginning
     * @dataProvider uniqueGroups
     * @param array $testData
     * @param array $expectedOutput
     */
    public function testArrayAggregateByMultiple(array $testData, array $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, array_aggregate(array('id', 's_id'), $testData));
    }

    /**
     * The order in which group parameters are given to the function must not affect the output.
     *
     * @test
     * @covers       \array_aggregate
     * @dataProvider anEmptyArrayReturnsEmpty
     * @dataProvider singleItemArrayIsUnchanged
     * @dataProvider columnsAreCheckedStrictly
     * @dataProvider orderedGroupOfRowsAtTheBeginning
     * @dataProvider uniqueGroups
     * @param array $testData
     * @param array $expectedOutput
     */
    public function testArrayAggregateByMultipleSwitchedOrder(array $testData, array $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, array_aggregate(array('s_id', 'id'), $testData));
    }
}
