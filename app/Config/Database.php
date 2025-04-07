<?php

namespace App\Config;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
  private $host;
  private $db;
  private $user;
  private $pass;
  private $port;
  private static $pdo;

  public function __construct()
  {
    // Carregar variáveis de ambiente do arquivo .env
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();

    // Inicializar as propriedades com os valores do .env
    $this->host = $_ENV['DB_HOST'] ?? 'localhost';
    $this->db = $_ENV['DB_NAME'] ?? 'database';
    $this->user = $_ENV['DB_USER'] ?? 'root';
    $this->pass = $_ENV['DB_PASS'] ?? '';
    $this->port = $_ENV['DB_PORT'] ?? '3306';
  }

  public function connect()
  {
    if (!self::$pdo) {
      try {
        // Criar a conexão PDO usando as propriedades de instância
        self::$pdo = new PDO(
          "mysql:host={$this->host};port={$this->port};dbname={$this->db}",
          $this->user,
          $this->pass,
          [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          ]
        );
      } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
    }

    return self::$pdo;
  }
}