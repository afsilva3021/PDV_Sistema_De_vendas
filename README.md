# PDV - Sistema de Vendas

Um sistema de **Ponto de Venda (PDV)** desenvolvido em **PHP 8.4**, com arquitetura **MVC**, integrado ao **MariaDB** e utilizando o **Composer** para gerenciamento de dependências.

## 📦 Funcionalidades

- Cadastro, edição e exclusão de colaboradores
- Gerenciamento de vendas e produtos (em desenvolvimento)
- Estrutura organizada em MVC (Model-View-Controller)
- Conexão com banco de dados MariaDB
- Sistema leve e adaptável

## 🚀 Tecnologias Utilizadas

- PHP 8.4
- MariaDB
- Composer
- Twig (template engine)
- HTML5/CSS3
- JavaScript (básico, para interações)

## 📁 Estrutura do Projeto

#PDV_Sistema_De_vendas/
</br>
├── app/ # Código principal (MVC)
</br>
│ ├── Controllers/
</br>
│ ├── Models/
</br>
│ └── Views/
</br>
│
</br>
├── config/ # Configurações de banco de dados e rotas
</br>
├── public/ # Ponto de entrada do sistema (index.php)
</br>
├── vendor/ # Dependências instaladas via Composer
</br>
├── composer.json # Arquivo de dependências
</br>
├── .gitignore
</br>
└── README.md
</br>
## ⚙️ Instalação

1. Clone o repositório:
  bash
  git clone https://github.com/afsilva3021/PDV_Sistema_De_vendas.git

2. Instale as dependências com o Composer:
  cd PDV_Sistema_De_vendas
  composer install

3. Configure o banco de dados MariaDB:

  Crie um banco chamado pdv (ou outro nome de sua escolha).
  Edite o arquivo config/database.php com suas credenciais.

4. Inicie o servidor local:
  php -S localhost:8000 -t public

5. Acesse o sistema em:
  http://localhost:8000


🛡️ Segurança
Senhas devem ser armazenadas com hash (em desenvolvimento)

Dados validados no back-end

Evita exposição de arquivos sensíveis com .gitignore

📝 Licença
Este projeto está licenciado sob a MIT License.

