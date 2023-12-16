@extends('layouts.standard')

@section('content')
    <div class="mt-6 rounded-lg md:mx-8 bg-white md::p-8">
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

        

        <form method="POST" action="{{ route('performance-profiles.store') }}" class="bg-gray-100 p-10">

            <h2 class="text-2xl font-semibold mb-4">Performance Profile: {{ $performanceProfileTemplate->title }}</h2>

            <div class="mb-6">
                <p>{{ $performanceProfileTemplate->description }}</p>
            </div>


            @csrf
            <input type="text" name="performanceProfileTemplate" value="{{ $performanceProfileTemplate->id }}" hidden>
            
            @php
                $questionsByCategory = $performanceProfileQuestions->groupBy('performance_categories');
            @endphp


            <div class="grid lg:grid-cols-2 gap-4">
                @foreach ($questionsByCategory as $categoryId => $questionsInCategory)
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
                            </div>
                        @endif
                        @foreach ($questionsInCategory as $question)
                            <div class="mb-6">
                                @if ($question->type == "text")
                                    <div class="text-section relative">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="label">
                                                <h3 class="text-base">{{ $question->text }}</h3>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="relative">
                                                <input type="text" name="{{ $question->title }}"
                                                    placeholder=""
                                                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('{{ $question->title }}')" class="mt-2" />
                                    </div>
                                @elseif ($question->type == "textarea")
                                    <div class="text-section mb-4 relative">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="label">
                                                <h3 class="text-base">{{ $question->text }}</h3>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="relative">
                                                <textarea name="{{ $question->title }}" id="{{ $question->title }}"
                                                        placeholder=""
                                                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                ></textarea>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('{{ $question->title }}')" class="mt-2" />
                                    </div>
                                @elseif ($question->type == "select")
                                    <div class="text-section relative">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="label">
                                                <h3 class="text-base">{{ $question->text }}</h3>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="relative">
                                                <select name="{{ $question->title }}" id="{{ $question->title }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('{{ $question->title }}') border-red-500 @enderror">
                                                    @php
                                                        $jsonText = $question->options;
                                                        $items = json_decode($jsonText);
                                                    @endphp
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item }}">{{ $item }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('{{ $question->title }}')" class="mt-2" />
                                    </div>
                                @elseif ($question->type == "radio")
                                    <div class="text-section mb-4 relative">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="label">
                                                <h3 class="text-base">{{ $question->text }}</h3>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <div class="relative">
                                                @php
                                                    $jsonText = $question->options;
                                                    $items = json_decode($jsonText);
                                                @endphp
                                                @foreach ($items as $item)
                                                    <div>
                                                        <input type="radio" name="{{ $question->title }}" id="{{ $item }}" value="{{ $item }}" class="@error($question->title) border-red-500 @enderror" />
                                                        <label for="{{ $item }}" class="ml-2">{{ $item }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get($question->title)" class="mt-2" />
                                    </div>
                                @elseif ($question->type == "scale")
                                    <div class="text-section relative">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="label">
                                                <h3 class="text-base">{{ $question->text }}</h3>
                                            </div>
                                        </div>
                                        <div class="field flex space-x-2">
                                            @php
                                                $jsonText = $question->options;
                                                $items = json_decode($jsonText);
                                            @endphp
                                            @foreach ($items as $item)
                                                <div>
                                                    <input type="radio" class="hidden scale-radio @error($question->title) border-red-500 @enderror" name="{{ $question->title }}" id="{{ $question->title }}_{{ $item }}" value="{{ $item }}" />
                                                    <label for="{{ $question->title }}_{{ $item }}" class="scale-label cursor-pointer">{{ $item }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <x-input-error :messages="$errors->get('{{ $question->title }}')" class="mt-2" />
                                    </div>
                                    
                                    <style>
                                        .scale-label {
                                            padding: 5px 10px;
                                            border: 1px solid #ccc;
                                            border-radius: 4px;
                                            transition: all 0.3s ease;
                                        }
                                    
                                        .scale-radio:checked + .scale-label {
                                            background-color: black;
                                            color: white;
                                        }
                                    
                                        .scale-label:hover {
                                            border-color: black;
                                        }
                                    </style>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endforeach
            </div>

            <!-- Questions without category -->
            @foreach ($performanceProfileQuestions->whereNull('performance_categories') as $question)
                <div class="text-section relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="label">
                            <h3 class="text-base">{{ $question->text }}</h3>
                        </div>
                    </div>
                    <div class="field flex space-x-2">
                        @php
                            $jsonText = $question->options;
                            $items = json_decode($jsonText);
                        @endphp
                        @foreach ($items as $item)
                            <div>
                                <input type="radio" class="hidden scale-radio @error($question->title) border-red-500 @enderror" name="{{ $question->title }}" id="{{ $question->title }}_{{ $item }}" value="{{ $item }}" />
                                <label for="{{ $question->title }}_{{ $item }}" class="scale-label cursor-pointer">{{ $item }}</label>
                            </div>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('{{ $question->title }}')" class="mt-2" />
                </div>
            @endforeach

            <style>
                .scale-label {
                    padding: 5px 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    transition: all 0.3s ease;
                }

                .scale-radio:checked + .scale-label {
                    background-color: black;
                    color: white;
                }

                .scale-label:hover {
                    border-color: black;
                }
            </style>

            <x-primary-button>{{ __('Create Performance Profile') }}</x-primary-button>
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
    </script>
@endsection
