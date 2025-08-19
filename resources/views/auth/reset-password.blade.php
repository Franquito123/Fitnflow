@extends('layouts.app-master')

@section('content')
<div class="container">
    <h2>Establecer nueva contraseña</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" required>
            @error('email') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="password">Nueva contraseña</label>
            <input type="password" name="password" required>
            @error('password') <div>{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Restablecer contraseña</button>
    </form>
</div>
@endsection
