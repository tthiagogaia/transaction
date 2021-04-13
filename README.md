# TRANSACTION REST API
Este repositório contem o código base para o projeto **TRANSACTION REST API**.

## Stack

Este projeto é baseado nas seguintes tecnologias:

**Laravel 8** + **PHP 8.0** + **PHP-FPM** + **PostgreSQL** + **NGINX**

com todo o ambiente em execução em containers **Docker**.

## Começando

A infraestrutura implementada usa **Docker** e **Docker Compose**.

Tenha certeza de possuir o [Docker](https://www.docker.com/) e o [Docker Compose](https://docs.docker.com/compose/install/) instalados.

Verifique-os com os seguintes comandos:
```bash
docker -v
```
```bash
docker-compose -v
```

## Ambiente de desenvolvimento

Clone o repositório remoto para o ambiente de desenvolvimento, com o seguinte comando:
```bash
git clone https://github.com/tthiagogaia/transaction.git
```

E para configurar o ambiente de desenvolvimento, siga as próximas etapas do guia abaixo.

### 1 Iniciando o ambiente

**1.1** Na raiz do projeto **transaction**, que foi recentemente clonado, crie o arquivo **.env** usando:
```bash
cp .env.example .env
```

**1.2** Ainda na raiz do projeto **transaction** execute:
```bash
docker-compose up -d --build
```

e aguarde. Quando este comando terminar, todos os serviços deverão estar em execução em containers.

### 2 Configuração do projeto

**2.1** Acesse o postgres, que já deve estar rodando dentro do seu Docker, e crie as seguintes databases:
```bash
transaction
```
```bash
transaction_test
```

**OBS:** Se você não alterou nada nos passos anteriores, as credenciais do banco são:
```bash
Host: localhost
User: postgres
Password: postgres
```

**2.2** Instale os pacotes de dependência do projeto:
```bash
docker-compose run --rm composer install
```

**2.3** Gere a **APP_KEY** usando o seguinte comando:
```bash
docker-compose run --rm artisan key:generate
```

**2.4** Crie as tabelas e os seeders do projeto:

```bash
docker-compose run --rm artisan migrate --seed
```

## Code Quality

Antes de cada push, faça verificações no código rodando o seguinte comando:

```bash
docker-compose run --rm composer check
```

Este comando irá executar:

#### PHP Coding Standards Fixer

Verifica se o código está obedecendo ao estilo do código e irá corrigi-lo se não estiver.

#### PHPMD

Procura vários potenciais problemas no código.

#### PHP CodeSniffer

Procura violações contra o padrão de codificação definido.

#### PHPUnit

Executa o conjunto de testes.

## Tests
O comando a cima, executa os testes em conjunto com outros comandos. Mas caso seja
necessário executar os testes testes, execute o seguinte comando:

```bash
docker-compose run --rm artisa test
```
