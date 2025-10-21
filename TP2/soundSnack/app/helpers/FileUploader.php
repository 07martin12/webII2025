<?php

class FileUploader
{
    private const BASE_URL = '/webII2025/TP2/soundSnack/';

    // Sube un archivo a la carpeta indicada, creando la carpeta si no existe.
    public static function handleCoverUpload(array $file, string $entityName, string $uploadDir): ?string
    {
        // Verifica que el archivo no sea null
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return null;
        }

        // Crear la carpeta si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Procesa el nombre del archivo para evitar caracteres especiales
        $safeName = preg_replace("/[^a-zA-Z0-9_\-]/", "_", strtolower($entityName));

        // Se obtiene la extensión del archivo y se valida que sea valido
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($extension, $allowedExtensions)) {
            return null;
        }

        $filename = $safeName . '.' . $extension;

        // Ruta destino
        $destination = rtrim($uploadDir, '/') . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Procesa la ruta para que posteriormente sea accesible desde el navegador
            return self::BASE_URL . ltrim(rtrim($uploadDir, '/') . '/' . $filename, '/');
        }
        return null;
    }
}
