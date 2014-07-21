<?php

class RulesTableSeeder extends Seeder
{

    protected $split = [
        [
            'description' => 'Split Description One',
            'category_id' => 1,
            'stream_id'   => 1,
            'percentage'  => 35
        ],
        [
            'description' => 'Split Description Two',
            'category_id' => 2,
            'stream_id'   => 1,
            'percentage'  => 35
        ],
        [
            'description' => 'Split Description three',
            'category_id' => 53,
            'stream_id'   => 3,
            'percentage'  => 30
        ]
    ];

    protected $conditions = [
        [
            'filter' => 'payee',
            'match'  => 'contains',
            'value'  => 'Lul Ticket Machine'
        ],
        [
            'filter' => 'payee',
            'match'  => 'contains',
            'value'  => 'o2'
        ]
    ];

    public function run()
    {
        foreach ($this->getRules() as $rule) {
            Rule::create($rule);
        }
    }

    private function getRules()
    {
        return [
            [
                'title'         => 'Split TFL and O2',
                'conditionJson' => json_encode($this->conditions),
                'conditionType' => 'any',
                'to_payee'      => '',
                'to_category'   => '',
                'to_stream'     => '',
                'to_description' => '',
                'splitJson'      => json_encode($this->split),
            ],
            [
                'title'         => 'Match SINFONIETTA PRODT',
                'conditionJson' => json_encode([
                    [
                        'filter' => 'payee',
                        'match'  => 'contains',
                        'value'  => 'SINFONIETTA PRODT'
                    ]
                ]),
                'conditionType' => 'any',
                'to_payee'      => 'London Sinfonietta',
                'to_category'    => '',
                'to_stream'      => '',
                'to_description' => '',
                'splitJson'      => json_encode($this->split),
            ],

        ];
    }
}