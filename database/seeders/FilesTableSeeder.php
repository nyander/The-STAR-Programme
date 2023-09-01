<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::create([
            'id' => 1,
            'name' => '1692630549_Terms and Conditions.pdf',
            'path' => '/storage/uploads/1692630549_Terms and Conditions.pdf',
            'mime_type' => 'application/pdf',
            'type' => 'terms',
            'created_at' => '2023-08-21 15:09:09',
            'updated_at' => '2023-08-21 15:09:09',
        ]);
    }
}
