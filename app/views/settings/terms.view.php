<main class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Terms and Conditions</h1>
                <p class="text-blue-100">Last Updated: <?php echo date('F d, Y'); ?></p>
            </div>
            <a href="/settings" class="text-white hover:text-blue-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Terms Content -->
        <div class="p-6 space-y-6 text-gray-700">
            <!-- Acceptance of Terms -->
            <section>
                <h2 class="text-xl font-semibold text-blue-800 mb-4">1. Acceptance of Terms</h2>
                <p class="mb-4">
                    By accessing and using this service, you accept and agree to be bound by the terms and provisions of this agreement.
                    Please read these terms carefully before using our service.
                </p>
            </section>

            <!-- User Rights -->
            <section>
                <h2 class="text-xl font-semibold text-blue-800 mb-4">2. User Rights and Responsibilities</h2>
                <ul class="list-disc list-inside space-y-2">
                    <li>You must provide accurate and complete information</li>
                    <li>You are responsible for maintaining the confidentiality of your account</li>
                    <li>You agree to use the service only for lawful purposes</li>
                    <li>You must not use the service to infringe on the rights of others</li>
                </ul>
            </section>

            <!-- Privacy -->
            <section>
                <h2 class="text-xl font-semibold text-blue-800 mb-4">3. Privacy Policy</h2>
                <p class="mb-4">
                    We are committed to protecting your privacy. Our Privacy Policy, which is incorporated into these terms,
                    explains how we collect, use, and protect your personal information.
                </p>
                <ul class="list-disc list-inside space-y-2">
                    <li>We collect only necessary information</li>
                    <li>Your data is securely stored and protected</li>
                    <li>We do not sell your personal information to third parties</li>
                </ul>
            </section>

            <!-- Intellectual Property -->
            <section>
                <h2 class="text-xl font-semibold text-blue-800 mb-4">4. Intellectual Property</h2>
                <p class="mb-4">
                    All content, features, and functionality are and will remain the exclusive property of our company
                    and are protected by international copyright, trademark, and other intellectual property laws.
                </p>
            </section>

            <!-- Limitation of Liability -->
            <section>
                <h2 class="text-xl font-semibold text-blue-800 mb-4">5. Limitation of Liability</h2>
                <p class="mb-4">
                    Our service is provided "as is" and "as available" without any warranties of any kind,
                    either express or implied. We shall not be liable for any direct, indirect, incidental,
                    special, consequential, or punitive damages.
                </p>
            </section>

            <!-- Termination -->
            <section>
                <h2 class="text-xl font-semibold text-blue-800 mb-4">6. Termination</h2>
                <p class="mb-4">
                    We reserve the right to terminate or suspend your account and access to the service
                    at our sole discretion, without notice, for any reason, including breach of these terms.
                </p>
            </section>

            <!-- Consent -->
            <section class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-xl font-semibold text-blue-800 mb-4">7. Your Consent</h2>
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="terms-consent"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2">
                    <label for="terms-consent" class="text-sm text-gray-700">
                        I have read, understood, and agree to the Terms and Conditions
                    </label>
                </div>
            </section>

            <!-- Contact Information -->
            <section class="bg-blue-50 p-4 rounded-lg">
                <h2 class="text-xl font-semibold text-blue-800 mb-4">Contact Us</h2>
                <p>
                    If you have any questions about these Terms and Conditions, please contact us at:
                    <br>
                    <a href="mailto:legal@company.com" class="text-blue-600 hover:underline">legal@company.com</a>
                </p>
            </section>
        </div>

        <!-- Action Buttons -->
        <div class="p-6 bg-gray-100 flex justify-between items-center">
            <a
                href="/privacy-policy"
                class="text-blue-600 hover:text-blue-800 transition">
                View Full Privacy Policy
            </a>
            <button
                id="accept-terms"
                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>
                Accept Terms
            </button>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const consentCheckbox = document.getElementById('terms-consent');
        const acceptButton = document.getElementById('accept-terms');

        consentCheckbox.addEventListener('change', function() {
            acceptButton.disabled = !this.checked;
        });

        acceptButton.addEventListener('click', function() {
            if (consentCheckbox.checked) {
                // Here you would typically make an AJAX call to record the user's consent
                alert('Terms and Conditions Accepted');
                // Redirect or perform necessary actions
            }
        });
    });
</script>