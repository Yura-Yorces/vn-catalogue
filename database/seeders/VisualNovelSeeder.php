<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisualNovel;
use Illuminate\Support\Str;

class VisualNovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $novels = [
            [
                'title' => 'Tsukihime',
                'developer' => 'Type-Moon',
                'publisher' => 'Type-Moon',
                'release_date' => '2000-12-28',
                'description' => 'Tsukihime is a visual novel developed by Type-Moon. It follows the story of Shiki Tohno, a young man who gains the ability to see the "death lines" of objects and people after surviving a near-fatal accident. The game explores themes of supernatural abilities, vampires, and the consequences of one\'s actions.',
            ],
            [
                'title' => 'Fate/stay night',
                'developer' => 'Type-Moon',
                'publisher' => 'Type-Moon',
                'release_date' => '2004-01-30',
                'description' => 'Fate/stay night is a visual novel developed by Type-Moon. It tells the story of a secret magical tournament called the Holy Grail War, where mages summon heroic spirits to fight for the chance to have their wishes granted. The game features multiple story routes and explores themes of heroism, morality, and the consequences of one\'s choices.',
            ],
        ];

        foreach ($novels as $novel) {
            $novel['slug'] = Str::slug($novel['title']);
            $novel['cover_image'] = $novel['cover_image'] = 'https://placehold.co/300x400/1f2937/60a5fa?text=' . urlencode($novel['title']);

            VisualNovel::create($novel);
        }
    }
}
