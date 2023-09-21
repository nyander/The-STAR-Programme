<?php

namespace App\Http\Controllers;

use App\Models\ClientEnquiry;
use App\Models\User;
use App\Notifications\EnquiryResponseSubmitted;
use App\Notifications\EnquirySubmitted;
use Exception;
use Illuminate\Database\DeadlockException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use PDOException;


class ClientEnquiryController extends Controller
{
    function __construct(){
        $this->middleware('permission:client-enquiry-access', ['only' => ['index', 'create', 'store', 'show', 'update', 'addClientReply', 'reply']]);
    }
    public function index()
    {
        // $enquiries = ClientEnquiry::with('client')->latest()->paginate(10);
        if (Gate::allows('enquiry-access-to-all')){
            $enquiries = ClientEnquiry::all();
        } else {
            $enquiries = ClientEnquiry::where('client_id', Auth::user()->id)->paginate(10);
        }
        
        return view('enquiries.index', compact('enquiries'));
    }

    
    public function create()
    {
        if(Auth::user()->hasRole('Client') && Auth::user()->clientAgreement->complete == true){
            return back()->with('error', 'As your contract is complete, you cannot access this page.');
        }

        if (Auth::user()->hasRole('Client')) {
            return view('enquiries.create');
        } else {
            return back()->with('error', 'You are not authorised to raise an enquiry');
        }
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'subject' => 'required'
        ]);
        $enquiry = ClientEnquiry::create([
            'client_id' => Auth::user()->id,
            'content' => $request->input('message'),
            'subject' => $request->input('subject') 
        ]);

        $practitioners = User::role('Admin')->get();
        foreach($practitioners as $practitioner){
            $practitioner->notify(new EnquirySubmitted($enquiry));
        } 


        return redirect()->route('enquiries.index')
            ->with('success', 'Enquiry submitted successfully.');
            
    }

    public function show(ClientEnquiry $enquiry)
    {
        if (Gate::allows('enquiry-view-all')){
            return view('enquiries.show', compact('enquiry'));
        }else {
            if ($enquiry->client->id == Auth::user()->id){
                return view('enquiries.show', compact('enquiry'));
            } else {
                return back()->with('error', 'You are not authorised to view the requested enquiry');
            }
        }
    
    }

    public function update(Request $request, ClientEnquiry $enquiry)
    {
        if(Auth::user()->hasRole('Client') && Auth::user()->clientAgreement->complete == true){
            return back()->with('error', 'As your contract is complete, you cannot access this page.');
        }

        $request->validate([
            'response' => 'required',
        ]);

        $enquiry->responses()->create([
            'response' => $request->input('response'),
        ]);

        return redirect()->route('enquiries.show', $enquiry)
            ->with('success', 'Response submitted successfully.');

        
    }

    public function addClientReply(Request $request, ClientEnquiry $enquiry)
    {
        if(Auth::user()->hasRole('Client') && Auth::user()->clientAgreement->complete == true){
            return back()->with('error', 'As your contract is complete, you cannot access this page.');
        }
        if ($enquiry->client_id == Auth::user()->id) {
            $request->validate([
                'reply' => 'required',
            ]);
            $enquiry->responses()->create([
                'response' => $request->input('reply'),
                'is_client_reply' => true,
            ]);
            return redirect()->route('enquiries.show', $enquiry)
            ->with('success', 'Reply submitted successfully.');
        } else {
            return back()->with('error', 'You are not authorised to reply to this enquiry');
        }
    }

    public function respond(Request $request, ClientEnquiry $enquiry)
    {
        if(Auth::user()->hasRole('Client') && Auth::user()->clientAgreement->complete == true){
            return back()->with('error', 'As your contract is complete, you cannot access this page.');
        }
        $request->validate([
            'response' => ['required', 'string'],
        ]);

        $response = $enquiry->responses()->create([
            'response' => $request->input('response'),
            'user_id' => Auth::user()->id
          ]);

        
        if (Auth::user()->hasRole('Client')){
            $practitioners = User::role('Admin')->get();
            foreach($practitioners as $practitioner){
                // $practitioner->notify(new EnquiryResponseSubmitted($response));
            } 
            //if current user is the user that submitted the response then notify the practitioners
        } else {
            $user = $enquiry->client();
            // $user->notify(new EnquiryResponseSubmitted($response));
            
        }

        return redirect()->route('enquiries.show', $enquiry)
            ->with('success', 'Response submitted successfully.');
        
    }
}
