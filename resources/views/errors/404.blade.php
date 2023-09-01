<x-app-layout>
    <div class=" mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white p-16 text-center">
            <h2 class="text-2xl font-semibold mb-4 text-red-600">An Error Has Occured</h2>
            <h2 class="px-6">We're sorry, but the page you requested could not be found. This may have occurred because of a broken link, a resource that has expired, an incorrect URL typo, or the page may have been moved to a new location. Don't worry though - you can find plenty of great information by navigating using the menu above or searching from the homepage. If you believe you have received this page in error, please double check the URL you entered or contact the site administrator for assistance locating what you need. Thank you for visiting, and we hope you find what you were searching for!</h2>
            <div class="mt-8">
                <div class="p-6 bg-red-100 rounded shadow mb-4 border-red-600 border-2 drop-shadow-md">
                    <p class="text-red-600">{{ $exception->getMessage() }}</p>
                </div>
                <a href="{{ url('/') }}" class="bg-primary text-white font-semibold py-4 px-4 rounded text-base">Back to Homepage</a>

            </div>
        </div>
    </div>
</x-app-layout>