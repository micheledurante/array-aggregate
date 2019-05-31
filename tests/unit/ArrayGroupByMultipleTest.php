<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class ArrayGroupByMultipleTest extends TestCase
{
    public function anEmptyArrayReturnsEmpty(): array
    {
        return [
            'An empty array returns empty' => [[], []]
        ];
    }

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

    public function orderedGroupOfRowsAtTheBeginningSingle(): array
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
     * @test
     * @dataProvider anEmptyArrayReturnsEmpty
     * @dataProvider singleItemArrayIsUnchanged
     * @dataProvider columnsAreCheckedStrictly
     * @dataProvider unorderedDatasetsCannotBeGrouped
     * @dataProvider orderedGroupOfRowsAtTheBeginningSingle
     * @dataProvider orderedGroupOfRowsInTheMiddle
     * @dataProvider orderedGroupOfRowsAtTheEnd
     * @param array $testData
     * @param array $expectedOutput
     */
    public function testArrayGroupBySingle(array $testData, array $expectedOutput)
    {
        $this->assertEquals($expectedOutput, array_group_by_multiple(array('id'), $testData));
    }

    /**
     * @test
     * @dataProvider anEmptyArrayReturnsEmpty
     * @dataProvider singleItemArrayIsUnchanged
     * @dataProvider columnsAreCheckedStrictly
     * @dataProvider orderedGroupOfRowsAtTheBeginning
     * @dataProvider uniqueGroups
     * @param array $testData
     * @param array $expectedOutput
     */
    public function testArrayGroupByMultiple(array $testData, array $expectedOutput)
    {
        $this->assertEquals($expectedOutput, array_group_by_multiple(array('id', 's_id'), $testData));
    }
}
