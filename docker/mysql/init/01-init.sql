-- Script de inicialización de MySQL para la aplicación
-- Crear usuario con permisos específicos si no existe

CREATE USER IF NOT EXISTS 'laravel_user'@'%' IDENTIFIED BY 'laravel_password';
GRANT ALL PRIVILEGES ON prueba_parcial.* TO 'laravel_user'@'%';

-- Configuraciones adicionales para optimizar MySQL
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

-- Crear índices adicionales para optimización (se ejecutarán después de las migraciones)
FLUSH PRIVILEGES;