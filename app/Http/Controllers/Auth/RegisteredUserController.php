<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClientAgreement;
use App\Models\ClientOverview;
use App\Models\ContactDetail;
use App\Models\File;
use App\Models\PerformanceProfileTemplate;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    function __construct(){
        $this->middleware('permission:enroll-client', ['only' => ['create','createClient','storeClient']]);
   }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function createClient()
    {
        // dd(Auth::user()->permissions->pluck('name'));
        $performanceProfiles = PerformanceProfileTemplate::pluck('title', 'id');
        
        $file = File::where('type', 'terms')->first();
        return view('clients.register', compact('performanceProfiles','file'));
    }

    public function storeClient(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
            'preferred_days' => ['required', 'string', 'max:255'],
            'preferred_times' => ['required', 'string', 'max:255'],
            'program_duration' => ['required', 'integer'],
            'performance_profile_template' => ['required']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user != null) {
            $contactDetails = ContactDetail::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
            ]);

            $clientOverview = ClientOverview::create([
                'user_id' => $user->id,
                'performanceProfile_id' => $request->performance_profile_template,
                'current_sport' => $request->current_sport,
                'experience_level' => $request->experience_level,
                'previous_achievements' => $request->previous_achievements,
                'athletic_background' => $request->athletic_background,
                'injuries' => $request->injuries,
                'medical_conditions' => $request->medical_conditions,
                'allergies' => $request->allergies,
            ]);

            $clientAgreement = ClientAgreement::create([
                'user_id' => $user->id,
                'preferred_days' => $request->preferred_days,
                'preferred_times' => $request->preferred_times,
                'program_duration' => $request->program_duration,
                'consent' => $request->filled('consent'),
                'confidentiality' => $request->filled('confidentiality'),
            ]);

            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole('Client');
        }

        event(new Registered($user));

        return redirect()->route('users.index')
            ->with('success', 'Client has been created successfully');
    }

    public function termsandAgreement(){
        return view('termsAndAgreement.index');
    }



    public function updateClient(Request $request, User $client): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'state' => ['string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'max:255'],
            'postal_code' => ['string', 'max:255'],
            'preferred_days' => ['string', 'max:255'],
            'preferred_times' => ['string', 'max:255'],
            'program_duration' => ['integer'],
            'performance_profile_template' => ['integer'],
        ]);

        $client->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);


        $client->contact->update([
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'country' => $request->country,
            'emergency_contact_name' => $request->emergency_contact_name,
            'state' => $request->state,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'postal_code' => $request->postal_code,
        ]);

        

        $client->clientAgreement->update([
            'preferred_days' => $request->preferred_days,
            'preferred_times' => $request->preferred_times,
        ]);

        if($request->program_duration != null) {
            $client->clientAgreement->update([
                'program_duration' => $request->program_duration
            ]);
        }

        $client->clientOverview->update([
            'performanceProfile_id' => $request->performance_profile_template,
        ]);

        return redirect()->route('users.clientOverview', $client)
            ->with('success', 'Client details have been updated successfully');
    }

    
}
