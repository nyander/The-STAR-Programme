<x-app-layout>

    <div class="max-w-2xl mx-auto mt-8 p-8 bg-white shadow-md">
  
      <div>
        <h1 class="text-2xl font-bold">{{ $file->type == 'terms' ? 'Terms & Conditions' : '' }}</h1>
        <h2 class="text-sm mt-2"><span class="font-bold">Uploaded On:</span> {{ $file->updated_at }}</h2>
        {{-- <h2 class="text-sm">Status: {{ $goal->complete == false ? 'Incomplete' : 'Complete' }}</h2> --}}
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
  
      <div class="mt-8 border-black border-4">
  
        <embed src="{{ asset($file->path) }}" width="100%" height="600px" />
  
      </div>
  
    </div>
    
  </x-app-layout>