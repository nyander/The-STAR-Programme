<x-app-layout>
    <div class="max-w-lg mx-auto p-4 sm:p-6 lg:p-8">
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


        

        <form method="POST" action="{{ route('goals.storeUpdateGoal', [$goal, $client]) }}" class="bg-white p-8 rounded drop-shadow border-primary border-4">

            @csrf
            @method('PUT')

            <h2 class="text-2xl font-semibold mb-4">Update Goal</h2>
            {{-- Description --}}
            <div class="text-section mb-4 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="label">
                        <h3 class="font-bold">Goal Description</h3>
                        <p class="">{{ $goal->description }}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-8">
               


                @if ($goal->type == 'amount')
                    {{-- achieved --}}
                    <div class="text-section relative">
                        <div class="flex items-center justify-between mb-2">
                            <div class="label">
                                <h3 class="text-base">Target Amount</h3>
                            </div>
                        </div>
                        <div class="field">
                            <div class="relative">
                                <input type="number" name="goal"
                                    class="block w-full border-gray-500 bg-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    value="{{ $goal->goal }}" disabled/>
                            </div>
                        </div>
                    </div>
                @endif






                @if ($goal->type == 'amount')
                {{-- achieved --}}
                <div class="text-section relative">
                    <div class="flex items-center justify-between mb-2">
                        <div class="label">
                            <h3 class="text-base">Amount Achieved</h3>
                        </div>
                    </div>
                    <div class="field">
                        <div class="relative">
                            <input type="number" name="achieved"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                value="{{ $goal->achieved }}"/>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('achieved')" class="mt-2" />
                </div>

            @else
                <div class="text-section mb-4 relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="label">
                            <h3 class="text-base">Task Achieved</h3>
                        </div>
                    </div>
                    <div class="field">
                        <div>
                            <div>
                                <input type="checkbox" name="completed" id="completed"
                                {{ $goal->complete == true ? 'checked' : '' }}/>
                                <label for="completed">Completed</label>
                              </div>
                          </div>
                      
                          <div>
                        <div class="relative">
                            
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('achieved')" class="mt-2" />
                </div>
            @endif


            </div>

            

            <x-primary-button class="bg-primary">{{ __('Update Goal') }}</x-primary-button>
        </form>

    </div>
</x-app-layout>