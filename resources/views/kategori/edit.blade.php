@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('kategori.update', $kategori) }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-2">
                            Nama Kategori
                        </label>

                        <input
                            type="text"
                            name="nama_kategori"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                            required
                        >

                        @error('nama_kategori')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-2">
                            Jenis
                        </label>

                        <select
                            name="jenis"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                            required
                        >
                            <option value="pemasukan"
                                {{ old('jenis', $kategori->jenis) == 'pemasukan' ? 'selected' : '' }}>
                                Pemasukan
                            </option>

                            <option value="pengeluaran"
                                {{ old('jenis', $kategori->jenis) == 'pengeluaran' ? 'selected' : '' }}>
                                Pengeluaran
                            </option>
                        </select>

                        @error('jenis')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">
                            Kelompok Kategori
                        </label>

                        <select
                            name="kelompok"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                            required
                        >
                            @php
                                $kelompokList = [
                                    'omset' => 'Omset',
                                    'hpp' => 'HPP',
                                    'operasional' => 'Operasional',
                                    'non_operasional' => 'Non Operasional',
                                    'pajak' => 'Pajak',
                                    'depresiasi' => 'Depresiasi',
                                    'lainnya' => 'Lainnya',
                                ];
                            @endphp

                            @foreach ($kelompokList as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('kelompok', $kategori->kelompok) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('kelompok')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md"
                        >
                            Simpan Perubahan
                        </button>

                        <a
                            href="{{ route('kategori.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md"
                        >
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection