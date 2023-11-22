<?php

namespace App\Charts;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PerformanceProfileChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(User $client): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $performanceProfiles = $client->performanceProfile;
        $sessionLabels = $performanceProfiles->pluck('session')->toArray();
        $categoryData = [];

        foreach ($performanceProfiles as $profile) {
            foreach ($profile->answers as $answer) {
                if ($answer->question->performanceCategory && $answer->question->performanceCategory->category) {
                    $questionCategory = $answer->question->performanceCategory->category;
                    $answerValue = $answer->answers;
                    $session = $profile->session;

                    if (!isset($categoryData[$questionCategory])) {
                        $categoryData[$questionCategory] = [
                            'sessions' => [],
                        ];
                    }

                    if (!isset($categoryData[$questionCategory]['sessions'][$session])) {
                        $categoryData[$questionCategory]['sessions'][$session] = [
                            'answers' => [],
                            'count' => 0,
                        ];
                    }

                    $categoryData[$questionCategory]['sessions'][$session]['answers'][] = $answerValue;
                    $categoryData[$questionCategory]['sessions'][$session]['count']++;
                }
            }
        }

        $lineChart = $this->chart->lineChart()
            ->setTitle('Average Answers per Session')
            ->setXAxis($sessionLabels);

        foreach ($categoryData as $category => $sessions) {
            $data = [];

            foreach ($sessions['sessions'] as $session) {
                
                $average = round(array_sum($session['answers']) / $session['count'], 1);
                $data[] = $average;
            }
            $lineChart->addData($category, $data);
        }

        $lineChart->setHeight(375);

        return $lineChart;

    }
}
