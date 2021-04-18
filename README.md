## Estrutura do Projeto

```
banco-cap-api
 └───
 └───app                        # App
      └───Console               # Contem arquivos de commands
      └───Excptions             # Contem os exceptions criados ao decorrer do projeto
      └───Http                  # Contem controllers, middlewares, requests e resources
           └───Controllers      # Responsável por fazer o controle de requisições
           └───Middleware       # Responsável por fazer o controle intermediario entre o client e o controller
           └───Requests         # Responsável por controlar e validar os dados recebidos em cada método do controller
           └───Resources        # Responsável por formatar os dados de retorno do método do controller
      └───Models                # Entidades
      └───Providers             # Serviços de controle e configuração
      └───Respositories         # Camada responsável por acesso com o banco de dados
      └───Services              # Camada responsável pela regra de negócio
 └───bootstrap                  # Contem arquivo de configuração de utilização de funcionalidades do projeto (middleware, eloquent e etc.)
 └───config                     # Contem arquivos de configuração do projeto (app, cache, cors, database e etc.)
 └───database                   # Contem as migrations, seeders e factories
 └───public                     # Public
 └───resources                  # Contem arquivos de "frontend" (css, js, views(blade) e etc)
 └───routes                     # Contem o arquivos que armazena os end-points
 └───storage                    # Storage
 └───tests                      # Contem os tests unitários e de integração do projeto.
       └───Feature              # Contem os testes de integração
       └───Unit                 # Contem os testes unitários.
 └───vendor                     # Vendor (contem bibliotecas necessárias para o projeto funcionar)
 └───.env.example               # Exemplo do arquivos de configuração de acesso a serviços
 └───.env.testing.example       # Exemplo do arquivos de configuração de acesso a serviços de teste
 └───.gitignore                 # Arquivo de configuração para evitar commitar arquivos desnecessários
 └───composer.json              # Arquivo de configuração do projeto, definindo quais libs devem ser instaladas
 └───LICENSE                    # Licensa do projeto (MIT)
 └───phpunit.xml                # Arquivo de configuração do phpunit.
 └───README.md                  # README.md.
 └───server.php                 # Server
 └───tests.sh                   # Arquivo com script para execução dos testes.
 └───webpack.mix.js             # Webpack
```
### Decisão da Estrutura Utilizada

A estrutura utilizada tem como base a estrutura base do Laravel 4.2.4, porém foi acrescentado a separação em services, repositories, resources e request. Além de interfaces para compor as camadas dos services e repositories. Isso porque não deixa a estrutura muito complexa e divide de forma para facil entendimento de cada camada.

### Stacks Utilizadas:

PHP 7.4.16

Laravel 4.2.4

### Instalação

Para preparar o código é necessário primeiramente criar os arquivos .ENVs para comunicação da aplicação com o banco de dados SQLITE e para testes. Para isso deverá ser executado esses dois comandos:

```bash
$ cp .env.example .env
```
 e
 
```bash
$ cp .env.testing.example .env.testing
```

Após esse comando deve executar o comando para instalação das dependencias do projeto.
```bash
$ composer install
```

### Testes
Os testes foram feitos utilizados o banco de dados sqlite como base para as pesistências dos dados. Deve-se executar esse comando na raiz do projeto:

```bash
$ sh tests.sh
```
Esse comando automatiza a execução dos comandos `php artisan migrate --env=testing`, `php artisan tests --env=testing`, `php artisan migrate:rollback --env=testing`. Correspontes a criar as tabelas, executar os testes e "deletar" as tabelas.

Após a execução, o seguite resultado deverá ser retornador:

```
Migrating: 2021_04_16_231514_conta
Migrated:  2021_04_16_231514_conta (14.71ms)
Migrating: 2021_04_17_024409_transacao
Migrated:  2021_04_17_024409_transacao (6.54ms)
Warning: TTY mode is not supported on Windows platform.

   PASS  Tests\Feature\ContaTest
  ✓ should return all contas
  ✓ should return conta
  ✓ not found conta return
  ✓ should create conta
  ✓ not should create conta with negative value
  ✓ should delete conta
  ✓ not should delete conta

   PASS  Tests\Feature\TransacaoTest
  ✓ should return all contas
  ✓ should return conta
  ✓ not found transaction return
  ✓ should create a transaction of credit
  ✓ should create a transaction of debit
  ✓ not should create a transaction
  ✓ should delete conta
  ✓ not should delete conta

  Tests:  15 passed
  Time:   0.90s

Rolling back: 2021_04_17_024409_transacao
Rolled back:  2021_04_17_024409_transacao (10.29ms)
Rolling back: 2021_04_16_231514_conta
Rolled back:  2021_04_16_231514_conta (7.99ms)
```

### Execução

Inicialmente é necessário ter todas as tabelas no banco de dados, para isso é necessário executar

```bash
$ php artisan migrate
```

Para inserir dados iniciais, é necessário executar o comando dos sedeers

```bash
$ php artisan db:seed
```

Para executar o projeto deve-se executar o seguinte comando:

```bash
$ php artisan serve
```

Esse comando fará com que o projeto comece a ser executado na porta 8000
