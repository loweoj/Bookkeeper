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
            'field' => 'payee',
            'match'  => 'contains',
            'value'  => 'Lul Ticket Machine'
        ],
        [
            'field' => 'payee',
            'match'  => 'contains',
            'value'  => 'O2'
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
                'title'         => 'Match TESCO',
                'conditionJson' => json_encode([
                    [
                        'field' => 'payee',
                        'match'  => 'contains',
                        'value'  => 'TESCO'
                    ]
                ]),
                'conditionType' => 'any',
                'to_payee'      => 'Tesco Food - CHANGED BY TEST RULE',
                'to_category'    => '',
                'to_stream'      => '',
                'to_description' => '',
                'splitJson'      => json_encode($this->split),
            ],
            [
                'title'         => 'Match O2',
                'conditionJson' => json_encode([
                    [
                        'field' => 'payee',
                        'match'  => 'contains',
                        'value'  => 'O2'
                    ]
                ]),
                'conditionType' => 'any',
                'to_payee'      => 'O2 Mobile - CHANGED BY TEST RULE',
                'to_category'    => '',
                'to_stream'      => '',
                'to_description' => '',
                'splitJson'      => json_encode($this->split),
            ],
            [
                'title'         => 'Match SINFONIETTA',
                'conditionJson' => json_encode([
                    [
                        'field' => 'payee',
                        'match'  => 'contains',
                        'value'  => 'SINFONIETTA'
                    ]
                ]),
                'conditionType' => 'any',
                'to_payee'      => 'London Sinfonietta - CHANGED BY TEST RULE',
                'to_category'    => '',
                'to_stream'      => '',
                'to_description' => '',
                'splitJson'      => '',
            ],

        ];
    }
}