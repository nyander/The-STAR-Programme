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

        <h2 class="text-2xl font-semibold mb-4">Goals</h2>

        <form method="POST" action="{{ route('goals.update', [$goal, $client]) }}">
            @csrf
            @method('PUT')

            {{-- Description --}}
            <div class="text-section mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="label">
                        <h3 class="text-base">Goal Description</h3>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <textarea name="description" id="description"
                            placeholder=""
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >{{ $goal->description }}</textarea>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            {{-- Type of goal --}}
            <div class="text-section mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="label">
                        <h3 class="text-base">Goal Type</h3>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <select name="type" id="type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('type') border-red-500 @enderror">
                            <option value="amount" @if ($goal->type === 'amount') selected @endif>Amount</option>
                            <option value="milestone" @if ($goal->type === 'milestone') selected @endif>Milestone</option>
                        </select>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>

            {{-- Target --}}
            <div class="text-section mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="label">
                        <h3 class="text-base">Target (End Goal)</h3>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <input type="text" name="goal" id="goal"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            value="{{ $goal->goal }}"/>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('goal')" class="mt-2" />
            </div>
            
            <x-primary-button>{{ __('Update Goal') }}</x-primary-button>
        </form>
    </div>

    <script>
        // Get the elements
        const typeSelect = document.getElementById('type');
        const goalInput = document.getElementById('goal');

        // Function to show/hide the goal input based on the selected type
        const toggleGoalInput = () => {
            const selectedType = typeSelect.value;
            goalInput.type = selectedType === 'amount' ? 'number' : 'text';
            goalInput.type === 'text' ? goalInput.value = '' : '';
        };

        // Add event listener for type change
        typeSelect.addEventListener('change', toggleGoalInput);

        // Call the toggle function initially
        toggleGoalInput();
    </script>
</x-app-layout>
