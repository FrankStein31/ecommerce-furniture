@echo off
REM ========================================
REM FastAPI Server Startup Script
REM ========================================

echo.
echo ================================================
echo   FastAPI - SPK Rekomendasi Perbaikan Mebel
echo ================================================
echo.

cd /d "%~dp0"

echo [1/3] Checking Python environment...
if not exist "venv\Scripts\python.exe" (
    echo ERROR: Virtual environment not found!
    echo Please run: python -m venv venv
    pause
    exit /b 1
)

echo [2/3] Starting FastAPI Server...
echo Server will run on: http://localhost:8000
echo API Documentation: http://localhost:8000/docs
echo.

echo [3/3] Press CTRL+C to stop the server
echo.

venv\Scripts\uvicorn.exe main:app --reload --host 0.0.0.0 --port 8000

pause
