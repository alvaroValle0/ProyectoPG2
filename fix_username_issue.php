<?php
/**
 * Script para resolver el problema de la columna username
 * Ejecuta este archivo directamente en tu navegador o desde la línea de comandos
 */

// Configuración de la base de datos (ajusta según tu configuración)
$host = 'localhost';
$dbname = 'gestion'; // Cambia por el nombre de tu base de datos
$username = 'root'; // Cambia por tu usuario de MySQL
$password = ''; // Cambia por tu contraseña de MySQL

try {
    // Conectar a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔧 Solucionando problema de columna username</h2>\n";
    
    // Paso 1: Verificar si la columna username existe
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'username'");
    $columnExists = $stmt->rowCount() > 0;
    
    if (!$columnExists) {
        echo "<p>📝 Paso 1: Agregando columna username...</p>\n";
        
        // Agregar la columna username
        $pdo->exec("ALTER TABLE users ADD COLUMN username VARCHAR(255) UNIQUE AFTER name");
        echo "<p>✅ Columna username agregada exitosamente.</p>\n";
    } else {
        echo "<p>✅ La columna username ya existe.</p>\n";
    }
    
    // Paso 2: Asignar usernames a usuarios existentes
    echo "<p>📝 Paso 2: Asignando usernames a usuarios existentes...</p>\n";
    
    // Obtener usuarios sin username
    $stmt = $pdo->query("SELECT id, name, email FROM users WHERE username IS NULL OR username = ''");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        foreach ($users as $user) {
            // Generar username basado en el nombre
            $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $user['name']));
            $username = $baseUsername;
            $counter = 1;
            
            // Verificar que el username sea único
            while (true) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
                $stmt->execute([$username, $user['id']]);
                if ($stmt->fetchColumn() == 0) {
                    break;
                }
                $username = $baseUsername . $counter;
                $counter++;
            }
            
            // Actualizar el usuario
            $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
            $stmt->execute([$username, $user['id']]);
            
            echo "<p>✅ Usuario '{$user['name']}' actualizado con username: <strong>$username</strong></p>\n";
        }
    } else {
        echo "<p>✅ Todos los usuarios ya tienen username asignado.</p>\n";
    }
    
    // Paso 3: Verificar el resultado
    echo "<p>📝 Paso 3: Verificando resultado...</p>\n";
    $stmt = $pdo->query("SELECT id, name, username, email FROM users ORDER BY id");
    $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; margin-top: 20px;'>\n";
    echo "<tr><th>ID</th><th>Nombre</th><th>Username</th><th>Email</th></tr>\n";
    
    foreach ($allUsers as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td><strong>{$user['username']}</strong></td>";
        echo "<td>{$user['email']}</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
    
    echo "<h3>🎉 ¡Problema resuelto!</h3>\n";
    echo "<p>Ahora puedes usar el sistema con username en lugar de email para el login.</p>\n";
    
} catch (PDOException $e) {
    echo "<h3>❌ Error:</h3>\n";
    echo "<p>" . $e->getMessage() . "</p>\n";
    echo "<p><strong>Verifica tu configuración de base de datos en el script.</strong></p>\n";
}
?>
