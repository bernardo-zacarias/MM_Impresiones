@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Editar perfil</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perfil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Comuna</label>
            <input type="text" name="comuna" value="{{ old('comuna', $user->comuna) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Ciudad</label>
            <input type="text" name="ciudad" value="{{ old('ciudad', $user->ciudad) }}" class="w-full border rounded px-3 py-2">
        </div>

        <hr class="my-4">
        <p class="mb-2 font-medium">Cambiar contraseña (opcional)</p>

        <div class="mb-4">
            <label class="block font-medium">Nueva contraseña</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Guardar cambios</button>
            <a href="{{ route('perfil.show') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Cancelar</a>
        </div>
    </form>
</div>
@endsection
