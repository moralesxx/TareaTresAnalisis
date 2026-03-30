<?php
include 'config.php';
session_start();

// Mecanismo de identificación (Requerimiento de la tarea)
if(!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; 
    $_SESSION['username'] = "Isaiah";
}

// Lógica para cifrar y guardar
if (isset($_POST['cifrar'])) {
    $texto = $_POST['texto_original'];
    // Genera un token único de 6 caracteres (ej: 4F2A1B)
    $token = strtoupper(bin2hex(random_bytes(3))); 
    $cifrado = Encryptor::encrypt($texto);
    $user_id = $_SESSION['user_id'];

    // Uso de Prepare para seguridad contra Inyección SQL
    $stmt = $conn->prepare("INSERT INTO registros (usuario_id, texto_original, texto_cifrado, token) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $texto, $cifrado, $token);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cifrado - Tarea 3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo $_SESSION['username']; ?></h1>
        
        <section class="card">
            <h2>Cifrar Nuevo Texto</h2>
            <form method="POST">
                <textarea name="texto_original" required placeholder="Ingresa el texto que deseas proteger..."></textarea>
                <button type="submit" name="cifrar">Generar Token y Cifrar</button>
            </form>
        </section>

        <section class="card">
            <h2>Tu Historial de Cifrado (Privado)</h2>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Token</th>
                            <th>Quién lo ingresó</th>
                            <th>Texto Original</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $uid = $_SESSION['user_id'];
                        $res = $conn->query("SELECT * FROM registros WHERE usuario_id = '$uid' ORDER BY fecha_hora DESC");
                        
                        if ($res->num_rows > 0) {
                            while($row = $res->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['fecha_hora']; ?></td>
                                <td><span class="token-badge"><?php echo $row['token']; ?></span></td>
                                <td><?php echo $_SESSION['username']; ?></td>
                                <td><?php echo htmlspecialchars($row['texto_original']); ?></td>
                                <td>
                                    <button class="btn-view" onclick="alert('Token: <?php echo $row['token']; ?>\nTexto Cifrado en BD: <?php echo $row['texto_cifrado']; ?>')">
                                        Ver RAW
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; 
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center;'>No hay registros aún.</td></tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>