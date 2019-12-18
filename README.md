# CI_API
Api para uma Casa Inteligente  

# Como rodar o projeto

Primeiramente baixe o projeto

    git clone https://github.com/GuileSuica/CI_API
  
Entre na pasta

    cd CI_API/casa_inteligente

Baixe o composer

    composer install
    
Atualize o composer

    composer update
    
Faça uma cópia do arquivo .env.example

    cp .env.example .env
    
Modifique as seguintes informações do arquivo .env. Coloque o nome do seu database, username e senha

    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

Dê o comando à seguir para criar as tabelas e populá-las.

    php artisan migrate:fresh    
Gere a chave

    php artisan key:generate
    
Rode o servidor

    php artisan serve
    
Para os testes 

    composer require --dev laravel/dusk

# Como testar a API

Baixe o postman para manipular a API

    https://www.getpostman.com/
    
Para testar os sensores utilize o caminho http://127.0.0.1:8000/api/sensor/


# Menu dos sensores

## Cadastrar um sensor
Método : **POST**  |  Url : **/api/sensor**  |  Parâmetros : **nome, tipo**

## Listar sensores
Método : **GET**  |  Url : **/api/sensor**

## Visualizar um sensor específico
Método : **GET**  |  Url : **/api/sensor/{id}**

## Atualizar sensor
Método : **PUT**  |  Url : **/api/sensor/{id}**  |  Parâmetros : **nome e/ou tipo**

## Deletar sensor
Método : **DELETE**  |  Url : **/api/sensor/{id}**


# Menu das medições

## Cadastrar uma medição
Método : **POST**  |  Url : **/api/medicao**  |  Parâmetros : **sensor_id, valor, data_horario**

## Listar medições
Método : **GET**  |  Url : **/api/medicao**

## Visualizar uma medição específica
Método : **GET**  |  Url : **/api/medicao/{id}**

## Atualizar medição
Método : **PUT**  |  Url : **/api/medicao/{id}**  |  Parâmetros : **sensor_id e/ou valor e/ou data_horario**

## Deletar medição
Método : **DELETE**  |  Url : **/api/medicao/{id}**
