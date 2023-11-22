<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
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
        <form method="POST" action="{{ route('client.register') }}">
            @csrf

            <h3 class="font-semibold text-lg mb-4">Registeration</h3>
            <div class="p-6 bg-white rounded shadow mb-4">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="password-section mt-4 relative">
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

            </div>





            <div class="">
                <h3 class="font-semibold text-lg mb-4">Client Overview</h3>

                <div class="session-preferences p-6 bg-white rounded shadow mb-4">
                    <h4 class="font-semibold text-base mb-4">Availability & Session Preferences</h4>

                    <div class="mt-4">
                        <x-input-label for="preferred_days" :value="__('Preferred Days')" />
                        <select id="preferred_days" name="preferred_days"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                            <option value="">Select a day</option>
                            <option value="Monday" {{ old('preferred_days') === 'Monday' ? 'selected' : '' }}>Monday</option>
                            <option value="Tuesday" {{ old('preferred_days') === 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Wednesday" {{ old('preferred_days') === 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Thursday" {{ old('preferred_days') === 'Thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="Friday" {{ old('preferred_days') === 'Friday' ? 'selected' : '' }}>Friday</option>
                            <option value="Saturday" {{ old('preferred_days') === 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ old('preferred_days') === 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>
                        <x-input-error :messages="$errors->get('preferred_days')" class="mt-2" />
                    </div>
                    
                    <div class="mt-4">
                        <x-input-label for="preferred_times" :value="__('Preferred Times')" />
                        <input type="text" id="preferred_times" name="preferred_times"
                            placeholder="{{ __('Preferred Times (e.g., 9:00 AM - 11:00 AM)') }}"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            value="{{ old('preferred_times') }}"
                        />
                        <x-input-error :messages="$errors->get('preferred_times')" class="mt-2" />
                    </div>
                    
                    <div class="mt-4">
                        <x-input-label for="program_duration" :value="__('Program Duration')" />
                        <input type="number" id="program_duration" name="program_duration" min="1"
                            placeholder="{{ __('Number of sessions or duration in weeks') }}"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            value="{{ old('program_duration') }}"
                            required
                        />
                        <x-input-error :messages="$errors->get('program_duration')" class="mt-2" />
                    </div>  
                    
                    <div class="mt-4">
                        <x-input-label for="performance_profile_template" :value="__('Performance Profile')" />
                        <select id="performance_profile_template" name="performance_profile_template"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                            <option value="">Select a performance profile</option>
                            @foreach($performanceProfiles as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('performance_profile_template')" class="mt-2" />
                    </div>
                    
                    
                </div>

                <div class="contact p-6 bg-white rounded shadow mb-4">
                    <h4 class="font-semibold text-base mb-4">Contact Details</h4>
                    {{-- Phone Number --}}
                    <div>
                        <x-input-label for="phone_number" :value="__('Phone Number')" />
                        <x-text-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')"  />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>

                    
                    {{-- City --}}
                    <div class="mt-4">
                        <x-input-label for="city" :value="__('City')" />
                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')"  />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>

                    {{-- State --}}
                    <div class="mt-4">
                        <x-input-label for="state" :value="__('State/Province')" />
                        <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state')"  />
                        <x-input-error :messages="$errors->get('state')" class="mt-2" />
                    </div>
                    
                    {{-- Postal Code/Zip Code --}}
                    <div class="mt-4">
                        <x-input-label for="postal_code" :value="__('Postal Code/ZIP Code')" />
                        <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')"  />
                        <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                    </div>
                    
                    {{-- Country --}}
                    <div class="mt-4">
                        <x-input-label for="country" :value="__('Country')" />
                        <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')"  />
                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                    </div>

                    {{-- Emergency Contact Name --}}
                    <div class="mt-4">
                        <x-input-label for="emergency_contact_name" :value="__('Emergency Contact Name')" />
                        <x-text-input id="emergency_contact_name" class="block mt-1 w-full" type="text" name="emergency_contact_name" :value="old('emergency_contact_name')"  />
                        <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                    </div>

                    
                    {{-- Emergency Contact Phone Number --}}
                    <div class="mt-4">
                        <x-input-label for="emergency_contact_phone" :value="__('Emergency Contact Phone Number')" />
                        <x-text-input id="emergency_contact_phone" class="block mt-1 w-full" type="tel" name="emergency_contact_phone" :value="old('emergency_contact_phone')"  />
                        <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                    </div>
                </div>

                <div class="sports-background p-6 bg-white rounded shadow mb-4">
                    <h4 class="font-semibold text-base mb-4">Sport and Background Information</h4>

                    {{-- Sport --}}
                    <div>
                        <x-input-label for="current_sport" :value="__('Sport')" />
                        <x-text-input id="current_sport" class="block mt-1 w-full" type="text" name="current_sport" :value="old('current_sport')"  />
                        <x-input-error :messages="$errors->get('current_sport')" class="mt-2" />
                    </div>

                    {{-- Experience Level --}}
                    <div class="mt-4">
                        <x-input-label for="experience_level" :value="__('Experience Level')" />
                        <x-text-input id="experience_level" class="block mt-1 w-full" type="text" name="experience_level" :value="old('experience_level')"  />
                        <x-input-error :messages="$errors->get('experience_level')" class="mt-2" />
                    </div>
                    

                    {{-- Athletic Background
                    <div class="mt-4">
                        <x-input-label for="athletic_background" :value="__('Athletic Background')" />
                        <textarea id="athletic_background" name="athletic_background"
                            placeholder="{{ __('Athletic Background') }}"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >{{ old('athletic_background') }}</textarea>
                        <x-input-error :messages="$errors->get('athletic_background')" class="mt-2" />
                    </div> --}}
                    
                </div>

                {{-- <div class="consentandAgreement-background p-6 bg-white rounded shadow mb-4">
                    <div class="mt-4">
                        <x-input-label for="consent" :value="__('Consent')" />
                        <div class="flex items-center">
                            <input type="checkbox" name="consent" id="consent"
                                class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                {{ old('consent') ? 'checked' : '' }}
                            >
                            <label for="consent" class="ml-2">
                                I consent to participate in the coaching program and agree to the <a href="{{ route('files.show', $file->id) }}" class="text-blue-800 font-bold hover:underline" target="_blank">Terms & Conditions</a>.
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('consent')" class="mt-2" />
                    </div>
                    
                    <div class="mt-4">
                        <x-input-label for="confidentiality" :value="__('Confidentiality and Privacy')" />
                        <div class="flex items-center">
                            <input type="checkbox" name="confidentiality" id="confidentiality"
                                class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                {{ old('confidentiality') ? 'checked' : '' }}
                            >
                            <label for="confidentiality" class="ml-2">
                                {{ __('I agree to maintain confidentiality and respect the privacy of all information shared during the coaching program.') }}
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('confidentiality')" class="mt-2" />
                    </div>
                </div> --}}
                
            </div>



            <div class="flex items-center justify-end mt-4">

                <x-primary-button class="ml-4">
                    {{ __('Register New Client') }}
                </x-primary-button>
            </div>
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
