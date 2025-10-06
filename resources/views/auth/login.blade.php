<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIREN | AGBC</title>
        <link rel="icon" type="image/png" href="vendor/adminlte/dist/img/AGBClogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0056B3, #F39C12);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: #333;
        }
        .login-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        .logo {
            width: 90px;
            margin-bottom: 1rem;
        }
        h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0056B3;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }
        h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #F39C12;
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            text-align: left;
            display: block;
        }
        .btn-primary {
            background-color: #0056B3;
            border: none;
            width: 100%;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #004091;
        }
        .footer {
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <!-- Logo -->
        <img src="{{ asset('images/AGBClogo.png') }}" alt="Logo EMS" class="logo">

        <!-- Títulos del sistema -->
        <h2>SISTEMA DE GESTIÓN DE PAQUETERÍA DE ENCOMIENDAS</h2>
        <h3>"SIREN"</h3>

        <!-- Estado de sesión -->
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Ingresar</button>
        </form>

        <div class="footer">
            © {{ date('Y') }} Agencia Boliviana de Correos
        </div>
    </div>
</body>
</html>
