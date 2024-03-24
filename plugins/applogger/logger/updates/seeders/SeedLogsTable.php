<?php namespace AppLogger\Logger\Updates\Seeders;

use AppLogger\Logger\Models\Log;
use Seeder;

/**
 * SeedLogsTable
 */
class SeedLogsTable extends Seeder
{
    /**
     * run the database seeds.
     */
    public function run()
    {
        Log::create([
                'datum_prichodu' => '2024-03-24 12:34:56',
                'meno_uzivatela' => 'TestUser',
                'meskanie' => 5
            ]);
        Log::create([
            'datum_prichodu' => '2024-03-24 12:35:56',
            'meno_uzivatela' => 'TestUser2',
            'meskanie' => 10
        ]);
        Log::create([
            'datum_prichodu' => '2024-03-24 14:35:56',
            'meno_uzivatela' => 'TestUser3',
            'meskanie' => 7.10
        ]);
    }
}
