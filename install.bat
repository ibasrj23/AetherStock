@echo off
REM Product Management System - Setup Script (Windows)
REM Usage: install.bat

echo.
echo ============================================
echo  Product Management System - Setup Script
echo ============================================
echo.

REM Check if PHP is installed
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo X PHP is not found. Please install PHP 7.4 or higher.
    echo   Download from: https://www.php.net/downloads
    pause
    exit /b 1
)

for /f "tokens=2" %%i in ('php -v') do (
    set PHP_VERSION=%%i
    goto :break
)
:break

echo [OK] PHP %PHP_VERSION% found
echo.

REM Create directories if not exist
echo Creating directories...
if not exist assets\css mkdir assets\css
if not exist assets\js mkdir assets\js
if not exist includes mkdir includes

echo.
echo ============================================
echo  Project Structure Created
echo ============================================
echo [OK] includes/
echo [OK] assets/css/
echo [OK] assets/js/
echo.

REM Display next steps
echo.
echo ============================================
echo  NEXT STEPS
echo ============================================
echo.
echo 1. Open Command Prompt in this folder
echo.
echo 2. Start PHP server:
echo    php -S localhost:8000
echo.
echo 3. Open browser:
echo    http://localhost:8000/setup.php
echo.
echo 4. Click "Setup Database"
echo.
echo 5. Login with:
echo    Username: user1
echo    Password: password123
echo.
echo ============================================
echo.
echo Setup complete! Ready to use. Press any key...
pause >nul
