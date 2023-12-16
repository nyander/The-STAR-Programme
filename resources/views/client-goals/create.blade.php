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

    <div class="p-6 bg-white border-4 border-primary">
       
    

      <h2 class="text-2xl font-semibold mb-4">Goals</h2>

      <form method="POST" action="{{ route('goals.store') }}">
          @csrf
          <input type="text" name="client_id" value="{{ $client->id }}" hidden>

            @if (Auth::user()->hasRole('Admin'))
                <div class="text-section relative mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="label">
                            <h3 class="text-base">Hello This is a test</h3>
                        </div>
                    </div>
                    <div class="field">
                        <div class="relative">
                            <select name="selectClient" id="selectClient" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                
                                <option value="">Select Client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif



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
                      ></textarea>
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
                          <option value="amount">Amount</option>
                          <option value="milestone">Milestone</option>
                      </select>
                  </div>
              </div>
              <x-input-error :messages="$errors->get('type')" class="mt-2" />
          </div>

          {{-- Target (End Goal) --}}
          <div id="amountGoal" class="text-section mb-4 relative">
              <div class="flex items-center justify-between mb-4">
                  <div class="label">
                      <h3 class="text-base">Target (End Goal) - Amount</h3>
                  </div>
              </div>
              <div class="field">
                  <div class="relative">
                      <input type="number" name="amount_goal"
                          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                      />
                  </div>
              </div>
              <x-input-error :messages="$errors->get('amount_goal')" class="mt-2" />
          </div>

          <div id="milestoneGoal" class="text-section mb-4 relative hidden">
              <div class="flex items-center justify-between mb-4">
                  <div class="label">
                      <h3 class="text-base">Target (End Goal) - Milestone</h3>
                  </div>
              </div>
              <div class="field">
                  <div class="relative">
                      <input type="text" name="milestone_goal"
                          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                      />
                  </div>
              </div>
              <x-input-error :messages="$errors->get('milestone_goal')" class="mt-2" />
          </div>

          <x-primary-button class="bg-primary">{{ __('Add Goal') }}</x-primary-button>
      </form>
    </div>
  </div>

  <script>
      // Get the elements
      const typeSelect = document.getElementById('type');
      const amountGoal = document.getElementById('amountGoal');
      const milestoneGoal = document.getElementById('milestoneGoal');

      // Add event listener for type change
      typeSelect.addEventListener('change', function() {
          // Get the selected type
          const targetType = this.value;

          // Show/hide the respective input fields
          if (targetType === 'amount') {
              amountGoal.classList.remove('hidden');
              milestoneGoal.classList.add('hidden');
          } else if (targetType === 'milestone') {
              amountGoal.classList.add('hidden');
              milestoneGoal.classList.remove('hidden');
          }
      });
  </script>
</x-app-layout>