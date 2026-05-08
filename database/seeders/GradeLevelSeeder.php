<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['name' => 'PAUD', 'description' => 'Pendidikan Anak Usia Dini'],
            ['name' => 'SD', 'description' => 'Sekolah Dasar'],
            ['name' => 'SMP', 'description' => 'Sekolah Menengah Pertama'],
            ['name' => 'SMA', 'description' => 'Sekolah Menengah Atas'],
        ];

        foreach ($levels as $level) {
            $gl = \App\Models\GradeLevel::updateOrCreate(['name' => $level['name']], $level);
            
            // Sinkronkan data di tabel subjects
            // Jika kolom 'level' (string) sama dengan nama jenjang, isi 'grade_level_id'
            \App\Models\Subject::where('level', $level['name'])
                ->update(['grade_level_id' => $gl->id]);
        }
    }
}
