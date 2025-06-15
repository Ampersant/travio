<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Registration Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">

</head>

<body class="bg-gradient-to-br from-[#F38D61] to-[#A1C6EA] min-h-screen flex items-center justify-center p-4">
    <div class="custom-cursor"></div>
    <div class="cursor-follower"></div>

    <div class="card max-w-md w-full" id="interactiveCard">
        <div class="card-inner bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="relative">
                <div class="absolute -top-20 left-1/2 transform -translate-x-1/2">
                    <div class="floating bg-white p-4 rounded-full shadow-xl">
                        <i class="fas fa-user-plus text-4xl text-purple-600"></i>
                    </div>
                </div>

                <div class="pt-20 px-8 pb-6">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2 fade-in"
                        style="animation-delay: 0.1s;">Create Account</h1>
                    <p class="text-center text-gray-600 mb-8 fade-in" style="animation-delay: 0.2s;">Join our community
                        today</p>

                    <form action="{{ route('register.store') }}" method="POST" id="registerForm" class="space-y-6">
                        @csrf

                        <div class="input-field bg-gray-50 rounded-lg p-3 fade-in" style="animation-delay: 0.3s;">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <div class="flex items-center">
                                <i class="fas fa-user text-gray-400 mr-2"></i>
                                <input type="text" id="name" name="name" required
                                    class="w-full bg-transparent outline-none text-gray-800 placeholder-gray-400"
                                    placeholder="John Doe">
                            </div>
                            @error('name')
                                <div id="nameError" class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-field bg-gray-50 rounded-lg p-3 fade-in" style="animation-delay: 0.4s;">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                Address</label>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                <input type="email" id="email" name="email" required
                                    class="w-full bg-transparent outline-none text-gray-800 placeholder-gray-400"
                                    placeholder="john@example.com">
                            </div>
                            @error('email')
                                <div id="emailError" class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-field bg-gray-50 rounded-lg p-3 fade-in" style="animation-delay: 0.5s;">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="flex items-center">
                                <i class="fas fa-lock text-gray-400 mr-2"></i>
                                <input type="password" id="password" name="password" required
                                    class="w-full bg-transparent outline-none text-gray-800 placeholder-gray-400"
                                    placeholder="••••••••">
                                <span class="password-toggle text-gray-400 ml-2" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <div id="passwordError" class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="fade-in" style="animation-delay: 0.6s;">
                            <a href="{{ route('provider.handle', 'google') }}"
                                class="google-btn bg-white rounded-lg overflow-hidden flex items-center justify-center w-full my-3">
                                <div class="flex items-center px-6 py-3">
                                    <div class="bg-white p-1 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path fill="#4285F4"
                                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                            <path fill="#34A853"
                                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                            <path fill="#FBBC05"
                                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                            <path fill="#EA4335"
                                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                        </svg>
                                    </div>
                                    <span class="ml-4 text-gray-700 font-medium text-sm sm:text-base">Sign in with Google</span>
                                </div>
                            </a>
                            <button type="submit"
                                class="ripple w-full bg-gradient-to-r from-[#EEB462] to-[#D38071] text-white py-3 px-4 rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 active:scale-95">
                                Register Now
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6 text-sm text-gray-600 fade-in" style="animation-delay: 0.7s;">
                        Already have an account?
                        <a href="#" class="text-purple-600 font-medium hover:underline">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Custom cursor elements
            const cursor = document.querySelector('.custom-cursor');
            const cursorFollower = document.querySelector('.cursor-follower');

            // Card element
            const card = document.getElementById('interactiveCard');
            const cardInner = card.querySelector('.card-inner');
            const cardRect = card.getBoundingClientRect();
            const cardCenter = {
                x: cardRect.left + cardRect.width / 2,
                y: cardRect.top + cardRect.height / 2
            };

            // Track mouse position
            let mouseX = 0;
            let mouseY = 0;
            let followerX = 0;
            let followerY = 0;

            // Move custom cursor
            document.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;

                // Update custom cursor position
                cursor.style.left = mouseX + 'px';
                cursor.style.top = mouseY + 'px';

                // Calculate rotation based on mouse position relative to card center
                const relX = mouseX - cardCenter.x;
                const relY = mouseY - cardCenter.y;

                // Calculate rotation angles (limited to 15 degrees for subtle effect)
                const rotateY = (relX / cardRect.width) * 15;
                const rotateX = -(relY / cardRect.height) * 15;

                // Apply rotation to card
                cardInner.style.transform = `rotateY(${rotateY}deg) rotateX(${rotateX}deg)`;

                // Update card center position (in case of window resize)
                const newCardRect = card.getBoundingClientRect();
                cardCenter.x = newCardRect.left + newCardRect.width / 2;
                cardCenter.y = newCardRect.top + newCardRect.height / 2;
            });

            // Animate cursor follower
            function animateFollower() {
                // Ease out animation for follower
                followerX += (mouseX - followerX) * 0.2;
                followerY += (mouseY - followerY) * 0.2;

                cursorFollower.style.left = followerX + 'px';
                cursorFollower.style.top = followerY + 'px';

                requestAnimationFrame(animateFollower);
            }

            animateFollower();

            // Cursor effects on interactive elements
            const interactiveElements = document.querySelectorAll('button, a, input, .password-toggle');

            interactiveElements.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
                    cursor.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
                    cursorFollower.style.width = '30px';
                    cursorFollower.style.height = '30px';
                    cursorFollower.style.borderColor = 'rgba(255, 255, 255, 0.8)';
                });

                el.addEventListener('mouseleave', () => {
                    cursor.style.transform = 'translate(-50%, -50%) scale(1)';
                    cursor.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                    cursorFollower.style.width = '40px';
                    cursorFollower.style.height = '40px';
                    cursorFollower.style.borderColor = 'rgba(255, 255, 255, 0.5)';
                });
            });

            // Add animation delays to form elements
            const inputs = document.querySelectorAll('.input-field');
            inputs.forEach((input, index) => {
                input.style.animationDelay = `${0.3 + index * 0.1}s`;
            });

        });

        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
