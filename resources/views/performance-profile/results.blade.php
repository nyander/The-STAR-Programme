<x-app-layout>
    <div class="mt-6 rounded-lg max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
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
        <div class="flex justify-end mb-4">
            <a href="{{ route('performance-profiles.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-base">Back</a>
        </div>

        <h2 class="text-2xl font-semibold mb-4">{{ $search != null ?  ('Search Results for '.$search): '' }}</h2>

        @if ($performanceProfiles === null || $performanceProfiles->count() === 0)
            <p>No matching performance profiles found.</p>
        @else
        @foreach ($performanceProfiles as $performanceProfile)
            
            <div class="p-6 bg-white rounded shadow mb-4 flex justify-between">
                <div>
                    <h3 class="font-semibold text-lg mb-4">Session {{ $performanceProfile->session }}</h3>
                    <div class="mb-6 mt-6">
                        <h2 class="text-base mb-1"> <span class="font-semibold">Client Name: </span>{{ $performanceProfile->client->name}}</h2>
                        <h2 class="text-base mb-1"> <span class="font-semibold">Submission Date: </span>{{ $performanceProfile->created_at->format('d/m/Y') }}</h2>
                        <h2 class="text-base mb-1"> <span class="font-semibold">Goals Achieved: </span>FUNCTIONS TO BE SET UP</h2>

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
                <x-dropdown>
                    <x-slot name="trigger">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('performance-profiles.show', $performanceProfile)">
                            @if ($user->hasRole('Client') || ($user->hasRole('Admin') && $performanceProfile->practitioner_feedback != null))
                                    {{ __('Show') }}
                            @elseif ($user->hasRole('Admin') && $performanceProfile->practitioner_feedback == null)
                                    {{ __('Show and Provide Feedback') }}
                            @endif
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                
            </div>

        @endforeach
        @endif
    


       
    </div>
</x-app-layout>