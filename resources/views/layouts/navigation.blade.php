<nav x-data="{ open: false }" class=" mx-8 max-h-20 py-2 rounded">
    <!-- Primary Navigation Menu -->
    <div class=" bg-white border-b border-gray-100 mx-auto px-4 md:px-6 lg:px-8 rounded">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 font-semibold">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current font-semibold" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 md:-my-px md:ml-10 md:flex">
                


                    {{-- @if (Auth::user()->hasRole('Client')) --}}
                    @can('performance-profile-list')
                        <x-nav-link :href="route('performance-profiles.index')" :active="request()->routeIs('performance-profiles.index')">
                            {{ __('Performance Profiles') }}
                        </x-nav-link>
                    @endcan
                        
                    {{-- @endif --}}
                    
                    {{-- @if (Auth::user()->hasRole('Admin')) --}}
                    @can('client-overview-access')
                        <x-nav-link :href="route('users.clients')" :active="request()->routeIs('users.clients')">
                            {{ __('Client Overview') }}
                        </x-nav-link>
                    @endcan
                    
                    {{-- @endif --}}
                    @can('client-enquiry-access')
                        <x-nav-link :href="route('enquiries.index')" :active="request()->routeIs('enquiries.index')">
                            {{ __('Consultation') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            @guest
                @if (Route::has('login'))
                    <div class="flex items-center space-x-2 hidden md:flex">
                        <x-nav-link :href="route('login')">
                            {{ __('Login') }}
                        </x-nav-link>
                        {{-- <x-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-nav-link> --}}
                    </div>
                @endif
            @else
            
                <!-- Settings Dropdown -->
                <div class=" relative z-50 hidden md:flex md:items-center md:ml-6">
                    <x-dropdown align="right" class="w-80">
                        <x-slot name="trigger">
                            <a id="navbarDropdown" class="flex items-center space-x-1 cursor-pointer" href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-bell"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span class="badge badge-light text-teal-600 text-xs p-1">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>
                        </x-slot>
                    
                        <x-slot name="content">
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <x-dropdown-link :href="route('mark-as-read')" class="px-2 py-1 text-sm text-white bg-green-400 rounded-md hover:bg-green-600">
                                    {{ __('Mark All as Read') }}
                                </x-dropdown-link>
                            @endif

                            @if (auth()->user()->readNotifications->count() > 0)
                                <x-dropdown-link :href="route('clear-read')" class="px-2 py-1 mt-4 text-sm text-white bg-green-400 rounded-md hover:bg-green-600">
                                    {{ __('Clear all Read') }}
                                </x-dropdown-link>
                            @endif
                    
                            @php
                                $unreadCount = auth()->user()->unreadNotifications->count();
                                $readCount = 4 - $unreadCount;
                                $unreadNotifications = auth()->user()->unreadNotifications->take($unreadCount);
                                $readNotifications = auth()->user()->readNotifications->take($readCount);
                            @endphp
                    
                            @foreach ($unreadNotifications as $notification)
                                <x-dropdown-link :href="route('read-notification', $notification)" class="block text-sm font-medium text-green-500 hover:text-green-600">
                                    {{ $notification->data['data'] }}
                                </x-dropdown-link>
                            @endforeach
                    
                            @foreach ($readNotifications as $notification)
                                <x-dropdown-link :href="route('read-notification', $notification)" class="block text-sm font-medium text-gray-500 hover:text-gray-600">
                                    {{ $notification->data['data'] }}
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                    

                    <div class="relative z-50">
                        <x-dropdown align="right" width="48" class="relative z-50">
                            <x-slot name="trigger">
                                <button class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div class="text-right">
                                        <p>{{ Auth::user()->name }}</p>
                                    </div>
                                    
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @can('enroll-client')
                                    <x-dropdown-link :href="route('client.create')">
                                        {{ __('Enroll Client') }}
                                    </x-dropdown-link>
                                @endcan

                                @can('post-feedback-overview-list')
                                    <x-dropdown-link :href="route('feedbacks.index')">
                                        {{ __('Post Program Feedback') }}
                                    </x-dropdown-link>
                                @endcan
                                


                                @can('performance-profile-template-list')
                                    <x-dropdown-link :href="route('performance-profile-templates.index')">
                                        {{ __('Performance Templates') }}
                                    </x-dropdown-link>
                                @endcan

                                <x-dropdown-link :href="route('users.index')">
                                    {{ __('User Management') }}
                                </x-dropdown-link>

                                @can('category-management-access')
                                    <x-dropdown-link :href="route('categories.index')">
                                        {{ __('Manage Categories') }}
                                    </x-dropdown-link>
                                @endcan
                                
                                @can('role-list')
                                    <x-dropdown-link :href="route('roles.index')">
                                        {{ __('Manage Roles') }}
                                    </x-dropdown-link>
                                @endcan

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            @endguest

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden relative z-50 bg-white block">
        @guest
            @if (Route::has('login'))
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
            @endif

            @if (Route::has('register'))
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            @endif
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

            <div class="pt-2 pb-3 space-y-1">
                @can('performance-profile-list')
                    <x-responsive-nav-link :href="route('performance-profiles.index')" :active="request()->routeIs('performance-profiles.index')">
                        {{ __('Performance Profiles') }}
                    </x-responsive-nav-link>
                @endcan
            </div>

            <div class="pt-2 pb-3 space-y-1">
                @can('client-overview-access')
                    <x-responsive-nav-link :href="route('users.clients')" :active="request()->routeIs('users.clients')">
                        {{ __('Client Overview') }}
                    </x-responsive-nav-link>
                @endcan
            </div>

            <div class="pt-2 pb-3 space-y-1">
                @can('client-enquiry-access')
                    <x-responsive-nav-link :href="route('enquiries.index')" :active="request()->routeIs('enquiries.index')">
                        {{ __('Consultation') }}
                    </x-responsive-nav-link>
                @endcan
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @can('client-overview-access')
                        <x-responsive-nav-link :href="route('client.create')">
                            {{ __('Enroll Client') }}
                        </x-responsive-nav-link>
                    @endcan
                    
                    @can('post-feedback-overview-list')
                        <x-responsive-nav-link :href="route('feedbacks.index')">
                            {{ __('Post Program Feedback') }}
                        </x-responsive-nav-link>
                    @endcan

                    @can('performance-profile-template-list')
                        <x-responsive-nav-link :href="route('performance-profile-templates.index')">
                            {{ __('Performance Templates') }}
                        </x-responsive-nav-link>
                    @endcan

                    <x-responsive-nav-link :href="route('users.index')">
                        {{ __('User Management') }}
                    </x-responsive-nav-link>

                    @can('category-management-access')
                        <x-responsive-nav-link :href="route('categories.index')">
                            {{ __('Manage Categories') }}
                        </x-responsive-nav-link>
                    @endcan

                    @can('role-list')
                        <x-responsive-nav-link :href="route('roles.index')">
                            {{ __('Manage Roles') }}
                        </x-responsive-nav-link>
                    @endcan
                    





                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>
