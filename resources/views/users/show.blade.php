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
        <div class="flex justify-between items-center mb-10">
            <h2 class="font-medium text-lg">Show User</h2>

            <div class="flex justify-end mb-4">
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-base">Back</a>
            </div>
        </div>

        <div class="name-section mb-4">
            <div class="flex items-center justify-between">
                <div class="label">
                    <h3 class="text-base">Name</h3>
                </div>
            </div>
            <div class="field">
                <div class="relative">
                    <p>{{ $user->name }}</p>
                </div>
            </div>
        </div>

        <div class="email-section mb-4">
            <div class="flex items-center justify-between">
                <div class="label">
                    <h3 class="text-base">Email</h3>
                </div>
            </div>
            <div class="field">
                <div class="relative">
                    <p>{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="role-section mb-4">
            <div class="flex items-center justify-between">
                <div class="label">
                    <h3 class="text-base">Roles</h3>
                </div>
            </div>
            <div class="field">
                <div class="relative">
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <span class="badge badge-success">{{ $v }}</span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
