@extends('layouts.standard')

@section('content')
    <div class="mt-6 rounded-lg  mx-8 bg-white p-8">
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

        <div class="p-6 bg-white">
            <h2 class="text-2xl font-semibold mb-4">Create New Enquiry</h2>
            
            <form action="{{ route('enquiries.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Subject</label>
                    <input type="text" name="subject" class="mt-1 p-2 w-full border rounded-lg" required>

                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Message</label>
                    <textarea name="message" class="mt-1 p-2 w-full border rounded-lg" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">Submit Enquiry</button>
            </form>
        </div>
    </div>
    
@endsection
