@extends('layouts.standard')

@section('content')
    <div class="mt-6 rounded-lg mx-auto">
        <div class="mx-8 sm:p-8 lg:p-8 bg-white">
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

        
        @foreach ($clients as $client)
            <div class="rounded" onclick="toggleContent('content{{ $loop->iteration }}', this, event)">
                <div class="bg-gray-100 p-4 mt-4 text-black toggle-bg drop-shadow-md">
                    <div class="flex justify-between items-center cursor-pointer">
                        <div>
                            <h3 class="text-lg font-semibold mb-0">{{ $client->name }}</h3>
                            <p class="mb-1 text-xs"><span class="font-semibold">Last Submitted Profile:</span></p>
                            <p class="mb-1 text-xs"><span class="font-semibold">Goals Achieved:</span> {{ $count = $client->clientGoals()->where('complete', true)->count(); }}</p>    
                        </div>
                        <div>
                            <div class="mb-8">
                                @if (Auth::user()->is(auth()->user()))
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button class="float-right mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black dropdown" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('performance-profiles.index')">
                                                {{ __('Manage Profile/Goal') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('users.clientOverview', $client)">
                                                {{ __('Manage Client') }}
                                            </x-dropdown-link>
                                        </x-slot>
                                    </x-dropdown>
                                @endif 
                            </div>
                            <div class="">
                                <h1 class="text-2xl font-bold float-right">{{ $client->performanceProfile->count() }}|{{$client->clientAgreement->program_duration}}</h1>
                                <h5 class="text-xs">Sessions</h5>
                            </div>
                        </div>
                    </div>
                    
                </div>
                    
                <div id="content{{ $loop->iteration }}" class="hidden p-8 bg-gray-200 mx-2">
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($client->performanceProfile as $performanceProfile) 
                            <div class="p-6 bg-white rounded shadow mb-4 flex justify-between">
                                <a href="{{ route('performance-profiles.show', $performanceProfile) }}">
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
                                </a>
                            </div>  
                    @endforeach
                    </div>
                    
                </div>
            </div>
        @endforeach
        </div>
    </div>

   
    <script>
        function toggleContent(contentId, elem) {
            const content = document.getElementById(contentId);
            const toggleBg = elem.querySelector('.toggle-bg');

             // Check if the click is inside the content div itself or is the toggle-bg div
            if (event.target.closest(`#content${contentId}`) || !event.target.closest('.toggle-bg')) {
                return; // do nothing if click is inside the content or outside the toggle-bg
            }
            
            content.classList.toggle('hidden');

            const dorpdownCol = elem.querySelector('.dropdown');
            if (toggleBg.classList.contains('bg-primary')) {
                toggleBg.classList.remove('bg-primary');
                toggleBg.classList.remove('text-white');
                dorpdownCol.classList.remove('text-white');
                toggleBg.classList.add('bg-gray-100');
                toggleBg.classList.add('text-black');
                dorpdownCol.classList.add('text-black');
            } else {
                toggleBg.classList.remove('bg-gray-100');
                toggleBg.classList.remove('text-black')
                dorpdownCol.classList.remove('text-black');
                toggleBg.classList.add('bg-primary');
                toggleBg.classList.add('text-white');
                dorpdownCol.classList.add('text-white');
            }
        }

    </script>
@endsection