<x-app-layout>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      @if(session('success'))
    <div class="p-6 bg-green-100 rounded shadow mb-4 success">
        <p class="text-green-600">{{ session('success') }}</p>
    </div>
  @endif

  @if(session('error'))
    <div class="p-6 bg-red-100 rounded shadow mb-4">
        <p class="text-red-600">{{ session('error') }}</p>
    </div>
  @endif   

      <div class="bg-white p-8 rounded drop-shadow border-primary border-4">
        <div>
          
          <h2 class="text-lg font-semibold">{{ $enquiry->subject }}</h2>

          <div class="flex justify-between">
            <p class="text-sm text-gray-400">{{ $enquiry->client->name }}</p>
            <p class="text-sm text-gray-400">{{ $enquiry->created_at->format('M d, Y') }}</p>
          </div>
          
  
          <p class="">{{ $enquiry->content}}</p>

          
    
          <p class="mt-2">{{ $enquiry->message }}</p>
        </div>
  
        



  
        <h3 class="mt-6 text-xl font-semibold mb-2">Responses</h3>
  
        <ul class="space-y-4">
        
          @forelse ($enquiry->responses as $response)
          
            <li class="bg-gray-50 px-4 py-6 rounded-lg border-l-8 border-primary mb-4">
              <div class="mt-2  text-gray-600 flex justify-between ">
                <p class="text-base font-bold">{{ $response->user->name }}:</p>
                <p class="text-sm font-light">{{ $response->created_at->format('M d, Y h:i A') }}</p>
              </div>
             
              <p>{{ $response->response }}</p>
              
            </li>
          
          @empty
          
            <p>No responses yet.</p>
          
          @endforelse
        
        </ul>

        <form method="POST" action="{{ route('enquiries.respond', $enquiry) }}" class="mt-6">
  
          @csrf
  
          <div class="text-section mb-4 relative">
            <h3 class="text-lg font-semibold mb-4">Submit Response</h3>
          
            <div class="field">
              <textarea name="response" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
            </div>
          
            <x-input-error :messages="$errors->get('response')" class="mt-2" />
          </div>
  
          <x-primary-button class="bg-primary mt-2">Submit Response</x-primary-button>
        
        </form>
      </div>

      

  
    </div>
    <script>

      const successMsg = document.querySelector('.success');
    
      setTimeout(() => {
        successMsg.style.display = 'none'; 
      }, 5000);
    
    </script>
  </x-app-layout>