@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Perbandingan Kriteria</h2>
    @include('matriks-kriteria.form', ['matriksKriteria' => $matriksKriteria, 'kriteria' => $kriteria])
</div>
@endsection
