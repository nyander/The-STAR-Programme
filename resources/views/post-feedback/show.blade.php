<x-app-layout>
    <div class="mt-6 rounded-lg mx-8 bg-white p-8">
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

        <div class="bg-gray-100 p-16 px-32">
            <div class="flex items-center justify-between">
                <div class="left mb-8">
                    <div class="text-2xl font-semibold ">Post Program</div>
                    <div class="text-lg font-semibold ">Client Feedback</div>
                    <h2 class="text-sm mb-1">
                        <span class="font-semibold">Client's Feedback:</span>
                        {{ $feedback->client_completion ? 'Complete' : 'Incomplete' }}
                    </h2>
                    <h2 class="text-sm mb-1">
                        <span class="font-semibold">Practitioner's Feedback:</span>
                        {{ $feedback->practitioner_completion ? 'Complete' : 'Incomplete' }}
                    </h2>
                </div>
                @if (Auth::user()->hasRole('Admin') && !$feedback->practitioner_completion)
                    <div class="right">
                        <a href="{{ route('client.completion', $feedback->user->id) }}" class="bg-gray-800 text-white px-4 py-2 rounded-md">Add Practitioner's Feedback</a>
                    </div>
                @endif
                
            </div>
            

            <div class="client-feedback rounded mb-4">
                <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                    <label for="">Overall, how would you describe your experience with the program?</label>
                    <textarea name="client_experience" id="client_experience" 
                    class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                    disabled>{{ $feedback->client_experience }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mt-4 border-green-600 border-4 p-4 bg-white rounded-md">
                        <label for="">What aspects of the program went well?</label>
                        <textarea name="client_positive_feedback" id="client_positive_feedback" 
                        class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                        disabled>{{ $feedback->client_positive_feedback }}</textarea>
                    </div>

                    <div class="mt-4 border-red-600 border-4 p-4 bg-white rounded-md">
                        <label for="">What aspects of the program did not go well?</label>
                        <textarea name="client_areas_to_improve" id="client_areas_to_improve" 
                        class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                        disabled>{{ $feedback->client_areas_to_improve }}</textarea>
                    </div>
                </div>

                <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                    <label for="">Were there any challenges or difficulties you faced during the program, and how did you handle them?</label>
                    <textarea name="client_challenges" id="client_challenges" 
                    class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                    disabled>{{ $feedback->client_challenges }}</textarea>
                </div>

                <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                    <label for="">Would you be willing to provide a testimony regarding your experience with the program? If so, please enter below.</label>
                    <textarea name="client_testimonies" id="client_testimonies" 
                    class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                    disabled>{{ $feedback->client_testimonies }}</textarea>
                </div>

                <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                    <label for="">Is there anything else you would like to share or any additional feedback you have for us?</label>
                    <textarea name="client_comments" id="client_comments" 
                    class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                    disabled>{{ $feedback->client_comments }}</textarea>
                </div>
            </div>

            @if ($feedback->practitioner_completion == true)
                <div class="text-lg font-semibold mt-14 mb-8">Practitioner Feedback</div>

                <div class="practitioner-feedback rounded mb-4">
                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <label for="">Did the client achieve their initial consultation goals?</label>
                        <textarea name="practitioner_client_achieve" id="practitioner_client_achieve" 
                        class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                        disabled>{{ $feedback->practitioner_client_achieve }}</textarea>
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <label for="">How do you assess the client's progress throughout the program?</label>
                        <textarea name="practitioner_progress_review" id="practitioner_progress_review" 
                        class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                        disabled>{{ $feedback->practitioner_progress_review }}</textarea>
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <label for="">What specific strategies or techniques were most effective for the client?</label>
                        <textarea name="practitioner_achievement_review" id="practitioner_achievement_review" 
                        class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                        disabled>{{ $feedback->practitioner_achievement_review }}</textarea>
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <label for="">What aspects of the client’s mental skills still need improving?</label>
                        <textarea name="practitioner_challenge_review" id="practitioner_challenge_review" 
                        class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                        disabled>{{ $feedback->practitioner_challenge_review }}</textarea>
                    </div>

                    <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                        <label for="">What advice do you have to help the client to maintain their newfound mindset?</label>
                        <textarea name="practitioner_suggestion" id="practitioner_suggestion" 
                        class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                        disabled>{{ $feedback->practitioner_suggestion }}</textarea>
                    </div>
                </div>
            @endif

        </div>
        
    </div>
    
</x-app-layout>