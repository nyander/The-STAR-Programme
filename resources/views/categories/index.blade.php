<x-app-layout>

    <div class="max-w-7xl mx-auto py-6 sm:px-8 lg:px-8">
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
  
      <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-semibold">Categories</h2>
        
        <a href="{{ route('categories.create') }}" 
           class="px-4 py-2 bg-primary text-white rounded font-bold">
          Add Category
        </a>
      </div>
  
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
              <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Color
                  </th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Edit</span>
                  </th>
              </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($categories as $category)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ $category->category }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="inline-block w-6 h-6" style="background-color: {{ $category->colour }}"></div>
                  </td>
                    <td class="px-6 py-4 text-right text-sm flex float-right">

                      <a href="{{ route('categories.edit', $category) }}"
                        class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                    
                      <form method="POST" action="{{ route('categories.destroy', $category) }}">
                        @csrf
                        @method('DELETE')
                        
                        <button 
                          onclick="return confirm('Are you sure?')"
                          class="text-red-600 hover:text-red-900">
                          Delete
                        </button>
                    
                      </form>
                    
                    </td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
  
    </div>
  
  </x-app-layout>