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
  
      
  
      <form method="POST" action="{{ route('categories.update', $category) }}" class="bg-white p-8 rounded drop-shadow border-primary border-4">
        @csrf
        @method('PUT')

        <h2 class="text-2xl font-semibold mb-4">Edit Category</h2>
  
        <!-- Category Name -->  
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">
            Category Name
          </label>
          
          <input value="{{ $category->category }}" class="border border-gray-400 p-2 w-full" type="text" name="category">
        </div>
  
        <!-- Category Color -->
        <div class="mb-8 grid grid-cols-2 max-w-sm h-full items-center" style="grid-template-columns: 40% 60%;">
          <label class="block text-gray-700 font-bold mr-8">
            Category Color
          </label>
          
          <input value="{{ $category->colour }}" class="" type="color" name="colour">
        </div>  
  
        <button class="bg-primary text-white px-4 py-2 rounded font-bold">
          Update Category
        </button>
  
      </form>
  
    </div>
  
  </x-app-layout>