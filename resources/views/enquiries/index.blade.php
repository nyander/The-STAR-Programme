@extends('layouts.standard')

@section('content')
    <div class="mt-6 rounded-lg  mx-8 bg-white md:p-8">
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
        <div class="bg-gray-100  p-6 md:p-16 md:px-12">
            <h2 class="text-2xl font-black mb-4">Consultation</h2>
            <div class="grid lg:grid-cols-2 mb-8">
                <p>
                    Sorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur tempus urna at turpis condimentum lobortis.
                </p>

            </div>
        
            @if (Auth::user()->hasRole('Client'))
                <div class="p-6 bg-white rounded border-primary border-4">
                    <h2 class="text-2xl font-semibold mb-4">Create New Enquiry</h2>
                    
                    <form action="{{ route('enquiries.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold uppercase ">Topic:</label>
                            <input type="text" name="subject" class="mt-1 w-full border rounded-lg bg-gray-100 border-none p-4" placeholder="Please enter here" required>
        
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold uppercase">Quesion/Enquiry:</label>
                            <textarea name="message" class="mt-1 w-full border rounded-lg bg-gray-100 border-none p-4" placeholder="Please enter here" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg">Submit Enquiry</button>
                    </form>
                </div>
            @endif
            
    
    
            <div class="mt-16">
                
                <div class="enquiries">
                    @forelse ($enquiries as $enquiry)
                        <div class="bg-gray-50 p-8 border-l-8 border-primary my-6 rounded drop-shadow">
                            <div class="mb-4">
                                <div class="w-full flex justify-between items-center">
                                    <h3 class="text-basexx font-black">{{ $enquiry->subject }}</h3>
                                    <p class=" text-sm {{ !$enquiry->resolved ? 'text-red-700' : 'text-green-700' }}">{{ !$enquiry->resolved ? 'Unresolved' : 'Resolved' }}</p>
                                </div>
                                <p class="text-gray-400 text-sm">{{ $enquiry->client->name }}</p>
                            </div>
                            


                            {{-- <a href="{{ route('enquiries.show', $enquiry) }}" class="text-blue-500 hover:underline">{{ $enquiry->subject}}</a> --}}
                            <p class="mt-4">{{ $enquiry->content}}</p>
                            @if ($enquiry->responses->count() > 0)
                                <p class="text-xs text-gray-400">{{ $enquiry->responses->count() }} Responses</p>
                            @endif
                            <div class="flex justify-between items-center mt-4">
                                <button type="button" class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg"> <a href="{{ route('enquiries.show', $enquiry) }}">View/Add Responses</a> </button>
                                <p class="text-xs text-gray-600">{{ $enquiry->created_at->format('M d, Y') }}</p>
                            </div>

                           
                        </div>
                            
                    @empty
                        <p>No enquiries found.</p>
                    @endforelse
                </div>
                    
                
            </div>
        </div>
        
    </div>
    <script>

        const successMsg = document.querySelector('.success');
      
        setTimeout(() => {
          successMsg.style.display = 'none'; 
        }, 5000);
      
      </script>
    
@endsection
