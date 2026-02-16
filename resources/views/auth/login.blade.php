<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventario de Autos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="bi bi-car-front-fill"></i>
                <h1>Panel de Administración</h1>
                <p>Inventario de Autos</p>
            </div>

            <div class="login-body">
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.authenticate') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="correo" class="form-label">
                            <i class="bi bi-envelope-fill me-1"></i>Correo Electrónico
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input 
                                type="email" 
                                class="form-control @error('correo') is-invalid @enderror" 
                                id="correo" 
                                name="correo" 
                                value="{{ old('correo') }}"
                                placeholder="usuario@ejemplo.com"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="contra" class="form-label">
                            <i class="bi bi-lock-fill me-1"></i>Contraseña
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-shield-lock-fill"></i>
                            </span>
                            <input 
                                type="password" 
                                class="form-control @error('contra') is-invalid @enderror" 
                                id="contra" 
                                name="contra" 
                                placeholder="Ingresa tu contraseña"
                                required
                            >
                            <span class="input-group-text password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye-fill" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-white-50">© 2026 Sistema de Inventario de Autos</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>