#!/bin/bash

echo "Criando os containers..."
docker-compose up -d

echo "Instalando as dependências..."
docker exec -it ceos composer install

echo "Gerando a chave da aplicação..."
docker exec -it ceos php artisan key:generate

echo "Executando as migrações..."
docker exec -it ceos php artisan migrate

echo "Semeando o banco de dados..."
docker exec -it ceos php artisan db:seed

echo "Container:"
docker ps
