<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class ArrayGroupBySingleTest extends TestCase
{
    /**
     * For empty inputs the function should do nothing.
     *
     * @return array
     */
    public function anEmptyArrayReturnsEmpty(): array
    {
        return [
            'An empty array returns empty' => [[], []]
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
                    0 => ['id' => 1, 'name' => 'foo']
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
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => '1', 'name' => 'bar']
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
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => 2, 'name' => 'bar'],
                    2 => ['id' => 1, 'name' => 'baz']
                ],
                [
                    ['id' => 1, 'name' => 'foo'],
                    ['id' => 2, 'name' => 'bar'],
                    ['id' => 1, 'name' => 'baz']
                ]
            ],
            'Unordered set 2' => [
                [
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => 2, 'name' => 'bar'],
                    2 => ['id' => 3, 'name' => 'baz'],
                    3 => ['id' => 2, 'name' => 'foobar'],
                    4 => ['id' => 1, 'name' => 'barbaz']
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
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => 5, 'name' => 'bar'],
                    2 => ['id' => 3, 'name' => 'baz'],
                    3 => ['id' => 2, 'name' => 'foobar'],
                    4 => ['id' => 4, 'name' => 'barbaz']
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
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => 1, 'name' => 'bar'],
                    2 => ['id' => 2, 'name' => 'baz'],
                    3 => ['id' => 3, 'name' => 'foobar'],
                    4 => ['id' => 4, 'name' => 'barbaz']
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
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => 2, 'name' => 'bar'],
                    2 => ['id' => 2, 'name' => 'baz'],
                    3 => ['id' => 3, 'name' => 'foobar'],
                    4 => ['id' => 4, 'name' => 'barbaz']
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
                    0 => ['id' => 1, 'name' => 'foo'],
                    1 => ['id' => 2, 'name' => 'bar'],
                    2 => ['id' => 3, 'name' => 'baz'],
                    3 => ['id' => 4, 'name' => 'foobar'],
                    4 => ['id' => 4, 'name' => 'barbaz']
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
    public function testArrayGroupByOutput(array $testData, array $expectedOutput)
    {
        $this->assertEquals($expectedOutput, array_group_by(array('id'), $testData));
    }
}
