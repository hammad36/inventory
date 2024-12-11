<main class="flex-grow container mx-auto py-6 min-h-[calc(101.1vh-8rem)]">
    <section class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-lg mt-10 transform transition hover:scale-110 duration-300">
        <div class="flex flex-col items-center">


            <!-- User Information -->
            <h1 class="text-3xl font-bold text-blue-900 mb-4">
                <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
            </h1>
            <p class="text-sm font-medium text-gray-500">Role: <span class="text-blue-700"> <?php echo htmlspecialchars($_SESSION['user']['role']); ?> </span> </p>

            <!-- Details Section -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6 w-full text-center sm:text-left ">
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Email</h2>
                    <p class="text-gray-700">
                        <?php echo htmlspecialchars($_SESSION['user']['email']); ?>
                    </p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Date of Birth</h2>
                    <p class="text-gray-700">
                        <?php echo htmlspecialchars($_SESSION['user']['date_of_birth']); ?>
                    </p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Gender</h2>
                    <p class="text-gray-700">
                        <?php echo htmlspecialchars($_SESSION['user']['gender']); ?>
                    </p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow-sm transform transition hover:scale-105 duration-300">
                    <h2 class="text-lg font-semibold text-blue-600">Member Since</h2>
                    <p class="text-gray-700">
                        <?php echo htmlspecialchars($_SESSION['user']['created_at']); ?>
                    </p>
                </div>
            </div>

        </div>
    </section>
</main>