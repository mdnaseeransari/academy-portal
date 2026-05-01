<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'Class 9-A',
            'Class 9-B',
            'Class 10-A',
            'Class 10-B',
        ];

        foreach ($classes as $className) {
            AcademicClass::create([
                'name' => $className,
            ]);
        }
    }
}
