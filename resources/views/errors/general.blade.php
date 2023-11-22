<x-app-layout>
    <div class=" mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white p-16 text-center">
            <h2 class="text-2xl font-semibold mb-4 text-red-600">An Error Has Occured</h2>
            <h2 class="px-6">We're sorry, an unexpected error has occurred in the application. The technical details of the error are shown below. If you do not understand the cause of this error, please contact your Practitioner and they can reach out to the Support Developers on your behalf. The Support Team will investigate the issue and work to resolve it as quickly as possible. We apologize for any inconvenience this has caused. Please include the error details below in your message to your Practitioner to help the Support Developers properly identify and troubleshoot the problem.</h2>
            <div class="mt-8">
                <div class="p-6 bg-red-100 rounded shadow mb-4 border-red-600 border-2 drop-shadow-md">
                    <p class="text-red-600">{{ $exception->getMessage() }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>