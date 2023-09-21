<?php

namespace App\Http\Controllers;

use App\Models\ClientAgreement;
use App\Models\ClientGoal;
use App\Models\ClientOverview;
use App\Models\PerformanceProfile;
use App\Models\PerformanceProfileAnswer;
use App\Models\PerformanceProfileTemplate;
use App\Models\PerformanceTemplateQuestion;
use App\Models\User;
use App\Notifications\CompletedContractAgreement;
use App\Notifications\FeedbackSubmitted;
use App\Notifications\PerformanceProfileSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Psy\Readline\Hoa\Console;
use Spatie\Permission\Models\Permission;

class PerformanceProfileController extends Controller
{
    function __construct(){
        $this->middleware('permission:performance-profile-list|performance-profile-create|performance-profile-edit|performance-profile-delete', ['only' => ['index','show']]);
        $this->middleware('permission:performance-profile-create', ['only' => ['create','store']]);
        $this->middleware('permission:performance-profile-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:performance-profile-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();
        if($user->hasRole('Admin')){
            $performanceProfiles = PerformanceProfile::all();
            $clientGoals = ClientGoal::all();
            return view('performance-profile.index', compact('performanceProfiles', 'user', 'clientGoals'));
        }else{
            $performanceProfiles = PerformanceProfile::where('client_id',$user->id)->get();
            $clientAgreement = ClientAgreement::where('user_id', $user->id)->first();
            $clientOverview = ClientOverview::where('user_id', $user->id)->first();
            $clientGoals = ClientGoal::where('client_id',$user->id)->get();
            return view('performance-profile.index', compact('performanceProfiles', 'user', 'clientAgreement', 'clientOverview', 'clientGoals'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->hasRole('Client') && Auth::user()->clientAgreement->complete == true){
            return back()->with('error', 'As your contract is complete, you cannot access this page.');
        }
        $user = Auth::user();
        if($user->hasRole('Admin')){
            return redirect()->back()->with('error', 'As an administrator, you cannot create a performance profile');
        } elseif ($user->hasRole('Client')) {
            $clientOverview = ClientOverview::where('user_id', $user->id)->first();
            $performanceProfileTemplate = PerformanceProfileTemplate::find($clientOverview->performanceProfile_id);
            $performanceProfileQuestions = PerformanceTemplateQuestion::where('performance_template_id', $performanceProfileTemplate->id)->get();

            return view('performance-profile.create',  compact('clientOverview','performanceProfileTemplate','performanceProfileQuestions'));
        } else {
            return redirect()->back()->with('error', 'You are unable to complete a peformance profile');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if($user->performanceProfile->count() < $user->clientAgreement()->first()->program_duration)
        {
            $performanceProfileTemplate = PerformanceProfileTemplate::find($request->performanceProfileTemplate);
            $rules = [];

            foreach ($performanceProfileTemplate->questions as $question) {
                if ($question->required) {
                    $rules[$question->title] = 'required';
                } else {
                    $rules[$question->title] = 'nullable';
                }
            }

            $test = [];
            $validatedData = $request->validate($rules);

            $profileCount = PerformanceProfile::where('client_id', $user->id)->count();

            $performanceProfile = PerformanceProfile::create([
                'performance_template_id' => $performanceProfileTemplate->id,
                'client_id' => $user->id,
                'session' => $profileCount+1, 
            ]);

            foreach ($performanceProfileTemplate->questions as $question) {
                PerformanceProfileAnswer::create([
                    'performance_profile_id' => $performanceProfile->id,
                    'question_id' => $question->id,
                    'question_text' => $question->text,
                    'question_type' => $question->type,
                    'answers' => $validatedData[$question->title]
                ]);
            }

            $performanceProfile->save();

            $permission = Permission::where('name', 'performance-profile-edit')->first();
            $usersWithPermission = User::role('Admin')->get();
            $countOfPP = PerformanceProfile::where('client_id', $user->id)->count();
            
            foreach($usersWithPermission as $notifyPractitioner){
                $notifyPractitioner->notify(new PerformanceProfileSubmitted($performanceProfile));
                
                if ($countOfPP == $user->clientAgreement->program_duration){
                    $notifyPractitioner->notify(new CompletedContractAgreement($performanceProfile->client));
                }  
            }

            return redirect()->route('performance-profiles.index')
                            ->with('success','Answers submitted successfully');
        } else {
            return back()->with('error', 'You are unable to submit a new Performance Profile.');
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(PerformanceProfile $performanceProfile)
    {
        return view('performance-profile.show', compact('performanceProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerformanceProfile $performanceProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerformanceProfile $performanceProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceProfile $performanceProfile)
    {
        //
    }

    public function addFeedback(Request $request, PerformanceProfile $performanceProfile){
        $validated = $request->validate([
            'practitioner_feedback' => 'required',
            'strengths' => 'required',
            'weakness' => 'required'
        ]);

        $performanceProfile->practitioner_feedback = $validated['practitioner_feedback'];
        $performanceProfile->strengths = $validated['strengths'];
        $performanceProfile->weakness = $validated['weakness'];
        $performanceProfile->practitioner_id = Auth::user()->id;
        $performanceProfile->completed = true;
        $performanceProfile->save();

        $performanceProfile->client->notify(new FeedbackSubmitted($performanceProfile));


        return redirect()->route('goals.index', $performanceProfile->client)
                        ->with('success','Feedback submitted successfully, please update client\'s goals');

    }

    public function search(Request $request)
    {
        $search = $request->input('nameSearch');
        $user = Auth::user();

        if($search === null){
            return redirect()->back()->with('error', 'Please provide a client name before searching');
        }
        if ($user->hasRole('Admin')) {
            $performanceProfiles = PerformanceProfile::whereHas('client', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })->get();

            if ($performanceProfiles->isEmpty()) {
                return back()->with('error', 'No matching performance profiles found.');
            }

            return view('performance-profile.results', compact('performanceProfiles', 'user', 'search'));
        }

        return redirect()->back()->with('error', 'You are unable to complete a performance profile.');
    }

    public function markAsRead(){
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function clearRead() {
        $readNotifications = Auth::user()->readNotifications;
        foreach ($readNotifications as $notifications){
            $notifications->delete();
        }
        return redirect()->back();
    }

    public function readNotification($notificationId) {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return redirect()->back();
    }    





}
