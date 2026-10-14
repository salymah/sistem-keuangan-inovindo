<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Keuangan') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">

        <div class="w-full px-4" style="max-width: 500px; margin: 0 auto;">

            <!-- Logo / Nama Sistem -->
            <div class="text-center mb-6">

                <a href="/" class="inline-flex flex-col items-center">

                    <div class="flex items-center justify-center w-16 h-16
                                bg-blue-100 rounded-2xl mb-3">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-8 h-8 text-blue-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M7 14h.01M11 14h2" />

                        </svg>

                    </div>

                    <span class="text-xl font-bold text-gray-800">
                        Sistem Keuangan
                    </span>

                </a>

            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

                <div class="px-6 py-7 sm:px-8">

                    {{ $slot }}

                </div>

            </div>

            <!-- Footer -->
            <p class="text-center text-sm text-gray-500 mt-5">
                © {{ date('Y') }} Sistem Keuangan
            </p>

        </div>

    </div>

</body>

</html>