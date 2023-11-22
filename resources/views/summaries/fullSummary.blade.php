<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>


        <style>
            .hide-in-pdf {
                display: none;
            }
            </style>
            

    </head>
    <body>
<<<<<<< HEAD
        <div class="mt-6 rounded-lg mx-8 bg-white p-8 main-content-to-download" style="max-width: 1080px">
=======
        <div class="mt-6 rounded-lg mx-8 bg-white p-8 mx-auto main-content-to-download" style="max-width: 1080px">
>>>>>>> 530cf0deadf44b7dd6e2d6f0e0f190ef13bcf3a2

            <button id="save-as-pdf" class="bg-blue-500 text-white px-4 py-2 rounded">
                Save
            </button>
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
    
            <div class="bg-gray-100 py-16 px-32 ">

                <h1 class="text-2xl font-semibold">Performance Profile Summary</h1>

                <div class = "mb-8">
                    <p><span class="font-bold">Name</span> {{ $feedback->user->name }} </p>
                    <p><span class="font-bold">Name</span> {{ $feedback->user->clientOverview->current_sport }} </p>
                </div>
    
                <div class="mb-16 mx-auto">
                        <div class="performance-chart radar tabcontent" id="radar-chart-container">
                        {!! $radarChart->container() !!}
                        <script src="{{ $radarChart->cdn() }}"></script>
                        </div>
                        
        
                        <div class="performance-chart chart tabcontent">
                        {!! $chart->container() !!}
                        <script src="{{ $chart->cdn() }}"></script>
                        </div>
                </div>

                <div class="flex items-center justify-between">
                    
                    @if (Auth::user()->hasRole('Admin') && !$feedback->practitioner_completion)
                        <div class="right">
                            <a href="{{ route('client.completion', $feedback->user->id) }}" class="bg-gray-800 text-white px-4 py-2 rounded-md">Add Practitioner's Feedback</a>
                        </div>
                    @endif
                    
                </div>


                @if ($feedback->practitioner_completion == true)
    
                    <div class="practitioner-feedback rounded">
                        <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                            <label for="">Did the client achieve their initial consultancy goals?</label>
                            <textarea name="practitioner_client_achieve" id="practitioner_client_achieve" 
                            class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                            disabled>{{ $feedback->practitioner_client_achieve }}</textarea>
                        </div>
    
                        <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                            <label for="">How did the client’s mindset evolve throughout the program?</label>
                            <textarea name="practitioner_progress_review" id="practitioner_progress_review" 
                            class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                            disabled>{{ $feedback->practitioner_progress_review }}</textarea>
                        </div>
    
                        <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                            <label for="">What strategies were most effective for the client?</label>
                            <textarea name="practitioner_achievement_review" id="practitioner_achievement_review" 
                            class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                            disabled>{{ $feedback->practitioner_achievement_review }}</textarea>
                        </div>
    
                        <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                            <label for="">What aspects of the client’s mental skills still need improving?</label>
                            <textarea name="practitioner_challenge_review" id="practitioner_challenge_review" 
                            class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                            disabled>{{ $feedback->practitioner_challenge_review }}</textarea>
                        </div>
    
                        <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                            <label for="">What advice do you have to help the client to maintain their newfound mindset?</label>
                            <textarea name="practitioner_suggestion" id="practitioner_suggestion" 
                            class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                            disabled>{{ $feedback->practitioner_suggestion }}</textarea>
                        </div>

                        <div class="mt-4 border-primary border-4 p-4 bg-white rounded-md">
                            <label for="">How can I continue to support the client after the program?</label>
                            <textarea name="practitioner_support" id="practitioner_support" 
                            class="block mt-1 w-full rounded-md  p-2 border-gray-300 bg-gray-50"
                            disabled>{{ $feedback->practitioner_support }}</textarea>
                        </div>
                    </div>
                @endif
                
    
            </div>
            
            
            
                
           
    
        </div>

        {{ $chart->script() }}
        {{ $radarChart->script() }}
    </body>
    
    

    <script>
        document.getElementById('save-as-pdf').addEventListener('click', () => {
            const contentToDownload = document.querySelector('.main-content-to-download');
            const saveButton = document.getElementById('save-as-pdf');
            
            // Hide the button in the PDF
            saveButton.classList.add('hide-in-pdf');

            html2canvas(contentToDownload, {
                scale: 1,
                width: contentToDownload.scrollWidth,
                height: contentToDownload.scrollHeight
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'px',
                    format: [canvas.width, canvas.height]
                });
                pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                pdf.save('performanceProfile.pdf');

                // Make the button visible again after saving the PDF
                saveButton.classList.remove('hide-in-pdf');
            });
        });

    </script>
</html>