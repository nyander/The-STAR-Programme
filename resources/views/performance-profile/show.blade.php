@extends('layouts.standard')

@section('content')
    <div class="mt-6 rounded-lg  mx-8 bg-white md:p-8">
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

        <div class=" bg-gray-100 p-4 md:p-10">
            <h2 class="text-2xl font-semibold mb-4">Performance Profile: {{ $performanceProfile->performanceProfileTemplate->title }}</h2>

            <div class="mb-6">
                <p>{{ $performanceProfile->performanceProfileTemplate->description }}</p>
            </div>

            
            @php
                $currentCategory = '';

                $answers = $performanceProfile->answers()->with('question')->get();
                $groupedAnswers = $answers->groupBy(function ($answer) {
                    return optional($answer->question)->performance_categories ?? 'No Category';
                });

            @endphp

            <div class="grid lg:grid-cols-2 gap-4">
                @foreach ($groupedAnswers as $categoryId => $questionsInCategory)
                    @php
                        $categoryName = '';
                        if (!empty($categoryId)) {
                            $categoryName = App\Models\PerformanceCategory::find($categoryId)->category;
                            $categoryColour = App\Models\PerformanceCategory::find($categoryId)->colour;
                        }
                    @endphp

                    <div class="border-4 mb-4 p-8 rounded-md drop-shadow bg-white" style="border-color: {{ $categoryColour }}">
                        @if (!empty($categoryName))
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold uppercase">{{ $categoryName }}</h3>
                                @foreach ($questionsInCategory as $question)
                                    <div class="mb-6">
                                        @if ($question->question_type == 'text')
                                            <div class="text-section relative">
                                                <div class="flex items-center justify-between mb-4">
                                                    <div class="label">
                                                        <h3 class="text-base">{{ $question->question_text }}</h3>
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <div class="relative">
                                                        <input type="text" name=""
                                                            placeholder=""
                                                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                            value="{{ $question->answers }}" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($question->question_type == 'textarea')
                                        <div class="text-section mb-4 relative">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="label">
                                                    <h3 class="text-base">{{ $question->question_text }}</h3>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <div class="relative">
                                                    <textarea name="answer"
                                                            placeholder=""
                                                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                    disabled>{{ $question->answers }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif ($question->question_type == 'select')
                                            <div class="text-section relative">
                                                <div class="flex items-center justify-between mb-4">
                                                    <div class="label">
                                                        <h3 class="text-base">{{ $question->question_text }}</h3>
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <div class="relative">
                                                        <select name="selectValue" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" disabled>
                                                          <option value="{{ $question->answers }}">{{ $question->answers }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($question->question_type == 'radio')
                                            <div class="text-section mb-4 relative">
                                                <div class="flex items-center justify-between mb-4">
                                                    <div class="label">
                                                        <h3 class="text-base">{{ $question->question_text }}</h3>
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <div class="relative">
                                                        <div>
                                                            <input type="radio" name="{{ $question->answers }}" id="{{ $item }}" class="@error($question->title) border-red-500 @enderror" />
                                                            <label for="{{ $question->answers }}" class="ml-2">{{ $question->answers }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($question->question_type == 'scale')
                                            <div class="text-section mb-4 relative">
                                                <div class="flex items-center justify-between mb-4">
                                                    <div class="label">
                                                        <h3 class="text-base">{{ $question->question_text }}</h3>
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <div class="relative">
                                                        <div>
                                                            <input type="radio" name="{{ $question->answers }}" id="{{ $item }}" class="@error($question->title) border-red-500 @enderror" />
                                                            <label for="{{ $question->answers }}" class="ml-2">{{ $question->answers }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
    
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($performanceProfile->practitioner_feedback == null && Auth::user()->hasRole('Admin'))
                <div class="mx-auto mt-10">
                    <form method="POST" action="{{ route('performance-profiles.addFeedback', $performanceProfile) }}" class="mt-4">
                        @csrf
                        <div class="text-section mb-4 relative md:p-8 bg-grey-100 border-t-4 border-primary">
                            <div class="flex items-center justify-between">
                                <div class="label">
                                    <h3 class="text-2xl font-semibold">Practitioner's feedback</h3>
                                </div>
                            </div>
                            

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4 mb-8">
                                <div class="field">
                                    <div class="border-green-600 border-4 p-4 bg-white rounded-md mt-8">
                                        <label for="strengths">Main Strengths</label>
                                        <textarea name="strengths" id="strengths"
                                            placeholder="Please provide client's strengths"
                                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        ></textarea>
                                    </div>
                                </div>
    
                                <div class="field">
                                    <div class="border-red-600 border-4 p-4 bg-white rounded-md mt-8">
                                        <label for="strengths">Main Areas To Work On</label>
                                        <textarea name="weakness" id="weakness"
                                            placeholder="Please provide areas which client should work on"
                                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="field border-primary border-4 p-4 bg-white rounded-md">
                                <label for="strengths">Practitioner Feedback</label>
                                <textarea name="practitioner_feedback" id="practitioner_feedback"
                                    placeholder="Please provide feedback"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                ></textarea>
                            </div>

                            <x-primary-button class="bg-primary mt-8">{{ __('Submit Feedback') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            @else 
                    <div class="text-section mb-4 relative mt-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="label">
                                @if ($performanceProfile->practitioner)
                                    <h3 class="font-bold text-2xl">Practitioner Feedback: {{ $performanceProfile->practitioner->name }}</h3>
                                @else
                                    <h3 class="font-bold text-2xl">Practitioner Feedback</h3>
                                @endif
                            </div>
                        </div>
                        <div class="field">
                            <div class="relative">
                                <div class="bg-white p-8 border-primary border-4 rounded">
                                    <div class="label mb-2 uppercase">
                                        <h3 class="text-base font-bold">Practitioner Feedback</h3>
                                    </div>

                                    <p class="py-2">
                                        {{ $performanceProfile->practitioner_feedback }}
                                    </p>
                                </div>


                                <div class="grid grid-cols-2 gap-4 mt-8">

                                    <div class="bg-white p-8 border-green-500 border-4 rounded">
                                        <div class="label mb-2 uppercase">
                                            <h3 class="text-base font-bold">Main Strengths</h3>
                                        </div>
    
                                        <p class="py-2">
                                            {{ $performanceProfile->strengths }}
                                        </p>
                                    </div>


                                    <div class="bg-white p-8 border-red-500 border-4 rounded">
                                        <div class="label mb-2 uppercase">
                                            <h3 class="text-base font-bold">Main Areas To Work On</h3>
                                        </div>
    
                                        <p class="py-2">
                                            {{ $performanceProfile->weakness }}
                                        </p>
                                    </div>
    
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
            @endif 

        </div>
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
    </script>
@endsection
