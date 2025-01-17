<section
    class="relative overflow-hidden  bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12  sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 ">
    <!-- Background Animation -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 animate-gradient"></div>
    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">

        <!-- Personalized Greeting -->
        <div class="container mx-auto px-4 py-12 text-center">
            <h1 class="text-4xl font-bold tracking-tighter text-gray-900 md:text-6xl lg:text-7xl">
                Hello,
                <span class="bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                    <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Guest') ?>!
                </span>
            </h1>
        </div>

        <div class="mx-auto max-w-4xl px-4  text-center">
            <h1 class="text-2xl py-5 sm:text-3xl md:text-4xl lg:text-5xl font-extrabold tracking-tight text-blue-600 animate-fade-up">
                Your Ultimate Shopping Destination
                <span class="text-gray-900 block sm:inline">— Everything You Love, All in One Place</span>
            </h1>
            <p class="mt-4 py-5 text-base sm:text-lg md:text-xl leading-7 sm:leading-8 text-gray-700 animate-fade-up animation-delay-200">
                Explore our vast collection of premium products across all categories. Shop with confidence and enjoy seamless delivery to your doorstep.
            </p>
        </div>


        <!-- Feature Cards with Animation -->
        <div class="relative mx-auto mt-12 max-w-6xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Fashion Category -->
            <div class="group rounded-2xl border border-gray-200 shadow-lg bg-white p-6 hover:shadow-2xl transition-all duration-300 animate-fade-up">
                <div class="relative overflow-hidden rounded-xl mb-6">
                    <img class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=800&q=80"
                        alt="Fashion Collection">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 bg-blue-600 text-white text-sm rounded-full">Premium</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Fashion & Accessories</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Luxury Brand Collections
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Designer Accessories
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Premium Footwear
                    </p>
                </div>
            </div>

            <!-- Electronics Category -->
            <div class="group rounded-2xl border border-gray-200 shadow-lg bg-white p-6 hover:shadow-2xl transition-all duration-300 animate-fade-up animation-delay-200">
                <div class="relative overflow-hidden rounded-xl mb-6">
                    <img class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=800&q=80"
                        alt="Electronics Collection">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 bg-blue-600 text-white text-sm rounded-full">Featured</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Smart Electronics</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Latest Smartphones
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Gaming & Entertainment
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Smart Home Devices
                    </p>
                </div>
            </div>

            <!-- Home & Living Category -->
            <div class="group rounded-2xl border border-gray-200 shadow-lg bg-white p-6 hover:shadow-2xl transition-all duration-300 animate-fade-up animation-delay-400">
                <div class="relative overflow-hidden rounded-xl mb-6">
                    <img class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1556912172-45b7abe8b7e1?auto=format&fit=crop&w=800&q=80"
                        alt="Home & Living Collection">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 bg-blue-600 text-white text-sm rounded-full">New</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Home & Living</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Premium Appliances
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Modern Furniture
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Home Decor
                    </p>
                </div>
            </div>

            <!-- Toys & Games Category -->
            <div class="group rounded-2xl border border-gray-200 shadow-lg bg-white p-6 hover:shadow-2xl transition-all duration-300 animate-fade-up animation-delay-500">
                <div class="relative overflow-hidden rounded-xl mb-6">
                    <img class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?auto=format&fit=crop&w=800&q=80"
                        alt="Toys & Games Collection">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 bg-blue-600 text-white text-sm rounded-full">Popular</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Toys & Games</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Educational Toys
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Board Games & Puzzles
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Outdoor Play Equipment
                    </p>
                </div>
            </div>

            <!-- Books & Stationery Category -->
            <div class="group rounded-2xl border border-gray-200 shadow-lg bg-white p-6 hover:shadow-2xl transition-all duration-300 animate-fade-up animation-delay-600">
                <div class="relative overflow-hidden rounded-xl mb-6">
                    <img class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=800&q=80"
                        alt="Books & Stationery Collection">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 bg-blue-600 text-white text-sm rounded-full">Trending</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Books & Stationery</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Best-Selling Books
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Premium Stationery
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Art & Craft Supplies
                    </p>
                </div>
            </div>
            <!-- Beauty & Personal Care Category -->
            <div class="group rounded-2xl border border-gray-200 shadow-lg bg-white p-6 hover:shadow-2xl transition-all duration-300 animate-fade-up animation-delay-700">
                <div class="relative overflow-hidden rounded-xl mb-6">
                    <img class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=800&q=80"
                        alt="Beauty & Personal Care Collection">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="px-3 py-1 bg-blue-600 text-white text-sm rounded-full">Luxe</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Beauty & Personal Care</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Skincare & Cosmetics
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Fragrances & Perfumes
                    </p>
                    <p class="flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Hair Care & Styling
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistics and Chart Section -->
        <div class="mt-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">
                Our Growing Marketplace
            </h2>

            <p class="text-lg text-gray-600 mb-10">
                Join our ever-expanding community of satisfied shoppers
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-up">
                <!-- Categories -->
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">
                        <?= htmlspecialchars($categoryNumber ?? 0, ENT_QUOTES, 'UTF-8') ?>+
                    </p>
                    <p class="text-gray-700">
                        Active Categories
                    </p>
                </div>
                <!-- Products -->
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">
                        <?= htmlspecialchars($productNumber ?? 0, ENT_QUOTES, 'UTF-8') ?>+
                    </p>
                    <p class="text-gray-700">
                        Available Products
                    </p>
                </div>
                <!-- Users -->
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">
                        <?= htmlspecialchars($usersNumber ?? 0, ENT_QUOTES, 'UTF-8') ?>+
                    </p>
                    <p class="text-gray-700">
                        Registered Users
                    </p>
                </div>
                <!-- Accuracy Rate -->
                <div class="p-6 bg-white shadow rounded-lg hover:scale-105 transition-transform duration-300 animate-fade-up animation-delay-400">
                    <p class="text-2xl font-bold text-blue-600">99%</p>
                    <p class="text-gray-700">
                        Inventory Accuracy Rate
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

</main>