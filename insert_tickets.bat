@echo off
echo 🚀 Insertando datos de tickets en la base de datos...
echo.

REM Intentar con mysql desde Laragon
if exist "C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe" (
    echo ✅ Usando MySQL de Laragon...
    "C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe" -u root -p gestion < insert_tickets.sql
    goto :success
)

REM Intentar con mysql desde PATH
where mysql >nul 2>nul
if %errorlevel%==0 (
    echo ✅ Usando MySQL desde PATH...
    mysql -u root -p gestion < insert_tickets.sql
    goto :success
)

REM Si no se encuentra mysql, mostrar instrucciones
echo ❌ No se encontró MySQL en el sistema.
echo.
echo 📋 Para ejecutar manualmente:
echo 1. Abre phpMyAdmin o tu cliente MySQL favorito
echo 2. Selecciona la base de datos 'gestion'
echo 3. Ejecuta el contenido del archivo insert_tickets.sql
echo.
echo 📁 Archivo SQL: insert_tickets.sql
echo.
pause
exit /b 1

:success
echo.
echo ✅ ¡Datos insertados exitosamente!
echo 📊 Puedes ver los tickets en: /tickets
echo.
pause
