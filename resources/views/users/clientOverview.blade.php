@extends('layouts.standard')

@section('content')
    
    <div class="mt-6 rounded-lg mx-auto">
        <div class="mx-auto sm:px-6 px-8 dashboard ">
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
        </div>
        <div class="mx-8 sm:p-8 lg:p-8 bg-white">
            <div class="bg-primary p-4 mt-4 text-white toggle-bg drop-shadow-md rounded">
                <div class="flex justify-between items-center cursor-pointer">
                    <div>
                        <h3 class="text-lg font-semibold mb-0">{{ $client->name }}</h3>
                        <p class="mb-1 text-xs"><span class="font-semibold">Last Submitted Profile:</span></p>
                        <p class="mb-1 text-xs"><span class="font-semibold">Goals Achieved:</span> {{ $count = $client->clientGoals()->where('complete', true)->count()}}</p>    
                    </div>
                    <div class="">
                        <h1 class="text-2xl font-bold float-right">{{ $client->performanceProfile->count() }}|{{$client->clientAgreement->program_duration}}</h1>
                        <h5 class="text-xs">Sessions</h5>
                    </div>
                </div>
            </div>
            <div class="p-4 md:p-8 bg-gray-200 mx-2">
                <h4 class="font-semibold mb-8 text-lg">Overview</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="performance-chart chart tabcontent bg-white p-4">
                        {!! $chart->container() !!}
                        <script src="{{ $chart->cdn() }}"></script>
                      </div>

                    <div class="bg-primary p-4 h-full flex items-center w-full rounded drop-shadow-md	">
                        <div class="text-white text-center mx-auto">
                        <h3 class="title-counter text-6xl font-extrabold mb-4">
                            {{-- COUNTER ANIMATION HERE --}}
                            
                            {{ $client->performanceProfile->count() > 0 ? ($client->performanceProfile->count() /$client->clientAgreement->program_duration) * 100 :  '0'}}%
                        </h3>
                        <p class="text-base">Sessions Completed</p>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                    <div>
                        <div class="col-span-4 bg-gray-200">
                            <div class="grid grid-cols-2 grid-rows-2 gap-2">
            
                                <div class="bg-red-600 p-4 sm:h-28 md:h-34 lg:h-36 flex items-center rounded drop-shadow-md	">
                                  <div class="text-white">
                                    <h3 class="title text-4xl font-extrabold">
                                        00
                                    </h3>
                                    <p class="text-xs">Missing Performance Profiles</p>
                                  </div>
                                </div>
                              
                                <div class="bg-green-700 p-4 sm:h-28 md:h-34 lg:h-36 flex items-center rounded drop-shadow-md	">
                                    <div class="text-white">
                                        <h3 class="title text-4xl font-extrabold">
                                            {{ $client->performanceProfile->count() }}/{{ $client->clientAgreement->program_duration }}
                                        </h3>
                                        <p class="text-xs">Completed Performance Profiles</p>
                                    </div>
                                </div>
                              
                                <div class="bg-blue-900 p-4 sm:h-28 md:h-34 lg:h-36 flex items-center rounded drop-shadow-md	">
                                    <div class="text-white">
                                        <h3 class="title text-4xl font-extrabold">
                                            04/08
                                        </h3>
                                        <p class="text-xs">Goals Achieved</p>
                                    </div>
                                </div>
                              
                                <div class="bg-sky-600 p-4 sm:h-28 md:h-34 lg:h-36 flex items-center rounded drop-shadow-md	">
                                    <div class="text-white">
                                        <h3 class="title text-4xl font-extrabold">
                                            07
                                        </h3>
                                        <p class="text-xs">Message board topics</p>
                                    </div>
                                </div>
                              
                              </div>
                        </div>
                    </div>
                   <div>
                    <div class="p-4 sm:col-span-12 md:col-span-6 lg:col-span-5 bg-white h-full my-auto drop-shadow-md rounded">
                        <div class="flex justify-between items-center">
                          <h3 class="text-lg font-bold">Message board</h3>
                          {{-- <h3 class="text-xs">{{ $enquiriesCount }} Enquiries</h3> --}}
                        </div>
                        @forelse ($enquiries as $enquiry)
                          <div class="bg-gray-50 p-4 border-l-8 border-primary my-4 rounded drop-shadow">
                            <a href="{{ route('enquiries.show', $enquiry) }}">
                              <div class="mb-2">
                                  <div class="w-full flex justify-between items-center">
                                      <h3 class="text-basexx font-black">{{ $enquiry->subject }}</h3>
                                      <p class=" text-sm {{ !$enquiry->resolved ? 'text-red-700' : 'text-green-700' }}">{{ !$enquiry->resolved ? 'Unresolved' : 'Resolved' }}</p>
                                  </div>
                                  <div class="w-full flex justify-between items-center">
                                    <p class="text-gray-400 text-sm">{{ $enquiry->client->name }}</p>
                                    @if ($enquiry->responses->count() > 0)
                                        <p class="text-xs text-gray-400">{{ $enquiry->responses->count() }} Responses</p>
                                    @endif
                                  </div>
                                  
                                  
                                  <p class="">{{ Str::limit($enquiry->content, 6070) }}</p>
                              </div>
                            </a>
                          </div>
                        @empty
                          <div class="h-96 flex items-center justify-center mx-auto">
                            <div class="items-center text-center ">
                              <p class="mb-6">No Enquries have been made</p>
                              @can('client-enquiry-access')
                                <a href="{{ route('enquiries.index') }}" class="bg-primary hover:bg-primary text-white text-sm font-semibold py-2 px-4 rounded">Submit An Enquiry</a>
                              @endcan
                            </div>
                            
                          </div>
                            
                        @endforelse
                        
                      </div>
                   </div>
                </div>

                

                <div class="mt-4">
                    <div class="bg-gray-300 p-4">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold mb-0">Goals</h2>
                            <a href="{{ route('goals.create', $client) }}" class="bg-primary hover:bg-primary text-white text-sm font-semibold py-2 px-4 rounded">Add New Goal</a>
                        </div> 
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($client->clientGoals as $goal) 
                            <div class="p-6 flex space-x-2 border-l-4 border-primary rounded bg-white">
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
                            
                            {{-- <div class="p-6 bg-white rounded shadow flex justify-between">
                                    <div>
                                        <h3 class="font-semibold text-base">Session {{ $performanceProfile->session }}</h3>
                                        <div class="">
                                            <h2 class="text-sm mb-1"> <span class="font-semibold">Submission Date: </span>{{ $performanceProfile->created_at->format('d/m/Y') }}</h2>
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
                                </div>   --}}
                        @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-4" >
                    <form method="POST" action="{{ route('client.update', $client) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:bg-white bg-gray-300 md:p-6">
                            <div class=" bg-gray-300 placeholder:md:bg-gray-100 p-4">
                                <h2 class="font-semibold mb-4">Availability & Session Preferences</h2>
                                
                                <div>
                                    <x-input-label for="preferred_days" :value="__('Preferred Days')" />
                                    <select id="preferred_days" name="preferred_days"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    >
                                        <option value="">Select a day</option>
                                        <option value="Monday" {{ $client->clientAgreement->preferred_days === 'Monday' ? 'selected' : '' }}>Monday</option>
                                        <option value="Tuesday" {{ $client->clientAgreement->preferred_days === 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                        <option value="Wednesday" {{ $client->clientAgreement->preferred_days === 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                        <option value="Thursday" {{ $client->clientAgreement->preferred_days === 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                        <option value="Friday" {{ $client->clientAgreement->preferred_days === 'Friday' ? 'selected' : '' }}>Friday</option>
                                        <option value="Saturday" {{ $client->clientAgreement->preferred_days === 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                        <option value="Sunday" {{ $client->clientAgreement->preferred_days === 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('preferred_days')" class="mt-2" />
                                </div>
    
                                <!-- Preferred Times -->
                                <div class="mt-4">
                                    <x-input-label for="preferred_times" :value="__('Preferred Times')" />
                                    <x-text-input id="preferred_times" class="block mt-1 w-full" type="text" name="preferred_times" :value="$client->clientAgreement->preferred_times" required />
                                    <x-input-error :messages="$errors->get('preferred_times')" class="mt-2" />
                                </div>
    
                                <!-- Program Duration -->
                                <div class="mt-4">
                                    <x-input-label for="program_duration" :value="__('Program Duration')" />
                                    @if (Auth::user()->hasRole('Admin'))
                                        <x-text-input id="program_duration" class="block mt-1 w-full" type="number" name="program_duration" :value="$client->clientAgreement->program_duration" required />
                                    @else
                                    <x-text-input id="program_duration" class="block mt-1 w-full" type="number" name="program_duration" :value="$client->clientAgreement->program_duration" disabled required />
                                    @endif
                                    <x-input-error :messages="$errors->get('program_duration')" class="mt-2" />
                                </div>
    
                                
                            </div>
                            <div class="bg-gray-300 md:bg-gray-100 p-4">
                                <h2 class="font-semibold mb-4">Availability & Session Preferences</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-2">
                                    <!-- Name -->
                                    <div>
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $client->name }}" required />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <!-- Email Address -->
                                    <div class="">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $client->email)" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                     <!-- Phone Number -->
                                    <div>
                                        <x-input-label for="phone_number" :value="__('Phone Number')" />
                                        <x-text-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number', $client->contact->phone_number)" />
                                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                    </div>

                                    <!-- City -->
                                    <div class="">
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $client->contact->city)" />
                                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                    </div>

                                    <!-- Country -->
                                    <div class="">
                                        <x-input-label for="country" :value="__('Country')" />
                                        <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country', $client->contact->country)" />
                                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                    </div>

                                    <!-- Emergency Contact Name -->
                                    <div class="">
                                        <x-input-label for="emergency_contact_name" :value="__('Emergency Contact Name')" />
                                        <x-text-input id="emergency_contact_name" class="block mt-1 w-full" type="text" name="emergency_contact_name"
                                            :value="$client->contact->emergency_contact_name" required />
                                        <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                                    </div>

                                    <!-- State/Province -->
                                    <div class="">
                                        <x-input-label for="state" :value="__('State/Province')" />
                                        <x-text-input id="state" class="block mt-1 w-full" type="text" name="state"
                                            :value="$client->contact->state" required />
                                        <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                    </div>

                                    <!-- Emergency Contact Phone Number -->
                                    <div class="">
                                        <x-input-label for="emergency_contact_phone" :value="__('Emergency Phone Number')" />
                                        <x-text-input id="emergency_contact_phone" class="block mt-1 w-full" type="tel" name="emergency_contact_phone"
                                            :value="$client->contact->emergency_contact_phone" required />
                                        <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                                    </div>

                                    <!-- Postal Code/Zip Code -->
                                    <div class="">
                                        <x-input-label for="postal_code" :value="__('Postal Code/ZIP Code')" />
                                        <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code"
                                            :value="$client->contact->postal_code" required />
                                        <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                                    </div>
                                    


                                </div>
                            </div>

                            <x-primary-button class="mt-4 bg-primary text-white flex text-center justify-center">
                                {{ __('Update') }}
                            </x-primary-button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>

    {{ $chart->script() }}  
    {{ $radarChart->script() }}
    <script>
        const counterEl = document.querySelector('.title-counter');
        const initValue = parseInt(counterEl.innerText); 

        let counter = 0;

        setInterval(() => {
        
        if(counter < initValue) {
            counter++;
            counterEl.innerText = counter + '%'; 
        }
        
        }, 15);
    </script>

@endsection
