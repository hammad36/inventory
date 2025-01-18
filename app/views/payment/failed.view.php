<section class="min-h-[calc(100vh-8rem)] relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-22"
    x-data="{ showLoading: false }">
    <!-- Enhanced Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 opacity-75"></div>

    <div class="relative z-20 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Failed Message -->
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <!-- Failed Icon -->
            <div class="mx-auto h-16 w-16 flex items-center justify-center bg-red-100 rounded-full">
                <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <!-- Failed Text -->
            <h2 class="mt-6 text-3xl font-bold text-gray-800">Payment Failed!</h2>
            <p class="mt-2 text-gray-600">We encountered an issue processing your payment. Please try again.</p>

            <!-- Retry Payment Button -->
            <div class="mt-8">
                <a href="/cart/checkout"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Retry Payment
                </a>
            </div>
        </div>
    </div>
</section>