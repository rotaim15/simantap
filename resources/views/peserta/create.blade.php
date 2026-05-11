@extends('layouts.dashboard')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">Tambah Peserta</h2>

    <form method="POST" action="{{ route('peserta.store') }}">
        @csrf

        <input type="text" name="nama"
            value="{{ $nama ?? '' }}"
            class="w-full border p-2 rounded mb-4"
            placeholder="Nama peserta">

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>

</div>
@endsection
