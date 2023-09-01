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
            <a href="{{ route('goals.create', $client) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded text-base">Add New Goal</a>
        </div>
        @foreach ($clientGoals as $goal)
            <div class="p-6 flex space-x-2  {{ $goal->complete == true ? 'bg-green-100' : 'bg-white' }} my-4">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="font-semibold">{{ $goal->description }}</h1>
                            <h2 class="text-sm">Target: {{ $goal->goal }}</h2>
                            <h2 class="text-sm">Status: {{ $goal->complete == false ? 'Incomplete' : 'Complete' }}</h2>
                            @if ($goal->type == 'amount')
                                <h2 class="text-sm">Progress: {{ $goal->achieved }}/{{ $goal->goal }}</h2>
                            @endif

                            @if ($goal->complete == false && Auth::user()->id == $goal->client->id)
                                <div class="mt-4">
                                    <a href="{{ route('goals.updateGoal', $goal) }}" class="bg-green-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded text-base">Update Goal</a>
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
        @endforeach
    </div>
</x-app-layout>
