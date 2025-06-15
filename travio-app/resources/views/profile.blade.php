<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <!-- Profile Header with Avatar -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 fade-in">
            <div class="p-8 text-center">
                <div class="avatar-upload">
                    <img src="{{$user->avatar_url}}" alt="Profile"
                        class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-indigo-100">
                    <div class="avatar-overlay">
                        <span class="text-white text-sm font-medium">
                            <i class="fas fa-camera mr-1"></i> Change
                        </span>
                    </div>
                </div>
                <h1 class="text-2xl font-bold mt-4">{{ $user->name }}</h1>
                <p class="text-gray-500">{{ $user->email }}</p>
                <p class="text-gray-500 mt-1">Member since {{ $user->created_at }}</p>
            </div>

            <!-- Navigation Tabs -->
            <div class="border-t border-gray-200">
                <nav class="flex divide-x divide-gray-200">
                    <button
                        class="tab-button flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-indigo-600 active"
                        data-section="appearance">
                        <i class="fas fa-palette mr-2"></i> Appearance
                    </button>
                    <button
                        class="tab-button flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-indigo-600"
                        data-section="privacy">
                        <i class="fas fa-lock mr-2"></i> Privacy & Payment
                    </button>
                    <button
                        class="tab-button flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-indigo-600"
                        data-section="settings">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </button>
                </nav>
            </div>
        </div>

        <!-- Appearance Section -->
        <section id="appearance" class="profile-section active">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 fade-in">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Theme Preferences</h2>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Color Scheme</label>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="theme-option">
                                <input type="radio" id="light-theme" name="theme" class="hidden peer" checked>
                                <label for="light-theme"
                                    class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-500 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full bg-white border border-gray-300 mr-3"></div>
                                        <span>Light</span>
                                    </div>
                                </label>
                            </div>
                            <div class="theme-option">
                                <input type="radio" id="dark-theme" name="theme" class="hidden peer">
                                <label for="dark-theme"
                                    class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-500 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full bg-gray-800 border border-gray-700 mr-3"></div>
                                        <span>Dark</span>
                                    </div>
                                </label>
                            </div>
                            <div class="theme-option">
                                <input type="radio" id="system-theme" name="theme" class="hidden peer">
                                <label for="system-theme"
                                    class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-500 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div
                                            class="w-6 h-6 rounded-full bg-gradient-to-r from-gray-200 to-gray-800 border border-gray-300 mr-3">
                                        </div>
                                        <span>System</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Accent Color</label>
                        <div class="grid grid-cols-5 gap-3">
                            <div class="color-option">
                                <input type="radio" id="indigo-color" name="color" class="hidden peer" checked>
                                <label for="indigo-color"
                                    class="block w-10 h-10 rounded-full bg-indigo-500 cursor-pointer peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500"></label>
                            </div>
                            <div class="color-option">
                                <input type="radio" id="blue-color" name="color" class="hidden peer">
                                <label for="blue-color"
                                    class="block w-10 h-10 rounded-full bg-blue-500 cursor-pointer peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-blue-500"></label>
                            </div>
                            <div class="color-option">
                                <input type="radio" id="green-color" name="color" class="hidden peer">
                                <label for="green-color"
                                    class="block w-10 h-10 rounded-full bg-green-500 cursor-pointer peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-green-500"></label>
                            </div>
                            <div class="color-option">
                                <input type="radio" id="red-color" name="color" class="hidden peer">
                                <label for="red-color"
                                    class="block w-10 h-10 rounded-full bg-red-500 cursor-pointer peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-red-500"></label>
                            </div>
                            <div class="color-option">
                                <input type="radio" id="purple-color" name="color" class="hidden peer">
                                <label for="purple-color"
                                    class="block w-10 h-10 rounded-full bg-purple-500 cursor-pointer peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-purple-500"></label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Font Size</label>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500 mr-2">Small</span>
                            <input type="range" min="12" max="18" value="14"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            <span class="text-sm text-gray-500 ml-2">Large</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 text-right">
                    <button
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>
        </section>

        <!-- Privacy & Payment Section -->
        <section id="privacy" class="profile-section">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Privacy Settings</h2>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-medium">Profile Visibility</h3>
                                <p class="text-sm text-gray-500">Who can see your profile information</p>
                            </div>
                            <select
                                class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option>Public</option>
                                <option>Friends Only</option>
                                <option>Private</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-medium">Activity Status</h3>
                                <p class="text-sm text-gray-500">Show when you're active on the platform</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium">Data Sharing</h3>
                                <p class="text-sm text-gray-500">Allow sharing analytics data with third parties</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Payment Methods</h3>
                        <div class="space-y-4">
                            <div class="border rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-6 bg-blue-500 rounded flex items-center justify-center mr-3">
                                        <i class="fas fa-credit-card text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Visa ending in 4242</p>
                                        <p class="text-sm text-gray-500">Expires 05/2025</p>
                                    </div>
                                </div>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <div class="border rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-6 bg-gray-800 rounded flex items-center justify-center mr-3">
                                        <i class="fab fa-cc-mastercard text-white text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Mastercard ending in 5555</p>
                                        <p class="text-sm text-gray-500">Expires 11/2024</p>
                                    </div>
                                </div>
                                <button class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <button
                                class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:text-indigo-600 hover:border-indigo-300 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Add Payment Method
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 text-right">
                    <button
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>
        </section>

        <!-- Settings Section -->
        <section id="settings" class="profile-section">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Account Settings</h2>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="font-medium mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nickname</label>
                                <input type="text"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    value="{{ $user->email }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-medium mb-4">Change Password</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                                    Password</label>
                                <input type="password"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Account Actions</h3>
                        <div class="space-y-3">
                            <button
                                class="w-full text-left p-4 border rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <span class="text-red-600 font-medium">Delete Account</span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left p-4 border rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-between">
                                    <span class="text-red-600 font-medium">Logout</span>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </button>
                            </form>

                            <button
                                class="w-full text-left p-4 border rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <span class="text-indigo-600 font-medium">Export Data</span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </button>
                            <button
                                class="w-full text-left p-4 border rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Download Backup</span>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 text-right">
                    <button
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Save Changes
                    </button>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const profileSections = document.querySelectorAll('.profile-section');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons and sections
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    profileSections.forEach(section => section.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Show corresponding section
                    const sectionId = this.getAttribute('data-section');
                    document.getElementById(sectionId).classList.add('active');
                });
            });

            // Theme selection
            const themeOptions = document.querySelectorAll('.theme-option input');
            themeOptions.forEach(option => {
                option.addEventListener('change', function() {
                    // In a real app, you would apply the theme here
                    console.log('Theme changed to:', this.id);
                });
            });

            // Color selection
            const colorOptions = document.querySelectorAll('.color-option input');
            colorOptions.forEach(option => {
                option.addEventListener('change', function() {
                    // In a real app, you would apply the color here
                    console.log('Accent color changed to:', this.id);
                });
            });

            // Avatar upload simulation
            const avatarUpload = document.querySelector('.avatar-upload');
            avatarUpload.addEventListener('click', function() {
                // In a real app, this would trigger a file upload dialog
                alert('Avatar upload functionality would go here');
            });
        });
    </script>
</body>

</html>
