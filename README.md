# ProductHUB API

Bem-vindo à **ProductHUB API**. Este projeto é uma API desenvolvida para gerenciar informações de produtos e categorias. Ela oferece endpoints para operações CRUD (Criar, Ler, Atualizar e Deletar) e autenticação de usuários. A API está configurada para rodar em um ambiente Dockerizado.

## Stack utilizada

**Back-end:** PHP, Laravel, MySQL

## Funcionalidades

- CRUD completo para gerenciamento de produtos e categorias.
- Autenticação e autorização de usuários com JWT.
- Endpoints seguros e protegidos por autenticação.
- Documentação da API utilizando Swagger.
- Configuração fácil via Docker e Docker Compose.

## Instalação

Para configurar e rodar a **ProductHUB API**, siga os passos abaixo:

### Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas em seu sistema:

- [PHP](https://www.php.net/) (versão 7.4 ou superior)
- [Composer](https://getcomposer.org/)
- [Docker](https://www.docker.com/get-started) e [Docker Compose](https://docs.docker.com/compose/install/)
- [MySQL](https://www.mysql.com/)

### Passo a Passo

1. **Clone o repositório**

   Clone o repositório da API para seu ambiente local:

   ```bash
   git clone https://github.com/adrianogui02/ProductHUB_backend.git

1. **Navegue até o diretório do projeto**

   Entre no diretório do projeto clonado:

   ```bash
   cd ProductHUB_backend
   ```

1. **Configuração do Ambiente**

   Crie um arquivo .env na raiz do projeto com o seguinte conteúdo:

   ```bash
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=laravel
    DB_PASSWORD=secret
   ```

1. **Usando Docker**

   Se preferir usar Docker, você pode seguir os passos abaixo para configurar e rodar a API usando Docker e Docker Compose:

   - Construa e Inicie os containers:

     ```bash
     docker-compose up -d --build
     ```

    

   - Execute as migrações do banco de dados:

     ```bash
     docker-compose exec backend php artisan migrate
     ```

     Verifique se não há erros na inicialização e que a API está conectada ao banco de dados.

     - Verifique os logs dos containers::

     ```bash
     docker-compose logs -f
     ```

    - Verifique se não há erros na inicialização e que a API está conectada ao banco de dados.

1. **Documentação Swagger**

   Para acessar a documentação Swagger, abra um navegador e vá até o endereço abaixo. Lá você encontrará uma interface interativa que permite explorar e testar os endpoints da API de maneira fácil e intuitiva.
   
   http://localhost:8000/api/documentation

## Autores

[@adrianogui02](https://github.com/adrianogui02)



