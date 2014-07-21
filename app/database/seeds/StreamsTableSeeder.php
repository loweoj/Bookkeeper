<?php

class StreamsTableSeeder extends Seeder
{

    public function run()
    {
        $streams = [
            [
                'name' => 'Music',
                'description' => 'All music-related income and expenses.'
            ],
            [
                'name' => 'Web',
                'description' => 'All web-related income and expenses.'
            ],
            [
                'name' => 'Music/Web',
                'description' => 'Relates to both web and music. As such, income/expense could be split between the two streams.'
            ]
        ];

        foreach ($streams as $s) {
            Stream::create($s);
        }
    }

} 