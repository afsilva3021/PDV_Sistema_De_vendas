# Defina o caminho do PHP, se necessário
$phpPath = "C:\xampp\php\php.exe"  # Altere para o caminho real do seu php.exe
$documentRoot = "C:\Users\alex.felix\Documents\electronjs\PDVSISTEM\public\"  # Altere para o caminho da sua pasta public

# Verifique se o servidor PHP já está em execução
$processos = Get-Process | Where-Object { $_.ProcessName -eq "php" }
if ($processos.Count -eq 0) {
    # Iniciar o servidor PHP
    Start-Process $phpPath -ArgumentList "-S localhost:8080 -t $documentRoot"
}