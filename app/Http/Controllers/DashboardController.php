<?php

namespace App\Http\Controllers;

use App\Charts\PerformanceProfileChart;
use App\Charts\PerformanceProfileRadarChart;
use App\Models\ClientEnquiry;
use App\Models\ClientGoal;
use App\Models\PerformanceProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PerformanceProfileChart $linechart, PerformanceProfileRadarChart $radarChart)
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $enquiries = ClientEnquiry::orderBy('created_at', 'desc')->get();
            
        } else {
            $enquiries = ClientEnquiry::where('client_id', $user->id)
                                      ->orderBy('created_at', 'desc')
                                      ->get();
        }
        
        $recentEnquiries = $enquiries->take(2);
        $enquiriesCount = $enquiries->count();
        $totalPerformanceProfiles = PerformanceProfile::where('completed', true)->count();
        $totalIncompletePerformanceProfiles = PerformanceProfile::where('completed', false)->count();
        $totalGoals = ClientGoal::all()->count();
        $recentSubmissions = ClientGoal::orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard', ['recentSubmissions' => $recentSubmissions,'user' => $user,'totalIncompletePerformanceProfiles' => $totalIncompletePerformanceProfiles,'totalGoals' => $totalGoals,'totalPerformanceProfiles' => $totalPerformanceProfiles,'chart' => $linechart->build($user),'radarChart' => $radarChart->build($user), 'enquiries' => $recentEnquiries, 'enquiriesCount' => $enquiriesCount]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
