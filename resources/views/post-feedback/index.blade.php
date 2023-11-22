<x-app-layout>
    <div class="mt-5 rounded-lg mx-8 bg-white p-8">
        <div class="mx-8 sm:p-8 lg:p-6 bg-white">
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

            <div class="flex">
                <div class="w-7/12 pr-4">
                    <h2 class="text-2xl font-semibold mb-6">Client Feedback</h2>
                    @foreach ($postFeedbacks as $feedback)
                        <a href="{{ route('feedbacks.show', $feedback) }}">
                            <div class="p-6 {{$feedback->practitioner_completion == false || $feedback->client_completion == false ? 'bg-red-100' : 'bg-white'}} 
                                rounded shadow flex justify-between drop-shadow-md">
                                <div>
                                    <h3 class="font-semibold text-lg">Richard Nyande</h3>
                                    <div>
                                        <h2 class="text-sm mb-1">
                                            <span class="font-semibold">Client's Feedback:</span>
                                            {{ $feedback->client_completion ? 'Complete' : 'Incomplete' }}
                                        </h2>
                                        <h2 class="text-sm mb-1">
                                            <span class="font-semibold">Practitioner's Feedback:</span>
                                            {{ $feedback->practitioner_completion ? 'Complete' : 'Incomplete' }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="w-5/12">

                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>