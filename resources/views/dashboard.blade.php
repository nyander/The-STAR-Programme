@extends('layouts.standard')

@section('content')

<x-slot name="header">
  
</x-slot>

<div class="py-4">
  

  <div class="mx-auto sm:px-6 px-8 dashboard ">
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
    

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      
      <div class="p-6 md:p-12 text-gray-900">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">  
          {{ __('Dashboard') }}
        </h2>

        <div class=" mx-auto">

          <!-- First row -->
          <div class="grid  md:grid-cols-12 gap-4 mb-4">

            {{-- Stauts Panel Section --}}
            <div class="sm:col-span-12 md:col-span-6 lg:col-span-4">
                <div class="grid grid-cols-2 grid-rows-2 gap-2 bg-white h-full p-4 drop-shadow-md">

                    <div class="bg-red-600 p-4 flex items-center rounded drop-shadow-md h-full">
                      <div class="text-white mx-auto text-center">
                        <h3 class="title text-3xl md:text-4xl font-extrabold">
                            {{ $totalIncompletePerformanceProfiles }}
                        </h3>
                        <p class="text-sm mt-2">Incomplete Performance Profiles</p>
                      </div>
                    </div>
                  
                    <div class="bg-green-700 p-4 flex items-center rounded drop-shadow-md h-full">
                        <div class="text-white mx-auto text-center">
                            <h3 class="title text-3xl md:text-4xl font-extrabold">

                              @if (Auth::user()->hasRole('Client'))
                                {{ $user->performanceProfile->count() }}
                              @else
                                {{ $totalPerformanceProfiles}}
                              @endif
                                
                            </h3>
                            <p class="text-sm mt-2">Completed Performance Profiles</p>
                        </div>
                    </div>
                  
                    <div class="bg-blue-900 p-4 flex items-center rounded drop-shadow-md	h-full">
                        <div class="text-white mx-auto text-center">
                            <h3 class="title text-3xl md:text-4xl font-extrabold mx-auto text-center">
                              @if (Auth::user()->hasRole('Client'))
                                {{ $user->clientGoals->where('complete', true)->count() }}
                              @else
                                  {{ $totalGoals }}
                              @endif
                              
                            </h3>
                            <p class="text-sm mt-2">Goals Achieved</p>
                        </div>
                    </div>
                  
                    <div class="bg-sky-600 p-4 flex items-center rounded drop-shadow-md h-full	">
                        <div class="text-white mx-auto text-center">
                            <h3 class="title text-3xl md:text-4xl font-extrabold mx-auto text-center">
                              @if (Auth::user()->hasRole('Client'))
                                {{ $user->enquiries->count()  }}
                              @else
                                  {{ $enquiries->count() }}
                              @endif
                            </h3>
                            <p class="text-sm mt-2">Message board Topics</p>
                        </div>
                    </div>
                  
                  </div>
            </div>

            <div class="p-4 sm:col-span-12 md:col-span-6 lg:col-span-5 bg-white h-full my-auto drop-shadow-md rounded">
              <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold">Message board</h3>
                <h3 class="text-xs">{{ $enquiriesCount }} Enquiries</h3>
              </div>
              @forelse ($enquiries as $enquiry)
                <div class="bg-gray-50 p-4 border-l-8 border-primary my-4 rounded drop-shadow">
                  <a href="{{ route('enquiries.show', $enquiry) }}">
                    <div class="mb-2">
                        <div class="w-full flex justify-between items-center">
                            <h3 class="text-basexx font-black">{{ $enquiry->subject }}</h3>
                            <p class=" text-sm {{ !$enquiry->resolved ? 'text-red-700' : 'text-green-700' }}">{{ !$enquiry->resolved ? 'Unresolved' : 'Resolved' }}</p>
                        </div>
                        <div class="w-full flex justify-between items-center">
                          <p class="text-gray-400 text-sm">{{ $enquiry->client->name }}</p>
                          @if ($enquiry->responses->count() > 0)
                              <p class="text-xs text-gray-400">{{ $enquiry->responses->count() }} Responses</p>
                          @endif
                        </div>
                        
                        
                        <p class="">{{ Str::limit($enquiry->content, 6070) }}</p>
                    </div>
                  </a>
                </div>
              @empty
                <div class="h-96 flex items-center justify-center mx-auto">
                  <div class="items-center text-center ">
                    <p class="mb-6">No Enquries have been made</p>
                    @can('client-enquiry-access')
                      <a href="{{ route('enquiries.index') }}" class="bg-primary hover:bg-primary text-white text-sm font-semibold py-2 px-4 rounded">Submit An Enquiry</a>
                    @endcan
                  </div>
                  
                </div>
                  
              @endforelse
              
            </div>

            <div class=" sm:col-span-12 md:col-span-12 lg:col-span-3 w-full  flex flex-col justify-center items-center rounded drop-shadow-md ">
              <div class="bg-primary h-full w-full flex items-center  drop-shadow-md rounded	p-16 lg:p-8">
                <div class="text-white text-center mx-auto">
                  <h3 class="title-counter text-6xl font-extrabold mb-4">
                    {{-- COUNTER ANIMATION HERE --}}
                    {{ $user->performanceProfile->count() > 0 ? ($user->performanceProfile->count() /$user->clientAgreement->program_duration) * 100 :  '0'}}%
                  </h3>
                  <p class="text-base">of your program completed</p>
                </div>
              </div>
            </div>

          </div>

          <!-- Second row -->
          
          <div class="grid lg:grid-cols-2 gap-4 mt-4">
            @if (Auth::user()->hasRole('Client'))
              <div class="grid grid-cols-1">

                  <div class="bg-white rounded drop-shadow-md graph-tabs p-4">
    
            
                      <h3 class="text-2xl font-extrabold pl-2">
                          Overview
                      </h3>
                      <div class="text-sm flex mb-4 mt-2 items-center  pl-2">
                        
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2">
                                    <p>Select Graph</p>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link>
                                  <button class="tab  font-bold w-full text-right rounded-l" onclick="openTab('chart')">Chart</button>
                                </x-dropdown-link>
                                <x-dropdown-link>
                                  <button class="tab  font-bold w-full text-right rounded-r" onclick="openTab('radar')">Radar Chart</button>
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                      </div>
      
                      <div class="performance-chart radar tabcontent" id="radar-chart-container">
                        {!! $radarChart->container() !!}
                        <script src="{{ $radarChart->cdn() }}"></script>
                      </div>
                      <style>
                        #radar-chart-container .apexcharts-yaxis {
                            display: none;
                        }
                      </style>
      
                      <div class="performance-chart chart tabcontent">
                        {!! $chart->container() !!}
                        <script src="{{ $chart->cdn() }}"></script>
                      </div>
      
                  </div>
    
              </div>
              
              <div class="grid grid-cols-1">
                
                <div>
                  
                  <div class="bg-white rounded drop-shadow-md p-4 h-full">
                    <h3 class="text-2xl font-extrabold pl-2 mb-4">
                      Goals
                    </h3>
                    @php
                        if (Auth::user()->hasRole('Client')) {
                          $goalsCollection = $user->clientGoals;
                        } else {
                          $goalsCollection = $recentSubmissions;
                        }
                    @endphp
                    @forelse ($goalsCollection as $goal)
                    <div class="lg:grid-cols-2 gap-4 mt-4">
                        <div class="p-6 flex space-x-2 border-l-4 border-primary rounded bg-white">
                          <div class="flex-1">
                              <div class="flex justify-between items-center">
                                  <div>
                                      <h1 class="font-semibold">{{ $goal->description }}</h1>
                                      <h2 class="text-sm">Target: {{ $goal->goal }}</h2>
                                      @if ($goal->type == 'amount')
                                          <h2 class="text-sm">Progress: {{ $goal->achieved }}/{{ $goal->goal }}</h2>
                                      @endif
                                      
                                      <h2 class="text-sm font-bold {{ $goal->complete == false ? 'text-red-600' : 'text-green-600' }} ">{{ $goal->complete == false ? 'Incomplete' : 'Complete' }}</h2>
                                      @if ($goal->complete == false && Auth::user()->id == $goal->client->id)
                                          <div class="mt-4">
                                              <a href="{{ route('goals.updateGoal', $goal) }}" class="bg-primary hover:bg-primary text-white font-semibold py-2 px-4 rounded text-base">Update</a>
                                          </div>
                                      @endif
                                  
                                  </div>
                                  @if (Auth::user()->hasRole('Admin'))
                                  <x-dropdown>
                                      <x-slot name="trigger">
                                          <button>
                                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                  <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                              </svg>
                                          </button>
                                      </x-slot>
                                      <x-slot name="content">
                                          <x-dropdown-link :href="route('goals.edit', $goal)">
                                              {{ __('Edit') }}
                                          </x-dropdown-link>
  
                                          <form method="POST" action="{{ route('goals.destroy', $goal) }}">
                                              @csrf
                                              @method('delete')
                                              <x-dropdown-link :href="route('goals.destroy', $goal)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                  {{ __('Delete') }}
                                              </x-dropdown-link>
                                          </form>
                                      </x-slot>
                                  </x-dropdown>
                              @endif
                              </div>
                          </div>
                      </div>
                    </div>
                    @empty
                      <div class="h-96 flex items-center justify-center mx-auto">
                        <div class="items-center text-center ">
                          <p class="mb-6">No Goals have been set</p>
                          @can('client-goals-create')
                            <a href="{{ route('goals.create', $user) }}" class="bg-primary hover:bg-primary text-white text-sm font-semibold py-2 px-4 rounded">Add New Goal</a>
                          @endcan
  
                        </div>
                        
                      </div>
                      
                    @endforelse 
                  </div>
                </div>
  
              </div>
            @endif
            

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

{{ $chart->script() }}
{{ $radarChart->script() }}

<script>

const counterEl = document.querySelector('.title-counter');
const initValue = parseInt(counterEl.innerText); 

let counter = 0;

setInterval(() => {
  
  if(counter < initValue) {
    counter++;
    counterEl.innerText = counter + '%'; 
  }
  
}, 15);


function openTab(tabName) {
      var tabcontent = document.getElementsByClassName("tabcontent");
      for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }

      var tabs = document.getElementsByClassName("tab");
    

      document.querySelector('.performance-chart.' + tabName).style.display = "block";
    }

    openTab('chart');


</script>

@endsection