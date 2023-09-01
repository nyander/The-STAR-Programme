<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 mt-5 rounded-lg mx-8 bg-white p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            @if (Auth::user()->hasRole('Admin'))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">  
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Manage Terms & Conditions') }}
                        </h2>

                        <div>
                            Current Terms & conditions: <a href="{{ route('files.show', $file->id) }}" class="text-blue-800 font-bold hover:underline">Terms & Conditions</a>
                        </div>

                        <div class="my-4">
                            @include('files.create')
                        </div>
                        
                    </div>

                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>
