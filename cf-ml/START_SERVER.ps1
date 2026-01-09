# ========================================
# FastAPI Server Startup Script (PowerShell)
# ========================================

Write-Host ""
Write-Host "================================================" -ForegroundColor Cyan
Write-Host "  FastAPI - SPK Rekomendasi Perbaikan Mebel" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

# Set location to script directory
Set-Location -Path $PSScriptRoot

# Check if virtual environment exists
Write-Host "[1/3] Checking Python environment..." -ForegroundColor Yellow
if (-not (Test-Path "venv\Scripts\python.exe")) {
    Write-Host "ERROR: Virtual environment not found!" -ForegroundColor Red
    Write-Host "Please run: python -m venv venv" -ForegroundColor Red
    pause
    exit 1
}

Write-Host "[2/3] Starting FastAPI Server..." -ForegroundColor Yellow
Write-Host "Server will run on: " -NoNewline
Write-Host "http://localhost:8000" -ForegroundColor Green
Write-Host "API Documentation: " -NoNewline
Write-Host "http://localhost:8000/docs" -ForegroundColor Green
Write-Host ""

Write-Host "[3/3] Press CTRL+C to stop the server" -ForegroundColor Yellow
Write-Host ""

# Set PYTHONPATH
$env:PYTHONPATH = $PSScriptRoot

# Start server
& "$PSScriptRoot\venv\Scripts\uvicorn.exe" main:app --reload --host 0.0.0.0 --port 8000
