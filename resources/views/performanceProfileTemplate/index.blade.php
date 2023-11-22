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


        
        <div class="pr-4 p-8">
            <div class="flex justify-between">
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold mb-0">Performance Profile Templates</h2>
                </div>

                <x-dropdown>
                    <x-slot name="trigger">
                        <button class="bg-primary text-white px-8 py-1 rounded font-semibold">
                            Options
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('performance-profile-templates.create')">
                            {{ __('Create New Template') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('categories.index')">
                            {{ __('Manage Categories') }}
                        </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>    
            <div class="grid md:grid-cols-3 gap-4">
                @foreach ($performanceProfiles as $performanceProfileTemplate)
                    <div class="p-6 bg-white flex rounded shadow justify-between">
                        <div>
                            <h3 class="font-semibold">{{ $performanceProfileTemplate->title }}</h3>
                            <h2 class="text-sm mb-1"><span class="">Clients Applied:</span></h2>
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
                                    <x-dropdown-link :href="route('performance-profile-templates.edit', $performanceProfileTemplate)">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('performance-profile-templates.questions.index', $performanceProfileTemplate)">
                                        {{ __('Manage Questions') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('performance-profile-templates.destroy', $performanceProfileTemplate) }}">
                                        @csrf
                                        @method('delete')
                                        <x-dropdown-link :href="route('performance-profile-templates.destroy', $performanceProfileTemplate)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                    </div>
                @endforeach
            </div> 
            
        </div>
    </div>
@endsection