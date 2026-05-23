<!-- Popup Enquiry Form -->
<div id="popup-form" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-md mx-4 z-10 relative animate-[fadeIn_0.3s_ease-in-out]">
        <button id="close-popup" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            <i class="fas fa-times text-xl"></i>
        </button>

        <h3 class="text-xl font-bold text-blue-500 mb-4 text-center">Enquire Now</h3>

        <form action="process-form.php" method="POST" class="space-y-4">
            <div>
                <input type="text" name="name" placeholder="Your Name*" required minlength="2"
                    pattern="[a-zA-Z\s\p{L}.'\\-]*" title="Name can only contain letters, spaces, dots, hyphens and apostrophes"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            </div>

            <div>
                <input type="email" name="email" placeholder="Email Address*" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            </div>

            <div>
                <input type="tel" name="phone" placeholder="Phone Number*" required minlength="10" maxlength="10"
                    pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
            </div>

            <input type="hidden" name="form_source" value="popup_form">
            <input type="hidden" name="form_type" id="popup-form-type" value="general">

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                DOWNLOAD BROCHURE
            </button>
        </form>
    </div>
</div>