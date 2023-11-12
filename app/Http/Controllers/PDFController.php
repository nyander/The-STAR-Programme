<?php

namespace App\Http\Controllers;

use App\Charts\PerformanceProfileChart;
use App\Charts\PerformanceProfileRadarChart;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function index(User $client, PerformanceProfileChart $linechart, PerformanceProfileRadarChart $radarchart)
    {
        $performanceProfiles = $client->performanceProfile()->get();
        $feedback = $client->clientOverview()->first();

        // Pass the collection directly to the view instead of just names and ids
        $pdf = Pdf::loadView("summaries.fullSummary", [
            'performanceProfiles' => $performanceProfiles, 
            'feedback' => $feedback,
            'linechart' => $linechart,
            'radarchart' => $radarchart, 
            'client' => $client
        ]); 

        return $pdf->download('performanceProfile.pdf');
    }

    
}
