<x-app-layout>
    <div class="mt-6 rounded-lg  mx-8 bg-white p-8">
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

        @if (Auth::user()->hasRole('Client'))
            <form method="POST" action="{{ route('client.storeCompletion', $client) }}" class="bg-gray-100 p-16 px-32">
                @csrf
                @method('put')
                <!-- Client Feedback -->
                <h2 class="text-2xl font-semibold mb-8">Post Program (Client)</h2>
                

                <div class="rounded mb-4">
                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Overall Experience -->
                        <x-input-label :value="__('Overall, how would you describe your experience with the program?')" />
                        <textarea id="client_experience" name="client_experience"
                            class="block mt-1 w-full rounded-md border-2 p-2 border-gray-300 bg-gray-50"
                            required>{{ old('client_experience') }}</textarea>
                        <x-input-error :messages="$errors->get('client_experience')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mt-4 border-green-600 border-4 p-4 bg-white rounded-md">
                            <!-- What Went Well -->
                            <x-input-label :value="__('What aspects of the program went well?')" />
                            <textarea id="client_positive_feedback" name="client_positive_feedback"
                                class=" block mt-1 w-full rounded-md border-2 p-2 border-gray-300 bg-gray-50"
                                required>{{ old('client_positive_feedback') }}</textarea>
                            <x-input-error :messages="$errors->get('client_positive_feedback')" class="mt-2" />
                        </div>
    
                        <div class="mt-4 border-red-600 border-4 p-4 bg-white rounded-md">
                            <!-- What Did Not Go Well -->
                            <x-input-label :value="__('What aspects of the program did not go well?')" />
                            <textarea id="client_areas_to_improve" name="client_areas_to_improve"
                                class="block mt-1 w-full rounded-md border-2 p-2 border-gray-300 bg-gray-50"
                                required>{{ old('client_areas_to_improve') }}</textarea>
                            <x-input-error :messages="$errors->get('client_areas_to_improve')" class="mt-2" />
                        </div>
                    </div>

                    

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Challenges Faced -->
                        <x-input-label :value="__('Were there any challenges or difficulties you faced during the program, and how did you handle them?')" />
                        <textarea id="client_challenges" name="client_challenges"
                            class="block mt-1 w-full rounded-md border-2 p-2 border-gray-300 bg-gray-50"
                            required>{{ old('client_challenges') }}</textarea>
                        <x-input-error :messages="$errors->get('client_challenges')" class="mt-2" />
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Testimony -->
                        <x-input-label :value="__('Would you be willing to provide a testimony regarding your experience with the program? If so, please enter below.')" />
                        <textarea id="client_testimonies" name="client_testimonies"
                            class="block mt-1 w-full rounded-md border-2 p-2 border-gray-300 bg-gray-50"
                            required>{{ old('client_testimonies') }}</textarea>
                        <x-input-error :messages="$errors->get('client_testimonies')" class="mt-2" />
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Additional Feedback -->
                        <x-input-label :value="__('Is there anything else you would like to share or any additional feedback you have for us?')" />
                        <textarea id="client_comments" name="client_comments"
                            class="block mt-1 w-full rounded-md border-2 p-2 border-gray-300 bg-gray-50"
                            required>{{ old('client_comments') }}</textarea>
                        <x-input-error :messages="$errors->get('client_comments')" class="mt-2" />
                    </div>
                </div>
                <!-- End of Client Feedback -->


                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Update Client Overview') }}
                    </x-primary-button>
                </div>
            </form>




        @elseif (Auth::user()->hasRole('Admin'))
            <form method="POST" action="{{ route('client.storeAdminCompletion', $client) }}" class="bg-gray-100 p-16 px-32">
                @csrf
                @method('put')
                <!-- Client Feedback -->
                <h2 class="text-2xl font-semibold mb-4">Post Program (Practitioner)</h2>
                <div class="grid lg:grid-cols-2 mb-8">
                    <p>
                        Sorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur tempus urna at turpis condimentum lobortis.
                    </p>
                </div>
                <div class="rounded mb-4">
                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Progress Review -->
                        <x-input-label :value="__('Did the client achieve their initial Enuquiry board goals?')" />
                        <textarea id="practitioner_client_achieve" name="practitioner_client_achieve"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            required>{{ old('practitioner_client_achieve') }}</textarea>
                        <x-input-error :messages="$errors->get('practitioner_client_achieve')" class="mt-2" />
                    </div>
                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Progress Review -->
                        <x-input-label :value="__('How do you assess the client\'s progress throughout the program?')" />
                        <textarea id="practitioner_progress_review" name="practitioner_progress_review"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            required>{{ old('practitioner_progress_review') }}</textarea>
                        <x-input-error :messages="$errors->get('practitioner_progress_review')" class="mt-2" />
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Achievement Review -->
                        <x-input-label :value="__('What specific strategies or techniques were most effective for the client?')" />
                        <textarea id="practitioner_achievement_review" name="practitioner_achievement_review"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            required>{{ old('practitioner_achievement_review') }}</textarea>
                        <x-input-error :messages="$errors->get('practitioner_achievement_review')" class="mt-2" />
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Challenge Review -->
                        <x-input-label :value="__('What aspects of the client’s mental skills still need improving?')" />
                        <textarea id="practitioner_challenge_review" name="practitioner_challenge_review"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            required>{{ old('practitioner_challenge_review') }}</textarea>
                        <x-input-error :messages="$errors->get('practitioner_challenge_review')" class="mt-2" />
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Suggestions -->
                        <x-input-label :value="__('What advice do you have to help the client to maintain their newfound mindset?')" />
                        <textarea id="practitioner_suggestion" name="practitioner_suggestion"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            required>{{ old('practitioner_suggestion') }}</textarea>
                        <x-input-error :messages="$errors->get('practitioner_suggestion')" class="mt-2" />
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <!-- Mindset Review -->
                        <x-input-label :value="__('How can I continue to support the client after the program’s conclusion?')" />
                        <textarea id="practitioner_support" name="practitioner_support"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            required>{{ old('practitioner_support') }}</textarea>
                        <x-input-error :messages="$errors->get('practitioner_support')" class="mt-2" />
                    </div>
                </div>
                <!-- End of Client Feedback -->

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Update Client Overview') }}
                    </x-primary-button>
                </div>
            </form>
        @endif
        

        
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
