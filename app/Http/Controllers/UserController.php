<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\ClientGoal;
use Illuminate\Support\Arr;
use Termwind\Components\Dd;
use Illuminate\Http\Request;
use App\Models\ClientEnquiry;
use App\Models\PerformanceProfile;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Charts\PerformanceProfileChart;
use App\Models\PerformanceProfileTemplate;
use App\Charts\PerformanceProfileRadarChart;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('permission:client-overview-access', ['only' => ['clients','completeContract', 'clientOverview', 'storeAdminCompletion']]);
        $this->middleware('permission:manage-users', ['only' => ['create', 'store', 'storeAdminCompletion']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        if(Auth::user()->hasRole('Admin')) {
            $data = User::latest()->paginate(2);
            return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            $user = Auth::user();
            return view('users.show', compact('user'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->hasRole('Admin')) {
            $user = User::find($id);
            $roles = Role::all();
            $userRole = $user->roles->pluck('name','name')->all();
        
            return view('users.edit',compact('user','roles','userRole'));
        } else {
            return redirect('dashboard')->with('error', 'Unauthorised Access Attempt');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);


        // DB::table('model_has_roles')->where('model_id',$id)->delete();
        // $user->assignRole($request->input('roles'));

        $selectedRoles = $request->input('role', []);
        $user->syncRoles($selectedRoles);
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function clients(){
        if (Auth::user()->hasRole('Admin')) {
            $clients = User::whereHas('roles', function ($query) {
                $query->where('name', 'Client');
            })->get();
            return view('users.clients', compact('clients'));
            
        } else if (Auth::user()->hasRole('Client')) {
            // CHANGE THIS TO RETURN CURRENT USER INSTEAD
            $clients = User::where('id', Auth::user()->id)->get();
            
            return view('users.clients', compact('clients'));
            
        } else {
            redirect()->route('dashboard')->with('success', 'Client feedback has been successfully updated.');
        }

        
        
    }

    public function clientOverview(User $client, PerformanceProfileChart $linechart, PerformanceProfileRadarChart $radarChart) {
       
        if (Auth::user()->hasRole('Admin')) {
            $performanceProfileTemplate = PerformanceProfileTemplate::all();
            $user = auth()->user();

            $enquiries = ClientEnquiry::where('client_id', $client->id)
                                      ->orderBy('created_at', 'desc')
                                      ->take(3)
                                      ->get();
            return view('users.clientOverview', [
                'performanceProfileTemplate' => $performanceProfileTemplate,
                'client' => $client, 
                'chart' => $linechart->build($client),
                'radarChart' => $radarChart->build($client),
                'enquiries' => $enquiries,
            ]);
        } else if (Auth::user()->hasRole('Client')) {
            $performanceProfileTemplate = PerformanceProfileTemplate::all();
            $enquiries = ClientEnquiry::where('client_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
            return view('users.clientOverview', [
                'performanceProfileTemplate' => $performanceProfileTemplate,
                'client' => Auth::user(), // Use Auth::user() here
                'chart' => $linechart->build(Auth::user()), // Use Auth::user() here
                'radarChart' => $radarChart->build(Auth::user()), // Use Auth::user() here
                'enquiries' => $enquiries,
            ]);
        }     else {
            return redirect()->route('dashboard');
        }
    }
    

    public function completeContract($user)
    {
        $client = $user;
       
        return view('clients.completion', compact('client'));
        
    }

    public function storeCompleteContract(Request $request, string $id)
    {
        // Find the client
        $client = User::find($id);

        // Define the validation rules for the form fields
        $rules = [
            'client_experience' => 'required|string',
            'client_positive_feedback' => 'required|string',
            'client_areas_to_improve' => 'required|string',
            'client_challenges' => 'required|string',
            'client_testimonies' => 'required|string',
            'client_comments' => 'required|string',
        ];

        

        // Validate the form fields
        $this->validate($request, $rules);

        // If validation passes, store the data in the client overview table
        $clientOverview = $client->clientOverview;

        
        
        if (!$clientOverview) {
            // If the client overview doesn't exist, create a new one
            $clientOverview = $client->clientOverview()->create($request->all());
        } else {
            // If the client overview exists, update the fields
            $clientOverview->client_experience = $request->client_experience;
            $clientOverview->client_positive_feedback = $request->client_positive_feedback;
            $clientOverview->client_areas_to_improve = $request->client_areas_to_improve;
            $clientOverview->client_challenges = $request->client_challenges;
            $clientOverview->client_testimonies = $request->client_testimonies;
            $clientOverview->client_comments = $request->client_comments;
            $clientOverview->client_completion = true;
            $clientOverview->save();
        }

        

        if($clientOverview->practitioner_completion == true && $clientOverview->client_completion == true) {
            $client->clientAgreement->completed = true;
            $client->clientAgreement->save();
        }

        // Redirect to the 'dashboard' view with a success message
        return redirect()->route('dashboard')->with('success', 'Client feedback has been successfully updated.');
    }


    public function storeAdminCompletion(Request $request, string $id)
    {
        // Find the client
        $client = User::find($id);

        // Define the validation rules for the form fields
        $rules = [
            'practitioner_progress_review' => 'required|string',
            'practitioner_achievement_review' => 'required|string',
            'practitioner_challenge_review' => 'required|string',
            'practitioner_support' => 'required|string',
            'practitioner_suggestion' => 'required|string',
        ];

        

        // Validate the form fields
        $this->validate($request, $rules);

        // If validation passes, store the data in the client overview table
        $clientOverview = $client->clientOverview;
        

        if (!$clientOverview) {
            // If the client overview doesn't exist, create a new one
            $clientOverview = $client->clientOverview()->create([
                'practitioner_client_achieve' => $request->practitioner_client_achieve,
                'practitioner_progress_review' => $request->practitioner_progress_review,
                'practitioner_achievement_review' => $request->practitioner_achievement_review,
                'practitioner_challenge_review' => $request->practitioner_challenge_review,
                'practitioner_support' => $request->practitioner_support,
                'practitioner_suggestion' => $request->practitioner_suggestion
            ]);
        } else {
            // If the client overview exists, update the fields
            $clientOverview->practitioner_client_achieve = $request->practitioner_client_achieve;
            $clientOverview->practitioner_progress_review = $request->practitioner_progress_review;
            $clientOverview->practitioner_achievement_review = $request->practitioner_achievement_review;
            $clientOverview->practitioner_challenge_review = $request->practitioner_challenge_review;
            $clientOverview->practitioner_support = $request->practitioner_support;
            $clientOverview->practitioner_suggestion = $request->practitioner_suggestion;
            $clientOverview->practitioner_completion = true;
            $clientOverview->save();
        }

        if($clientOverview->practitioner_completion == true && $clientOverview->client_completion == true) {
            $client->clientAgreement->completed = true;
            $client->clientAgreement->save();
        }

        

        // Redirect to the 'dashboard' view with a success message
        return redirect()->route('dashboard')->with('success', 'Client feedback has been successfully updated.');
    }
        
}
