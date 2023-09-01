<?php

namespace App\Http\Controllers;

use App\Models\ClientGoal;
use App\Models\User;
use App\Notifications\GoalSubmitted;
use App\Notifications\GoalUpdated;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DeadlockException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;
use Psy\Readline\Hoa\Console;

class ClientGoalController extends Controller
{
    function __construct(){
        $this->middleware('permission:client-goals-index|client-goals-create|client-goals-edit|client-goals-storeUpdateGoal|client-goals-delete|client-goals-updateGoal', ['only' => ['index', 'show']]);
        $this->middleware('permission:client-goals-create', ['only' => ['create','store']]);
        $this->middleware('permission:client-goals-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:client-goals-delete', ['only' => ['destroy']]);
        $this->middleware('permission:client-goals-updateGoal', ['only' => ['updateGoal', 'storeUpdateGoal']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(User $client)
    {
        if(!$client->hasRole('Client')){
            return redirect()->back()->with('error', 'Only a Client can have goals');
        }
        $clientGoals = ClientGoal::where('client_id',$client->id)->get();
        return view('client-goals.index', compact('clientGoals','client'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $client)
    {
        if (Auth::user()->hasRole('Client')) {
            return view('client-goals.create', compact('client'));
        } else {
            return redirect()->back()->with('error', 'Only a Client can create goals');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $client)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required',
            'client_id' => 'required'
        ]);

        if ($validated['type'] === 'amount') {
            $validated = $request->validate([
                'description' => 'required|string|max:255',
                'type' => 'required',
                'amount_goal' => 'required|numeric',
                'client_id' => 'required'
            ]);

            $goalData = [
                'description' => $validated['description'],
                'type' => $validated['type'],
                'goal' => $validated['amount_goal'],
                'client_id' => $validated['client_id'],
            ];
        } else {
            $validated = $request->validate([
                'description' => 'required|string|max:255',
                'type' => 'required',
                'milestone_goal' => 'required|string',
                'client_id' => 'required'
            ]);

            $goalData = [
                'description' => $validated['description'],
                'type' => $validated['type'],
                'goal' => $validated['milestone_goal'],
                'client_id' => $validated['client_id'],
            ];
        }

        $practitioner = User::find(Auth::user()->id);

        $client = User::find($validated['client_id']);
        $clientGoal = ClientGoal::create($goalData);

        $client->notify(new GoalSubmitted($clientGoal, $practitioner));

        return redirect()->route('performance-profiles.index')
                            ->with('success','New Goal has been added');
        
    }


    /**
     * Display the specified resource.
     */
    public function show(ClientGoal $clientGoal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientGoal $goal): View
    {
        $client = $goal->client()->first();
        return view('client-goals.edit', [
            'goal' => $goal, 'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientGoal $goal)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required',
            'goal' => 'required',
        ]);

        $practitioner = User::find(Auth::user()->id);

        $client = $goal->client;
        if ($goal->type === 'amount') {
            $goal->achieved = $goal->achieved; // Clear the achieved field for amount type goal
            $goal->complete = $goal->achieved >= $goal->goal;
        } else {
            $goal->achieved = $validated['achieved'] ?? $goal->achieved;
            $goal->complete = $validated['completed'] ?? false;
        }

        $goal->update([
            'description' => $validated['description'],
            'type' => $validated['type'],
            'goal' => $validated['goal'],
            'achieved' => $goal->achieved,
            'complete' => $goal->complete,
        ]);

        $client->notify(new GoalUpdated($goal, $practitioner));

        return redirect()->route('performance-profiles.index')
                            ->with('success','Goal has been updated');
        
    }


    public function updateGoal(ClientGoal $goal){
        $client = $goal->client()->first();
        if (Auth::user()->hasRole('Admin') || Auth::user()->id == $client->id){
            
            return view('client-goals.updateGoal', [
                'goal' => $goal, 'client' => $client
            ]);
        } else {
            return redirect()->back()->with('error', 'You are not authorised to access this goal');
        }
        
    }

    public function storeUpdateGoal(Request $request, ClientGoal $goal)
    {
        $validated = $request->validate([
            'achieved' => $goal->type == 'amount' ? 'required|numeric' : '',
            'completed' => $goal->type != 'amount' ? 'required' : '',
        ]);
    
        if ($goal->type == 'amount' && isset($validated['achieved'])) {
            $goal->achieved = $validated['achieved'];
            $goal->achieved === null ? $goal->achieved = 0 : '';
        }
    
        if ($goal->type != 'amount' && isset($validated['completed'])) {
            $goal->complete = true;
            $goal->achieved === null ? $goal->achieved = 0 : '';
        }
    
        if ($goal->achieved >= $goal->goal || $goal->complete) {
            $goal->complete = true;
            $goal->achieved === null ? $goal->achieved = 0 : '';
        } else {
            $goal->complete = false;
            $goal->achieved === null ? $goal->achieved = 0 : '';
        }
    
        $goal->save();

        return redirect()->route('users.clientOverview', $goal->client)
        ->with('success','Goal has been updated');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientGoal $goal)
    {
        $goal->delete();

        return redirect(route('goals.index', $goal->client))->with('success','Goal has been deleted');
    }
}
