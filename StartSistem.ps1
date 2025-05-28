# iniciar-servidor.ps1

# Caminho do PHP
$phpPath = "C:\xampp\php\php.exe"

# Caminho do diretório 'public'
$documentRoot = Join-Path $PSScriptRoot "public"

# Verifique se o servidor PHP já está em execução
$processos = Get-Process | Where-Object { $_.ProcessName -eq "php" }
if ($processos.Count -eq 0) {
    # Iniciar o servidor PHP ocultamente
    Start-Process $phpPath -ArgumentList "-S localhost:8080 -t `"$documentRoot`"" -WindowStyle Hidden
}