@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Mi perfil</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Teléfono:</strong> {{ $user->telefono ?? '-' }}</p>
        <p><strong>Comuna:</strong> {{ $user->comuna ?? '-' }}</p>
        <p><strong>Ciudad:</strong> {{ $user->ciudad ?? '-' }}</p>

        <div class="mt-4">
            <a href="{{ route('perfil.edit') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Editar perfil</a>
        </div>
    </div>
</div>
@endsection
