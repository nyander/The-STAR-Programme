<x-app-layout>
    <div class="mt-6 rounded-lg  mx-8 bg-white p-8">
        <div class="px-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4">{{ $performanceProfileTemplate->title }} Template</h2>
            <p class="lg:w-8/12">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab soluta adipisci voluptatum consectetur vel deserunt voluptate cum, incidunt rerum cumque. Doloremque assumenda vitae perferendis repellendus? Doloremque sit iusto fuga sint distinctio, veniam dicta consectetur, temporibus inventore voluptatem provident eos repudiandae?</p>
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

        <div class="grid lg:grid-cols-2 grid-cols-1 gap-8">
            <div class="p-6">
                <div class="p-6 bg-white rounded shadow mb-4 add-Question-section border-primary border-4 drop-shadow-md">
                    <h3 class="font-semibold text-lg mb-4">Create New Question</h3>
                    <!-- Create New Question Form -->
                    <!-- Create New Question Form -->
                    <form method="POST" action="{{ route('performance-profile-templates.questions.store', $performanceProfileTemplate) }}">
                        @csrf
                        <!-- Type Field -->
                        <div class="mt-4">
                            <label for="type" class="block font-medium">Category</label>
                            <select name="type" id="categorytype" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('type') border-red-500 @enderror" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Question Text Field -->
                        <div class="mt-4">
                            <label for="text" class="block font-medium">Attribute</label>
                            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('title') border-red-500 @enderror" required>
                            @error('title')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
        
                        <!-- Question Text Field -->
                        <div class="mt-4">
                            <label for="text" class="block font-medium">Question</label>
                            <input type="text" name="text" id="text" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('text') border-red-500 @enderror" required>
                            @error('text')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Type Field -->
                        <div class="mt-4">
                            <label for="type" class="block font-medium">Type</label>
                            <select name="type" id="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('type') border-red-500 @enderror" required>
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="select">Select</option>
                                <option value="radio">Radio</option>
                                <option value="select">Scale</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Options Field -->
                        <div class="mt-4" id="optionsContainer" style="display: none;">
                            <label for="options" class="block font-medium">Options</label>
                            <input type="text" name="options" id="options" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('options') border-red-500 @enderror">
                            @error('options')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Required Field -->
                        <div class="mt-4">
                            <label for="required" class="block font-medium">Required</label>
                            <select name="required" id="required" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('required') border-red-500 @enderror" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('required')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="bg-primary hover:bg-primary text-white font-semibold py-2 px-4 rounded text-base">Add Question</button>
                        </div>
                    </form>
                    
                </div>
            </div>
    
            <div class="">
                <div class="p-6 bg-white rounded existing-question-section">
                    @if ($performanceProfileQuestions->isEmpty())
                        <p class="text-gray-600">No questions found for this performance profile.</p>
                    @else
                        <ul>
                            @foreach ($performanceProfileQuestions as $question)
                                <li class="flex items-center justify-between bg-gray-100 p-6 rounded drop-shadow mb-8 w-full">
                                    <!-- Question Details -->
                                    <div class="w-full">
                                        <div class="mb-4">
                                            <span class="font-semibold">{{ $question->text }}</span>
                                        </div>
                                        <div class="w-3/6">
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    @if ($question->order)
                                                        <span class="text-xs"> <span class="font-semibold">Category:</span> {{ $question->performanceCategory->category }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-xs"> <span class="font-semibold">Type:</span> {{ ucfirst($question->type) }}</span>
                                                </div>

                                                <div>
                                                    @if ($question->order)
                                                        <span class="text-xs"> <span class="font-semibold">Attribute:</span> {{ $question->title }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-xs"> <span class="font-semibold">Required:</span> {{ $question->required == 1 ? 'Yes' : 'No' }}</span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- Edit and Delete Buttons -->
                                    <div class="flex items-center space-x-2">
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <!-- Edit Button -->
                                                <x-dropdown-link :href="route('performance-profile-templates.questions.edit', [$performanceProfileTemplate, $question])">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
            
                                                <form method="POST" action="{{ route('performance-profile-templates.destroy', $performanceProfileTemplate) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('performance-profile-templates.questions.destroy', [$performanceProfileTemplate, $question])" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                        
                                        
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
       
    </div>

    <script>
        // Type Field
        var typeField = document.getElementById('type');
        var optionsContainer = document.getElementById('optionsContainer');

        typeField.addEventListener('change', function () {
            var selectedType = typeField.value;
            if (selectedType === 'select' || selectedType === 'radio') {
                console.log("This is working");
                // Display the options field
                optionsContainer.style.display = 'block';
            } else {
                console.log("This is not working");
                // Hide the options field
                optionsContainer.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
