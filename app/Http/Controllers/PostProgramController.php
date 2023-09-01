<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientOverview;
use Illuminate\Support\Facades\Auth;

class PostProgramController extends Controller
{
    function __construct(){
        $this->middleware('permission:post-feedback-overview-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:post-feedback-overview-viewable', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postFeedbacks = ClientOverview::where('client_completion', true)->get();

        return view('post-feedback.index',  compact('postFeedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
   

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
    public function show(ClientOverview $feedback)
    {
        if(Auth::user()->hasRole('Admin')) {
            return view('post-feedback.show', compact('feedback'));
        } else {
            if($feedback->user->id == Auth::user()->id) {
                return view('post-feedback.show', compact('feedback'));
            } else {
                return back()->with('error', 'You are not authenticated to view this page');
            }
        }
        
        
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
