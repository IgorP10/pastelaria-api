## Configurando ambiente de desenvolvimento
```bash
# Install docker & docker-compose
https://docs.docker.com/engine/install/
https://docs.docker.com/compose/install/

# Copie e edite(opcional) o arquivo .env
cp .env.example .env

# Construir a imagem do Docker e subir os containers
docker-compose up -d --build

# Instalar as dependências do Laravel
docker-compose exec laravel composer install

# Gerar a chave da aplicação
docker-compose exec laravel php artisan key:generate

# Rodar as migrations
docker-compose exec laravel php artisan migrate
```

## Extra

```bash
# Criar uma migration
docker-compose exec laravel php artisan make:migration create_nome_da_tabela

# Rodar método DOWN da última migration que foi aplicada
docker-compose exec laravel php artisan migrate:rollback

# Este comando reverterá as últimas 3 migrations aplicadas
docker-compose exec laravel php artisan migrate:rollback --step=3

# Reverter todas as migrations
docker-compose exec laravel php artisan migrate:reset
```