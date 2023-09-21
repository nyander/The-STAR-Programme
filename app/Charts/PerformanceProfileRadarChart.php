<?php

namespace App\Charts;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class PerformanceProfileRadarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(User $client): \ArielMejiaDev\LarapexCharts\RadarChart
    {
        $performanceProfiles = $client->performanceProfile;
        $sessionLabels = $performanceProfiles->pluck('session')->toArray();
        $sessionData = [];

        foreach ($performanceProfiles as $profile) {
            foreach ($profile->answers as $answer) {
                if ($answer->question->performanceCategory && $answer->question->performanceCategory->category) {
                    $questionCategory = $answer->question->performanceCategory->category;
                    $answerValue = $answer->answers;
                    $session = $profile->session;

                    if (!isset($sessionData[$session])) {
                        $sessionData[$session] = [
                            'category' =>[],
                        ];
                    }

                    if (!isset($sessionData[$session]['category'][$questionCategory])){
                        $sessionData[$session]['category'][$questionCategory] = [
                            'answers' => [],
                            'count' => 0,
                        ];
                    }

                    $sessionData[$session]['category'][$questionCategory]['answers'][] = $answerValue;
                    $sessionData[$session]['category'][$questionCategory]['count']++;
                }
            }
        }

        $categories = [];
        foreach ($sessionData as $session => $questionCategory) {
            foreach ($questionCategory['category'] as $categoryName => $category) {
                $categories[] = $categoryName;
            }
        }


        $radarChart = $this->chart->radarChart()
            ->setTitle('Average Answers Per Session.')
            ->setXAxis($categories)
            ->setMarkers(['#303F9F'], 7, 10);

            


        foreach ($sessionData as $session => $questionCategory) {
            $data = [];

            foreach ($questionCategory['category'] as $category) {

                $average = round(array_sum($category['answers']) / $category['count'], 1);
                $data[] = $average;
            }
            $radarChart->addData($session, $data);
        }
            
        $radarChart->setHeight(375);
        return $radarChart;

    }
}
