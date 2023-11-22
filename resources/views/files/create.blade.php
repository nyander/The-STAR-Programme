
    <div class="max-w-2xl">
  
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
  
      <form method="POST" enctype="multipart/form-data" action="{{ route('files.store') }}">
  
        @csrf
  
        <div class="mb-4">
        
          <label class="block text-gray-700 font-bold mb-2" for="file">
            Choose file
          </label>
          
          <input class="border border-gray-400 p-2 w-full" type="file" id="file" name="file">
  
        </div>
  
        <div class="mb-4">
  
          <label class="block text-gray-700 font-bold mb-2" for="type">
            Select Type
          </label>
  
          <select id="type" name="type" class="border border-gray-400 p-2 w-full">
            <option value="terms">Terms & Conditions</option>
            <option value="other">Other</option>
          </select>
  
        </div>
  
        <button class="bg-blue-500 text-white px-4 py-2 rounded font-bold">
          Upload
        </button>
  
      </form>
  
    </div>