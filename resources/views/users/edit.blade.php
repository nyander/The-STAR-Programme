<x-app-layout>
    <div class="mt-6 rounded-lg max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="flex justify-between items-center mb-10">
            <h2 class="font-medium text-lg">Edit User</h2>

            <div class="flex justify-end mb-4">
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-base">Back</a>
            </div>
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

        <form method="POST" action="{{ route('users.update', $user) }}" class="mt-4">
            @csrf
            @method('patch')
            {{-- Name field --}}
            <div class="name-section mb-4 relative">
                <div class="flex items-center justify-between">
                    <div class="label">
                        <h3 class="text-base">Name</h3>
                    </div>
                    <div class="question-mark">
                        <span class="text-gray-400 cursor-help question-mark-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm0-4a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </span>
                        <div
                            class="absolute hidden bg-white border border-gray-300 rounded-md shadow-lg text-gray-700 text-sm p-2 mt-1 w-4/6 z-10 question-mark-text">
                            Please provide a suitable name for the user.
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <input type="text" name="name"
                            placeholder="{{ __("Enter user's full name") }}"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            value="{{ old('name', $user->name) }}" />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email Field --}}
            <div class="email-section mb-4 relative">
                <div class="flex items-center justify-between">
                    <div class="label">
                        <h3 class="text-base">Email</h3>
                    </div>
                    <div class="question-mark">
                        <span class="text-gray-400 cursor-help question-mark-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm0-4a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </span>
                        <div
                            class="absolute hidden bg-white border border-gray-300 rounded-md shadow-lg text-gray-700 text-sm p-2 mt-1 w-4/6 z-10 question-mark-text">
                            Please provide user's email for the user.
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <input type="email" name="email"
                            placeholder="{{ __("Enter user's email") }}"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            value="{{ old('email', $user->email) }}" />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>


            {{-- Password Field --}}
            <div class="password-section mb-4 relative">
                <div class="flex items-center justify-between">
                    <div class="label">
                        <h3 class="text-base">Generate New Password</h3>
                    </div>
                    <div class="question-mark">
                        <span class="text-gray-400 cursor-help question-mark-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm0-4a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </span>
                        <div
                            class="absolute hidden bg-white border border-gray-300 rounded-md shadow-lg text-gray-700 text-sm p-2 mt-1 w-4/6 z-10 question-mark-text">
                            We will not display the user's password, however, you will be able to replace it.
                        </div>
                    </div>
                </div>
                <div class="field flex items-center">
                    <input type="password" name="password"
                        placeholder="{{ __("Set a password") }}"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        value="{{ old('password') }}" oninput="this.setAttribute('value', this.value);" />
                
                    <button type="button" onclick="generatePassword()" class="ml-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded text-base">Generate</button>
                </div>
                <div id="generated-password" class="text-gray-700 mt-2"></div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Roles Field --}}
            <div class="role-section mb-4 relative">
                <div class="flex items-center justify-between">
                    <div class="label">
                        <h3 class="text-base">Role {{ $user->getRoleNames()->get(0) }}</h3>
                    </div>
                    <div class="question-mark">
                        <span class="text-gray-400 cursor-help question-mark-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm0-4a1 1 0 100-2 1 1 0 000 2z" />
                            </svg>
                        </span>
                        <div
                            class="absolute hidden bg-white border border-gray-300 rounded-md shadow-lg text-gray-700 text-sm p-2 mt-1 w-4/6 z-10 question-mark-text">
                            Please select a role for the user
                        </div>
                    </div>
                </div>
            
                <div class="field">
                    @foreach($roles as $role)
                        <label class="flex items-center">
                            <input type="checkbox" name="role[]" value="{{ $role->id }}" class="form-checkbox border-gray-300 rounded" {{ in_array($role->name, $userRole) ? 'checked' : '' }} />
                            <span class="ml-2">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
            </div>

            <x-primary-button>{{ __('Submit') }}</x-primary-button>

        </form>
    </div>
    <script>
        const questionMarkIcons = document.querySelectorAll('.question-mark-icon');
        const questionMarkTexts = document.querySelectorAll('.question-mark-text');

        questionMarkIcons.forEach((questionMarkIcon, index) => {
            questionMarkIcon.addEventListener('click', () => {
                questionMarkTexts[index].classList.toggle('hidden');
            });
        });

        document.addEventListener('click', (event) => {
            const target = event.target;

            if (!target.closest('.question-mark-text') && !target.closest('.question-mark-icon')) {
                questionMarkTexts.forEach((questionMarkText) => {
                    questionMarkText.classList.add('hidden');
                });
            }
        });

        function generatePassword() {
            const passwordField = document.querySelector('input[name="password"]');
            const generatedPassword = generateRandomPassword();
            passwordField.value = generatedPassword;
            passwordField.setAttribute('value', generatedPassword);

            const generatedPasswordField = document.querySelector('#generated-password');
            generatedPasswordField.textContent = `Generated Password: ${generatedPassword}`;
        }

        function generateRandomPassword() {
            // Add your code to generate a random password
            // Here's an example using a simple random string generation
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let password = '';
            for (let i = 0; i < 10; i++) {
                password += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return password;
        }
    </script>
</x-app-layout>
