# Projeto Laravel com Docker

Este projeto é uma aplicação Laravel configurada para rodar em um ambiente Docker. Siga as instruções abaixo para configurar o ambiente de desenvolvimento e executar o projeto.

## Pré-requisitos

- Docker: [Instruções de instalação do Docker](https://docs.docker.com/engine/install/)
- Docker Compose: [Instruções de instalação do Docker Compose](https://docs.docker.com/compose/install/)
- Conta de e-mail (recomendado Gmail) para envio de e-mails.

## Configurando o ambiente de desenvolvimento

1. **Copiar e editar o arquivo `.env`:**

   Copie o arquivo `.env.example` para `.env` e edite conforme necessário:
   ```bash
   cp .env.example .env
   ```
2. **Configurar as credenciais de e-mail no arquivo `.env`:**

    Adicione suas credenciais de e-mail no arquivo `.env` para permitir o envio de e-mails pela aplicação. Aqui está um exemplo usando o Gmail:
    ```bash
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=seu-email@gmail.com
    MAIL_PASSWORD=sua-senha-ou-senha-de-aplicativo
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=seu-email@gmail.com
    MAIL_FROM_NAME="${APP_NAME}"
   ```
   >**Importante: Se você estiver usando o Gmail, é necessário ativar a autenticação de dois fatores e criar uma senha de aplicativo**

3. **Construir a imagem Docker e subir os containers:**

    Este comando irá criar a imagem Docker e iniciar os containers em segundo plano:
    ```bash
   docker-compose up -d --build
   ```

4. **Instalar as dependências do Laravel:**

    Use o seguinte comando para instalar as dependências do Laravel:
    ```bash
   docker-compose exec laravel composer install
   ```

5. **Gerar a chave da aplicação:**

    Gere a chave da aplicação necessária para a segurança do Laravel:
    ```bash
    docker-compose exec laravel php artisan key:generate
    ```

6. **Rodar as migrations:**

    Crie as tabelas no banco de dados usando as migrations:
    ```bash
    docker-compose exec laravel php artisan migrate
    ```

7. **Rodar as seeders**

    Preencha o banco de dados com dados iniciais (produtos, por exemplo):
    ```bash
    docker-compose exec laravel php artisan db:seed
    ```

8. **Rodar os testes**

    Execute os testes automatizados para garantir que tudo está funcionando:
    ```bash
    docker-compose exec laravel php artisan test
    ```

9. **Iniciar a fila de trabalhos:**

    Se sua aplicação utiliza filas (por exemplo, para envio de e-mails), execute o seguinte comando para processar as filas:
    ```bash
    docker-compose exec laravel php artisan queue:work
    ```

    >Esse comando é necessário para que os e-mails sejam enviados automaticamente após a criação de um pedido.

## Executando a aplicação
Após seguir os passos acima, a aplicação estará disponível no endereço `http://localhost` (ou na porta configurada no seu arquivo `.env`). Acesse este endereço no seu navegador para verificar se a aplicação está funcionando.

## Solução de Problemas
- Caso encontre algum erro de permissão ao rodar os containers, certifique-se de que sua pasta `storage` e `bootstrap/cache` têm permissão de escrita:

    ```bash
    docker-compose exec laravel chmod -R 777 storage bootstrap/cache
    ```
- Se ocorrerem problemas de conexão com o banco de dados, verifique as configurações do `.env` e reinicie os containers:

    ```bash
    docker-compose down
    docker-compose up -d
    ```

## Considerações Finais
Este README cobre os passos básicos para iniciar e configurar o ambiente de desenvolvimento do seu projeto Laravel usando Docker, incluindo a configuração de envio de e-mails. Sinta-se à vontade para ajustar as instruções conforme as necessidades específicas do seu projeto.

