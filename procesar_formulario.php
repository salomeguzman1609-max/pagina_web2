<?php
$errores = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $errores[] = 'El formulario solo acepta envíos POST.';
} else {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $edad = trim($_POST['edad'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $pago = trim($_POST['pago'] ?? '');
    $piel = trim($_POST['piel'] ?? '');
    $interes = trim($_POST['interes'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($nombre === '') {
        $errores[] = 'Escribe tu nombre.';
    }
    if ($apellido === '') {
        $errores[] = 'Escribe tu apellido.';
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'Escribe un correo electrónico válido.';
    }
    if (!filter_var($edad, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 120]])) {
        $errores[] = 'Escribe una edad válida.';
    }
    if ($telefono === '') {
        $errores[] = 'Escribe tu teléfono.';
    }
    if ($pago === '') {
        $errores[] = 'Selecciona un tipo de pago.';
    }
    if ($piel === '') {
        $errores[] = 'Selecciona tu tipo de piel.';
    }
    if ($interes === '') {
        $errores[] = 'Selecciona el producto que más te interesa.';
    }
    if ($direccion === '') {
        $errores[] = 'Escribe tu dirección de entrega.';
    }
}

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

$nombreSeguro = escapar($nombre ?? '');
$apellidoSeguro = escapar($apellido ?? '');
$correoSeguro = escapar($correo ?? '');
$edadSeguro = escapar($edad ?? '');
$telefonoSeguro = escapar($telefono ?? '');
$pagoSeguro = escapar($pago ?? '');
$pielSeguro = escapar($piel ?? '');
$interesSeguro = escapar($interes ?? '');
$direccionSeguro = escapar($direccion ?? '');
$mensajeSeguro = nl2br(escapar($mensaje ?? ''));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beauty Glow | Resultado del formulario</title>
    <style>
        :root { --rose: #d4af37; --gold: #d7a83c; --ink: #f7f1d0; }
        * { box-sizing: border-box; }
        body {
            display: grid;
            place-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            color: var(--ink);
            font-family: Georgia, 'Times New Roman', serif;
            background: linear-gradient(135deg, #050505, #11100d 55%, #2a210c);
        }
        .result {
            width: min(620px, 100%);
            padding: clamp(25px, 5vw, 48px);
            border-radius: 12px;
            border: 1px solid rgba(212, 175, 55, .45);
            background: #11100d;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .4);
        }
        h1 { margin-top: 0; color: var(--rose); font-size: clamp(2rem, 6vw, 3.4rem); }
        p, li { font-family: Arial, sans-serif; line-height: 1.6; }
        .summary { padding: 16px; background: #1a1915; border-left: 4px solid var(--gold); }
        .errors { color: #f2d67a; }
        a {
            display: inline-block;
            margin-top: 18px;
            padding: 13px 20px;
            border-radius: 6px;
            color: #2d2020;
            background: var(--gold);
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main class="result">
        <?php if ($errores): ?>
            <h1>Revisa tus respuestas</h1>
            <ul class="errors">
                <?php foreach ($errores as $error): ?>
                    <li><?= escapar($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <h1>¡Formulario recibido!</h1>
            <p>Gracias, <strong><?= $nombreSeguro . ' ' . $apellidoSeguro ?></strong>. Recibimos tus respuestas correctamente.</p>
            <div class="summary">
                <p><strong>Correo:</strong> <?= $correoSeguro ?></p>
                <p><strong>Edad:</strong> <?= $edadSeguro ?></p>
                <p><strong>Teléfono:</strong> <?= $telefonoSeguro ?></p>
                <p><strong>Tipo de pago:</strong> <?= $pagoSeguro ?></p>
                <p><strong>Tipo de piel:</strong> <?= $pielSeguro ?></p>
                <p><strong>Producto de interés:</strong> <?= $interesSeguro ?></p>
                <p><strong>Dirección:</strong> <?= $direccionSeguro ?></p>
                <?php if ($mensajeSeguro !== ''): ?>
                    <p><strong>Preferencias:</strong><br><?= $mensajeSeguro ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <a href="formulario.html#formulario">Volver al formulario</a>
        <a href="../index.html">Volver al inicio</a>
    </main>
</body>
</html>
