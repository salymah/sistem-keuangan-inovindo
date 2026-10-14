<x-guest-layout>

    <!-- Judul -->
    <div class="text-center mb-6">

        <div class="flex items-center justify-center w-14 h-14
                    bg-blue-100 rounded-2xl mx-auto mb-4">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-7 h-7 text-blue-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2z" />

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M8 10V7a4 4 0 118 0v3" />

            </svg>

        </div>

        <h2 class="text-2xl font-bold text-gray-800">
            Lupa Password?
        </h2>

        <p class="text-sm text-gray-500 mt-2 leading-relaxed">
            Jangan khawatir. Masukkan email yang terdaftar
            untuk mendapatkan link reset password.
        </p>

    </div>


    <!-- Status -->
    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />


    <!-- Form -->
    <form method="POST" action="{{ route('password.email') }}">

        @csrf

        <!-- Email -->
        <div>

            <label
                for="email"
                class="block text-sm font-semibold text-gray-700 mb-2"
            >
                Email
            </label>

            <div class="relative">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-gray-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />

                    </svg>

                </div>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email Anda"
                    required
                    autofocus
                    class="block w-full pl-10 pr-4 py-3
                           border border-gray-300 rounded-lg
                           text-gray-800
                           placeholder-gray-400
                           focus:border-blue-500
                           focus:ring-2 focus:ring-blue-200
                           outline-none transition"
                >

            </div>

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


        <!-- Tombol -->
        <div class="mt-6">

            <button
                type="submit"
                class="w-full flex items-center justify-center
                       gap-2
                       bg-blue-600
                       hover:bg-blue-700
                       text-white
                       font-semibold
                       py-3
                       px-4
                       rounded-lg
                       transition
                       duration-200
                       shadow-sm"
            >

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />

                </svg>

                KIRIM LINK RESET PASSWORD

            </button>

        </div>

    </form>


    <!-- Kembali ke Login -->
    <div class="text-center mt-6">

        <a
            href="{{ route('login') }}"
            class="inline-flex items-center gap-1
                   text-sm
                   text-blue-600
                   hover:text-blue-700
                   font-semibold"
        >

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 19l-7-7 7-7" />

            </svg>

            Kembali ke Login

        </a>

    </div>

</x-guest-layout>