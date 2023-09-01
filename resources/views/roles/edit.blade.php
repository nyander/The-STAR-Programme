<x-app-layout>
    <div class="mt-6 rounded-lg max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between items-center mb-10">
            <h2 class="font-medium text-lg">Edit Role</h2>
        </div>

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

        <form method="POST" action="{{ route('roles.update', $role->id) }}" class="mt-4">
            @csrf
            @method('PATCH')

            <div class="name-section mb-4">
                <div class="flex items-center justify-between">
                    <div class="label">
                        <h3 class="text-base">Name</h3>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <input type="text" name="name" placeholder="Name" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" value="{{ $role->name }}" />
                    </div>
                </div>
            </div>

            <div class="permission-section mb-4">
                <div class="flex items-center justify-between">
                    <div class="label">
                        <h3 class="text-base">Permission</h3>
                    </div>
                </div>
                <div class="field">
                    @foreach($permission as $value)
                        <label class="flex items-center">
                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="form-checkbox border-gray-300 rounded" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }} />
                            <span class="ml-2">{{ $value->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                <x-primary-button>{{ __('Submit') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
