@extends('layouts.standard')

@section('content')

  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <div class="grid lg:grid-cols-2 h-screen mx-8 py-4">

    <div class="md:p-8 flex items-center justify-center">
        <div class="w-10/12">

            <h1 class="text-primary text-2xl font-bold mb-2">Welcome Back</h1>

            <p class="text-black text-base">Please enter your details to sign in.</p>

            {{-- form --}}
            <form method="POST" action="{{ route('login') }}" class="w-full md:max-w-md mt-4">

                @csrf

                <!-- Email Address -->
                <div>
                <x-input-label for="email" :value="__('Email')" />
                
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
                </div>

            </form>
        </div>

    </div>
    

    <div class="hidden bg-gray-200 lg:flex items-center ">
      <div class="relative overflow-hidden w-full h-full bg-red-50">
        <div class="carousel h-full">
         
          {{-- Slide 1 --}}
          <div class="carousel-slide h-full p-14 text-white flex flex-col justify-end" style="background: linear-gradient(0deg, rgba(2,0,36,1) 0%, rgba(20,64,103,1) 0%, rgba(0,212,255,0) 60%), url('{{ asset('storage/images/Cemal_Testimony.png') }}'); background-size: cover;">
            <div class="testimonial-content">
              <p class="testimonial-description mb-4 text-lg">"Rifat has been a game-changer. I would sometimes struggle with self-talk which affected how I played. But Rifat's support has helped me a lot. I stay more focused and even play better in high-pressure matches. My performances improved massively. I would highly recommend Star Mentality to any athlete"</p>
              <div class="testimonial-information flex justify-between">
                <div class="left">
                  <p><span class="font-bold">Client:</span> Cemal</p>
                  <p>Goalkeeper</p>
                </div>
                <div class="right">
                  <div class="star-rating">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                  </div>
                </div>
                <style>
                    .star-rating {
                        margin-top: 10px;
                    }
            
                    .star {
                        font-size: 24px;
                        color: gold; /* Adjust the color as needed */
                    }
                </style>
              </div>
            </div>
          </div>

          <div class="carousel-slide h-full p-14 text-white flex flex-col justify-end" style="background: linear-gradient(0deg, rgb(2, 0, 36) 0%, rgba(20,64,103,1) 0%, rgba(0,212,255,0) 40%), url('{{ asset('storage/images/Jurgen_Testimony.png') }}'); background-size: cover;">
            <div class="testimonial-content">
              <p class="testimonial-description mb-4 text-lg">Without a doubt, getting over injury isn’t easy but working with Rifat helped me a lot. The work we did together was insightful and valuable. He helped me get back on the court and back to playing at my best</p>
              <div class="testimonial-information flex justify-between">
                <div class="left">
                  <p><span class="font-bold">Client:</span> Jurgen</p>
                  <p>Basketballer</p>
                </div>
                <div class="right">
                  <div class="star-rating">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                  </div>
                </div>
                <style>
                    .star-rating {
                        margin-top: 10px;
                    }
            
                    .star {
                        font-size: 24px;
                        color: gold; /* Adjust the color as needed */
                    }
                </style>
              </div>
            </div>
          </div>
          
        </div>
        
        <!-- Navigation Buttons -->
        <button class="carousel-prev absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white px-2 py-1 rounded-full" onclick="prevSlide()">
          <
        </button>
        <button class="carousel-next absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white px-2 py-1 rounded-full" onclick="nextSlide()">
          >
        </button>
      </div>
      
    </div>

  </div>

  <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
  
    function showSlide(index) {
      slides.forEach(slide => slide.style.display = 'none');
      slides[index].style.display = 'flex';
    }
  
    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }
  
    function prevSlide() {
      currentSlide = (currentSlide - 1 + slides.length) % slides.length;
      showSlide(currentSlide);
    }
  
    // Initialize the first slide to be visible
    showSlide(currentSlide);
  </script>
  

@endsection