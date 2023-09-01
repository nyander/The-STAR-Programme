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
        <form method="POST" action="{{ route('performance-profile-templates.update', $performanceProfileTemplate) }}" class="bg-white p-8 rounded drop-shadow border-primary border-4">
            @csrf
            @method('patch')
            <h2 class="text-lg font-semibold mb-4">Create new Performance Profile Template</h2>
            <div class="title-section mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="label">
                        <h3 class="text-base">Title</h3>
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
                            This title will not be viewable by the client. They will only see the name "Performance Profiling."
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <input type="text" name="title"
                            placeholder="{{ __('Enter a unique name for this performance profile') }}"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            value="{{ old('title', $performanceProfileTemplate->title) }}" />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="description-section mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="label">
                        <h3 class="text-base">Description</h3>
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
                            The Description will be displayed when your client is filling in their Performance Profile,
                            this is a good place for you to provide a brief summary of the purpose of the performance profile.
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <textarea name="description"
                            placeholder="{{ __('Please provide some description') }}"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >{{ old('description', $performanceProfileTemplate->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="default-section mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="label">
                        <h3 class="text-base">Set as Default</h3>
                    </div>
                    <div class="question-mark">
                        <!-- Question mark code -->
                    </div>
                </div>
                <div class="field">
                    <div class="relative">
                        <select name="default_value" id="default_value"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="0" @if ($performanceProfileTemplate->default_value === 0) selected @endif>No</option>
                            <option value="1" @if ($performanceProfileTemplate->default_value === 1) selected @endif>Yes</option>
                        </select>
                        <x-input-error :messages="$errors->get('default_value')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('performance-profile-templates.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
