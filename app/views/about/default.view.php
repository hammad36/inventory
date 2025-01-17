<!-- About Us Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-200 via-white to-blue-100 to-transparent pb-16 pt-20 sm:pb-20 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-40">
    <!-- Background Animation -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-blue-50 animate-pulse"></div>
    <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-5xl font-extrabold text-blue-600">Who We Are</h2>
            <p class="mt-6 text-lg leading-7 text-gray-900 dark:text-gray-900">
                Welcome to your ultimate shopping destination, where we bring together a curated collection of premium products across fashion, electronics, home living, and more. Our marketplace is designed to provide you with an exceptional shopping experience, offering carefully selected items from trusted brands and sellers worldwide. We're committed to making your shopping journey seamless, enjoyable, and rewarding.
            </p>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="bg-white dark:bg-gray-800">
    <div class="py-16 px-6 mx-auto max-w-screen-xl lg:py-24 lg:px-8">
        <div class="text-center">
            <h2 class="text-4xl font-extrabold text-gray-100">Our Services</h2>
            <p class="mt-4 mb-12 text-lg text-gray-200">
                Experience shopping excellence with our comprehensive range of services designed to enhance your buying journey.
            </p>
        </div>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md transition-transform transform hover:scale-105">
                <h3 class="text-xl font-bold text-gray-100">Premium Selection</h3>
                <p class="mt-2 text-gray-200">
                    Access a vast collection of high-quality products across multiple categories, carefully curated for our discerning customers.
                </p>
            </div>
            <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md transition-transform transform hover:scale-105">
                <h3 class="text-xl font-bold text-gray-100">Smart Shopping</h3>
                <p class="mt-2 text-gray-200">
                    Enjoy personalized recommendations and detailed product insights to make informed purchasing decisions.
                </p>
            </div>
            <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md transition-transform transform hover:scale-105">
                <h3 class="text-xl font-bold text-gray-100">Seamless Experience</h3>
                <p class="mt-2 text-gray-200">
                    Shop with confidence using our secure payment systems and enjoy reliable delivery services.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-16 px-6">
    <div class="mx-auto max-w-screen-xl lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold">Why Shop With Us?</h2>
            <p class="mt-4 text-lg">
                Discover the advantages of shopping at your favorite marketplace, where quality meets convenience.
            </p>
        </div>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <div class="p-6 bg-white rounded-lg text-gray-800 shadow-md hover:shadow-lg transform hover:scale-105">
                <h3 class="text-xl font-bold">24/7 Customer Support</h3>
                <p class="mt-2 text-gray-600">
                    Our dedicated support team is always ready to assist you with any shopping-related queries or concerns.
                </p>
            </div>
            <div class="p-6 bg-white rounded-lg text-gray-800 shadow-md hover:shadow-lg transform hover:scale-105">
                <h3 class="text-xl font-bold">Secure Shopping</h3>
                <p class="mt-2 text-gray-600">
                    Shop with peace of mind knowing your transactions and personal information are protected.
                </p>
            </div>
            <div class="p-6 bg-white rounded-lg text-gray-800 shadow-md hover:shadow-lg transform hover:scale-105">
                <h3 class="text-xl font-bold">Quality Guaranteed</h3>
                <p class="mt-2 text-gray-600">
                    Every product in our marketplace meets strict quality standards to ensure customer satisfaction.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Us Section -->
<section class="bg-gray-50 dark:bg-gray-900 py-16">
    <div class="px-6 mx-auto max-w-screen-xl lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Get in Touch</h2>
            <p class="mt-4 text-lg text-gray-600 ">
                Have questions or need personalized assistance? Our team is here to help. Connect with us today!
            </p>
            <!-- Alert Handler -->
            <?php

            use inventory\lib\alertHandler;

            alertHandler::getInstance()->handleAlert();
            ?>
        </div>
        <form action="/about" method="POST" class="max-w-lg mx-auto space-y-6">
            <div>
                <label for="name" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Your Name</label>
                <input type="text" id="name" name="name"
                    class="w-full p-3 rounded-lg bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white"
                    placeholder="Enter your name" required>
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Your Email</label>
                <input type="email" id="email" name="email"
                    class="w-full p-3 rounded-lg bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white"
                    placeholder="Enter your email" required>
            </div>
            <div>
                <label for="message_text" class="block mb-2 text-sm text-gray-700 dark:text-gray-300">Your Message</label>
                <textarea id="message_text" name="message_text" rows="4"
                    class="w-full p-3 rounded-lg bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white"
                    placeholder="Write your message" required></textarea>
            </div>
            <button type="submit"
                class="w-full py-3 px-6 bg-indigo-600 rounded-lg font-medium text-white hover:bg-indigo-700">
                Send Message
            </button>
        </form>

    </div>
</section>