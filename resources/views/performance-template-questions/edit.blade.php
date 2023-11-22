<x-app-layout>
    <div class="flex items-center justify-center mt-8">
        <div class="bg-white rounded-lg p-4 w-2/6">
            <h3 class="text-lg font-semibold mb-4">Edit Question</h3>
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
            <form id="edit-form" method="POST" action="{{ route('performance-profile-templates.questions.update', [$performanceProfileTemplate, $question]) }}">
                @csrf
                @method('PATCH')
                <div class="mt-4">
                    <label for="text" class="block font-medium">Title</label>
                    <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required value="{{ $question->title }}">
                </div>
                <!-- Edit Question Fields -->
                <div class="mt-4">
                    <label for="text" class="block font-medium">Text</label>
                    <input type="text" name="text" id="text" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required value="{{ $question->text }}">
                    @error('text')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="type" class="block font-medium">Type</label>
                    <select name="type" id="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="text" {{ $question->type === 'text' ? 'selected' : '' }}>Text</option>
                        <option value="textarea" {{ $question->type === 'textarea' ? 'selected' : '' }}>Textarea</option>
                        <option value="select" {{ $question->type === 'select' ? 'selected' : '' }}>Select</option>
                        <option value="radio" {{ $question->type === 'radio' ? 'selected' : '' }}>Radio</option>
                        <option value="select" {{ $question->type === 'scale' ? 'selected' : '' }}>Scale</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4" id="options-container" style="{{ in_array($question->type, ['select', 'radio']) ? '' : 'display: none;' }}">
                    <label for="options" class="block font-medium">Options</label>
                    @php
                        $options = json_decode($question->options);
                        $options = is_array($options) ? implode(', ', $options) : '';
                    @endphp
                    <input type="text" name="options" id="options" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $options }}">
                    @error('options')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                



                <div class="mt-4">
                    <label for="required" class="block font-medium">Required</label>
                    <select name="required" id="required" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="0" {{ !$question->required ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $question->required ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('required')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="order" class="block font-medium">Order</label>
                    <input type="number" name="order" id="order" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $question->order }}">
                    @error('order')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Save and Cancel Buttons -->
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded text-base">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Edit Type Field
        var editTypeField = document.getElementById('type');
        var editOptionsContainer = document.getElementById('options-container');

        editTypeField.addEventListener('change', function () {
            var selectedEditType = editTypeField.value;
            if (['select', 'radio'].includes(selectedEditType)) {
                // Display the options field
                editOptionsContainer.style.display = '';
            } else {
                // Hide the options field
                editOptionsContainer.style.display = 'none';
            }
        });

        // Check the initial value on page load
        if (['select', 'radio'].includes(editTypeField.value)) {
            editOptionsContainer.style.display = '';
        }
    </script>
</x-app-layout>
