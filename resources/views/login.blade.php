<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
            <h2 class="text-white text-xl font-bold">Đăng nhập</h2>
        </div>

        <div class="p-6">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="admin@gmail.com" required 
                        class="w-full px-4 py-2 bg-blue-50/50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:bg-white transition" >
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Mật khẩu <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="password" value="12345678" required 
                            class="w-full px-4 py-2 bg-blue-50/50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:bg-white transition">
                        
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-4 flex items-center border-l border-gray-300 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-lg flex justify-center items-center transition shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span>Đăng nhập</span>
                    <svg class="w-5 h-5 ml-2 opacity-0" fill="none" viewBox="0 0 24 24"></svg>
                </button>
            </form>


        </div>
    </div>

    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>