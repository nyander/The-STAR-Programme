@extends('layouts.standard')

@section('content')
    <div class="mt-6 rounded-lg  mx-8 bg-white">
        @if(session('success'))
            <div class="p-6 bg-green-100 rounded shadow mb-4">
                <p class="text-green-600">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="p-6 bg-red-100 rounded shadow mb-4">
                <p class="text-red-600">{{ session('error') }}</p>
            </div>
        @endif
          

        <div class="flex">
            <div class="w-7/12 pr-4 p-8">
                <div class="mb-4">
                    @if (Auth::user()->hasRole('Admin'))
                        <form method="POST" action="{{ route('performance-profiles.search') }}">
                            @csrf
                            <input type="text" name="nameSearch" placeholder="Search For a Client" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <x-primary-button>{{ __('Search') }}</x-primary-button>
                        </form>   
                    @elseif (Auth::user()->hasRole('Client'))
                        @if ( $performanceProfiles->count() < $clientAgreement->program_duration)
                            <div class="lg:flex lg:items-center lg:justify-between">
                                <h2 class="text-2xl font-semibold mb-6 lg:mb-0">Performance Profile</h2>
                                <a href="{{ route('performance-profiles.create') }}" class="bg-primary hover:bg-primary text-white font-semibold py-2 px-4 rounded text-base">Add New</a>
                            </div>                          
                        @elseif ($user->clientOverview->client_completion == false)
                            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                                <h2 class="text-xl font-semibold mb-4">Program Complete</h2>
                                <p class="text-gray-600 mb-6">You have now reached the end of your agreed contract for the S.T.A.R Program. You are now at the final stage of the program. Please click on the button below.</p>
                                <a href="{{ route('client.completion', $clientAgreement->user_id) }}" class="bg-gray-800 text-white px-4 py-2 rounded-md">Complete Program</a>
                            </div>                
                        @endif
                    @endif
                    
                </div>
        
                @if (Auth::user()->hasRole('Client') && !Auth::user()->hasRole('Admin') && Auth::user()->roles->count() == 1)
                    <div class="w-60 grid grid-cols-2 mb-8">
                        <p><span class="font-bold">Client Name</span></p> <p>{{ $clientAgreement->user->name }}</p>
                        <p><span class="font-bold">Sessions</span></p> <p>{{ $performanceProfiles->count() }}/{{ $clientAgreement->program_duration }} Complete</p>
                        @if ($clientOverview->current_sport != null)
                        <p><span class="font-bold">Sport</span></p> <p>{{$clientOverview->current_sport}}</p>                            
                        @endif
                    </div>
                    
                @endif
        
        
                <div class="grid lg:grid-cols-2 gap-4">
                    @foreach ($performanceProfiles as $performanceProfile)
                        <a href="{{ route('performance-profiles.show', $performanceProfile) }}">
                            <div class="p-6 bg-white rounded shadow">
                                <h3 class="font-semibold text-lg">Session {{ $performanceProfile->session }}</h3>
                                <div class="">
                                    <h2 class="text-sm mb-1"> <span class="font-semibold">Submission Date: </span>{{ $performanceProfile->created_at->format('d/m/Y') }}</h2>
                                    @if (Auth::user()->hasRole('Admin'))
                                        <h2 class="text-sm mb-1"> <span class="font-semibold">Client: </span>{{ $performanceProfile->client->name }}</h2>
                                    @endif
                                    <h2 class="text-sm font-bold {{ $performanceProfile->completed == false ? 'text-red-600' : 'text-green-600' }} ">{{ $performanceProfile->completed == false ? 'Incomplete' : 'Complete' }}</h2>
                                    
                                    @if ($performanceProfile->practitioner_feedback != null)
                                        <div class="mt-4">
                                            <h2 class="text-base mb-1"> <span class="font-semibold">Practitioner Feedback: </span>{{ $performanceProfile->practitioner->name }}</h2>
                                            <div >
                                                <p class="text-slate-500">
                                                    {{ $performanceProfile->practitioner_feedback }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>  
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="w-5/12 bg-sky-50 pl-4 p-4 m-4 border-l-8 border-yellow-300 rounded">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold mb-0">Goals</h2>
                    @if (Auth::user()->hasRole('Admin'))
                        <a href="{{ route('goals.create', $user) }}" class="bg-primary hover:bg-primary text-white font-semibold py-2 px-4 rounded text-base">Add New Goal</a>
                    @endif
                </div> 

                <div>
                    @forelse ($clientGoals as $goal)
                        <div class="p-6 flex space-x-2 my-4 border-l-4 border-primary rounded bg-white">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h1 class="font-semibold">{{ $goal->description }}</h1>
                                        <h2 class="text-sm">Target: {{ $goal->goal }}</h2>
                                        @if ($goal->type == 'amount')
                                            <h2 class="text-sm">Progress: {{ $goal->achieved }}/{{ $goal->goal }}</h2>
                                        @endif
                                        
                                        <h2 class="text-sm font-bold {{ $goal->complete == false ? 'text-red-600' : 'text-green-600' }} ">{{ $goal->complete == false ? 'Incomplete' : 'Complete' }}</h2>
                                        @if ($goal->complete == false && Auth::user()->id == $goal->client->id)
                                            <div class="mt-4">
                                                <a href="{{ route('goals.updateGoal', $goal) }}" class="bg-primary hover:bg-primary text-white font-semibold py-2 px-4 rounded text-base">Update</a>
                                            </div>
                                        @endif
                                    
                                    </div>
                                    @if (Auth::user()->hasRole('Admin'))
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('goals.edit', $goal)">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>

                                            <form method="POST" action="{{ route('goals.destroy', $goal) }}">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link :href="route('goals.destroy', $goal)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No Goals Set</p>
                    @endforelse
                </div>
            </div>
        </div>
       
    </div>
@endsection