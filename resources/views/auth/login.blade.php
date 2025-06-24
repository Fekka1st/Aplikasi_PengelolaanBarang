<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengelolaan Barang| Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .shake {
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <!-- Centered Login Form -->
        <div class="w-full max-w-md mx-4">
            <div class="w-full bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
                <div class="p-3 bg-gradient-to-r from-blue-600 to-blue-500">
                    <h3 class="text-white font-bold">Login</h3>
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-center mb-6 px-6">
                        <img src="{{ asset('panel/assets/img/Logo_Strongnet.png') }}" alt="Logo Kiri" class="h-20 object-contain">
                        <img src="{{ asset('panel/assets/img/Logo.png') }}" alt="Logo Kanan" class="h-20 object-contain">
                    </div>



                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-1">Sistem Pengelolaan Barang</h2>
                    <p class="text-center text-gray-600 mb-6">Masukan Akun Anda</p>

                    <form id="loginForm"  method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    class="input-focus pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition duration-200"
                                    placeholder="your@email.com"
                                >
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    class="input-focus pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition duration-200"
                                    placeholder="••••••••"
                                >
                                <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center"
                            id="loginButton"
                        >
                            <span id="buttonText">Log In</span>
                            <i class="fas fa-spinner fa-spin ml-2 hidden" id="spinner"></i>
                        </button>
                    </form>
                </div>

                <div class="px-8 py-3 bg-gray-50 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-500">
                        © 2025 Sistem Pengelolaan Barang.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('spinner');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        });
    </script>
</body>
</html>
