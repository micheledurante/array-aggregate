<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class ArrayAggregateSingleTest extends TestCase
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
                    ['id' => 1, 'name' => 'foo']
                ],
                [
                    ['id' => 1, 'name' => 'foo']
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
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => '1', 'name' => 'bar']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => '1', 'name' => 'bar']
                ]
            ]
        ];
    }

    /**
     * Not working for unordered rows.
     *
     * @return array
     */
    public function unorderedDatasetsCannotBeGrouped(): array
    {
        return [
            'Unordered set 1' => [
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 1, 'name' => 'baz']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 1, 'name' => 'baz']
                ]
            ],
            'Unordered set 2' => [
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 3, 'name' => 'baz'],
                    ['id' => 2, 'name' => 'foobar'],
                    ['id' => 1, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 3, 'name' => 'baz'],
                    ['id' => 2, 'name' => 'foobar'],
                    ['id' => 1, 'name' => 'barbaz']
                ]
            ],
            'Unordered set 3' => [
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 5, 'name' => 'bar'],
                    ['id' => 3, 'name' => 'baz'],
                    ['id' => 2, 'name' => 'foobar'],
                    ['id' => 4, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 5, 'name' => 'bar'],
                    ['id' => 3, 'name' => 'baz'],
                    ['id' => 2, 'name' => 'foobar'],
                    ['id' => 4, 'name' => 'barbaz']
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
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 1, 'name' => 'bar'],
                    ['id' => 2, 'name' => 'baz'],
                    ['id' => 3, 'name' => 'foobar'],
                    ['id' => 4, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'baz'],
                    ['id' => 3, 'name' => 'foobar'],
                    ['id' => 4, 'name' => 'barbaz']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function orderedGroupOfRowsInTheMiddle(): array
    {
        return [
            'Ordered set in the middle' => [
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 2, 'name' => 'baz'],
                    ['id' => 3, 'name' => 'foobar'],
                    ['id' => 4, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 3, 'name' => 'foobar'],
                    ['id' => 4, 'name' => 'barbaz']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function orderedGroupOfRowsAtTheEnd(): array
    {
        return [
            'Ordered set at the end' => [
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 3, 'name' => 'baz'],
                    ['id' => 4, 'name' => 'foobar'],
                    ['id' => 4, 'name' => 'barbaz']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 3, 'name' => 'baz'],
                    ['id' => 4, 'name' => 'foobar']
                ]
            ]
        ];
    }

    /**
     * It must be possible to group rows by a 1 column.
     *
     * @test
     * @covers       \array_aggregate
     * @dataProvider anEmptyArrayReturnsEmpty
     * @dataProvider singleItemArrayIsUnchanged
     * @dataProvider columnsAreCheckedStrictly
     * @dataProvider unorderedDatasetsCannotBeGrouped
     * @dataProvider orderedGroupOfRowsAtTheBeginning
     * @dataProvider orderedGroupOfRowsInTheMiddle
     * @dataProvider orderedGroupOfRowsAtTheEnd
     * @param array $testData
     * @param array $expectedOutput
     */
    public function testArrayAggregateOutput(array $testData, array $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, array_aggregate(array('id'), $testData));
    }
}
