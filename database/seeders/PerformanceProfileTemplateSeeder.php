<?php

namespace Database\Seeders;

use App\Models\PerformanceProfileTemplate;
use App\Models\PerformanceTemplateQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformanceProfileTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('performance_categories')->insert(['category' => "Willpower", 'colour' => 'bcff8c']);
        DB::table('performance_categories')->insert(['category' => "Conviction", 'colour' => 'bcff8c']);
        DB::table('performance_categories')->insert(['category' => "Prescence", 'colour' => 'bcff8c']);
        DB::table('performance_categories')->insert(['category' => "Composure", 'colour' => 'bcff8c']);
        DB::table('performance_categories')->insert(['category' => "Respect", 'colour' => 'bcff8c']);
        // Create a Performance Profile
        $performanceProfileTemplate = PerformanceProfileTemplate::create([
            'user_id' => 1, // Replace with the desired user ID
            'title' => 'S.T.A.R Performance Profile',
            'description' => 'Default STAR Performance Profile',
            'default_value' => true,
        ]);

        // Create Performance Profile Questions
        $questions = [
            [
                'title' => 'Resilience',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'Ability to cope with adversity',
                'type' => 'select',
                'performance_categories' => 1, 
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 1,
            ],
            [
                'title' => 'Instrinsic',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'Knowing the internal factors that drive you towards your goals',
                'type' => 'select',
                'performance_categories' => 1,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 2,
            ],
            [
                'title' => 'Confidence',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'The belief in one’s abilities to perform well',
                'type' => 'select',
                'performance_categories' => 2,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 3,
            ],
            [
                'title' => 'Discipline',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'The ability to control your actions & stay consistent with your standards',
                'type' => 'select',
                'performance_categories' => 2,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 4,
            ],
            [
                'title' => 'Mindfulness',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'The ability to stay in the present moment',
                'type' => 'select',
                'performance_categories' => 3,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 5,
            ],
            [
                'title' => 'Engagement',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'Being fully invested & actively participating with the task at hand',
                'type' => 'select',
                'performance_categories' => 3,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 6,
            ],
            [
                'title' => 'SelfAwareness',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'Understating your internal state, thoughts & behaviours',
                'type' => 'select',
                'performance_categories' => 4,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 7,
            ],
            [
                'title' => 'Focus',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'The ability to block out distractions & maintain concentration',
                'type' => 'select',
                'performance_categories' => 4,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 8,
            ],
            [
                'title' => 'SocialSupport',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'The quality of your relationships within your sporting circle',
                'type' => 'select',
                'performance_categories' => 5,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 9,
            ],
            [
                'title' => 'Communication',
                'performance_template_id' => $performanceProfileTemplate->id,
                'text' => 'The ability to convey your thoughts & receive messages effectively',
                'type' => 'select',
                'performance_categories' => 5,
                'options' => json_encode(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
                'required' => true,
                'order' => 10,
            ],
        ];

        foreach ($questions as $question) {
            PerformanceTemplateQuestion::create($question); // Updated table name
        }
    }

}
