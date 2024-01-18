<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            'ar' => ['قسم مخ وأعصاب', 'قسم الجراحة', 'قسم الأطفال', 'قسم النساء والتوليد', 'قسم العظام'],
            'en' => ['Neurology', 'Surgery Department', 'Pediatrics', 'Obstetrics and Gynecology', 'Orthopedics']
        ];

        foreach ($sections['ar'] as $loop => $section) {
            $id  = DB::table('sections')
            ->insertGetId([
                "description" => fake()->sentence("20"),
                'created_at' => now(),
            ]);
            foreach (['ar' , 'en'] as $locale) {
                DB::table('section_translations')
                ->insert([
                    "section_id" => $id,
                    'name' => $sections[$locale][$loop],
                    'locale' => $locale,
                ]);
            }

        }


    }
}
