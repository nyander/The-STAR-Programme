<x-app-layout>
    <div class="mt-6 rounded-lg max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
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
       <div class="flex justify-between items-center">
            <h2 class="font-medium text-lg">User Management</h2>
            <div class="flex justify-end mb-4">
                <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded text-base">Create New User</a>
            </div>
       </div>
        @if ($message = Session::get('success'))
            <div class="bg-green-500 text-white p-4 mb-4">
                <p>{{ $message }}</p>
            </div>
        @endif
            <table class="border border-gray-300 w-full">
            <tr>
                <th class="border-b-2 border-gray-300 px-4 py-2">No</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Name</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Email</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Roles</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Action</th>
            </tr>
            @foreach ($data as $key => $user)
            <tr>
                <td class="border-b border-gray-300 px-4 py-2 text-center">{{ ++$i }}</td>
                <td class="border-b border-gray-300 px-4 py-2 text-center">{{ $user->name }}</td>
                <td class="border-b border-gray-300 px-4 py-2 text-center">{{ $user->email }}</td>
                <td class="border-b border-gray-300 px-4 py-2 text-center">
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                    @endif
                </td>
                <td class="border-b border-gray-300 px-4 py-2">
                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>Manage</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('users.show',$user->id)">
                                    {{ __('Show') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('users.edit',$user->id)">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-dropdown-link :href="route('users.destroy', $user->id)"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Delete User') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </td>
            </tr>
        @endforeach
        </table>

        <div class="pagination mt-4">
            {{ $data->links() }}
        </div>
    </div>
</x-app-layout>