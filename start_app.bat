@echo off
cd /d "%~dp0"
echo =======================================================
echo Attempting final fix for "Access Forbidden" error...
echo We are now binding to 0.0.0.0 (All Interfaces)
echo =======================================================
echo.
echo Please try accessing: http://localhost:8000
echo.
echo If this *still* fails, you MUST manually allow 
echo C:\xampp\php\php.exe through your Windows Firewall.
echo.

C:\xampp\php\php.exe artisan serve --host=0.0.0.0 --port=8000
pause
