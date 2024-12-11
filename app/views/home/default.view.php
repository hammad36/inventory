<section
    class="relative overflow-hidden  bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-22">
    <!-- Background Animation -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 animate-gradient"></div>
    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">

        <!-- Personalized Greeting -->
        <div class="my-8 min-w-2xl text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl animate-fade-up">
                Hello, <span class="text-blue-600"> <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Guest') ?> ! </span>
            </h1>
        </div>

        <div class="mx-auto min-w-2xl text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-800 sm:text-6xl animate-fade-up">
                Smart Inventory Management Made Easy
                <span class="text-gray-900">— Control at Your Fingertips</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-700 animate-fade-up animation-delay-200">
                Discover how our system streamlines your inventory process with powerful tools, intuitive design,
                and real-time analytics tailored for your success.
            </p>

        </div>

        <!-- Feature Cards with Animation -->
        <div class="relative mx-auto mt-12 max-w-6xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                class="rounded-2xl border border-gray-100 shadow-lg bg-white p-4 hover:scale-105 transition-transform duration-300 animate-fade-up">
                <img class="rounded-lg mb-4 w-full object-cover" src="/images/1.jpg" alt="Feature 1">
                <h3 class="text-lg font-semibold text-gray-800">Real-Time Stock Tracking</h3>
                <p class="text-sm text-gray-600">Monitor your inventory levels and movements with precision.</p>
            </div>
            <div
                class="rounded-2xl border border-gray-100 shadow-lg bg-white p-4 hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-200">
                <img class="rounded-lg mb-4 w-full object-cover" src="/images/2.jpg" alt="Feature 2">
                <h3 class="text-lg font-semibold text-gray-800">Insightful Reports</h3>
                <p class="text-sm text-gray-600">Generate detailed reports to make smarter business decisions.</p>
            </div>
            <div
                class="rounded-2xl border border-gray-100 shadow-lg bg-white p-4 hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                <img class="rounded-lg mb-4 w-full object-cover" src="/images/3.jpg" alt="Feature 3">
                <h3 class="text-lg font-semibold text-gray-800">Automated Alerts</h3>
                <p class="text-sm text-gray-600">Stay updated with automated notifications for low stock.</p>
            </div>
        </div>

        <!-- Statistics and Chart Section -->
        <div class="mt-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Your Business at a Glance</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-up">
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">500+</p>
                    <p class="text-gray-700">Products Managed</p>
                </div>
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">1,200+</p>
                    <p class="text-gray-700">Orders Processed</p>
                </div>
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">300+</p>
                    <p class="text-gray-700">Active Clients</p>
                </div>
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">99%</p>
                    <p class="text-gray-700">Accuracy Rate</p>
                </div>
            </div>
        </div>
    </div>
</section>

</main>