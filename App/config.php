<?php
// Conexión a la BD
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sistema_cifrado";
$conn = new mysqli($host, $user, $pass, $db);

// Configuración de Cifrado (AES-256)
define('METHOD', 'aes-256-cbc');
define('SECRET_KEY', 'tu_clave_super_secreta_123');
define('SECRET_IV', '101214');

class Encryptor {
    public static function encrypt($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        return openssl_encrypt($string, METHOD, $key, 0, $iv);
    }

    public static function decrypt($string) {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        return openssl_decrypt($string, METHOD, $key, 0, $iv);
    }
}
?>