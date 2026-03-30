<?php
/**
 * Configuración de conexión y lógica de cifrado
 * Proyecto: Tarea 3 - Análisis de Sistemas
 */

// Cuando usas Docker, el host es el nombre del servicio en el docker-compose
$host = "db"; 
$user = "root";
$pass = ""; // En el docker-compose dejamos el password vacío
$db   = "cifrado_DB";

// Intentar conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verificar si hay errores de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/**
 * Configuración de Cifrado (AES-256-CBC)
 * Se utilizan constantes para definir el método y las llaves
 */
define('METHOD', 'aes-256-cbc');
define('SECRET_KEY', 'tu_clave_super_secreta_123');
define('SECRET_IV', '101214');

class Encryptor {
    /**
     * Cifra un texto plano utilizando AES-256
     */
    public static function encrypt($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        return $output;
    }

    /**
     * Descifra un texto cifrado utilizando la misma llave y IV
     */
    public static function decrypt($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt($string, METHOD, $key, 0, $iv);
        return $output;
    }
}
?>