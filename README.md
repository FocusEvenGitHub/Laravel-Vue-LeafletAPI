# Sistema Rodovias

## Descrição

O Sistema Rodovias é um projeto desenvolvido em Laravel para gerenciar informações sobre rodovias, incluindo trechos, quilometragem e dados geoespaciais. O objetivo é fornecer uma interface para visualizar e manipular dados rodoviários.

## Tecnologias Utilizadas

- **Laravel**: Framework PHP para desenvolvimento web.
- **MySQL**: Sistema de gerenciamento de banco de dados.
- **PHP**: Linguagem de programação para o back-end.

## Requisitos

- PHP >= 8.0
- Composer
- MySQL
- Node.js (opcional, para gerenciamento de front-end)

## Instalação

1. **Clone o repositório**

   ```bash
   git clone https://github.com/seu-usuario/sistema-rodovias.git
Navegue para o diretório do projeto

    cd sistema-rodovias
Instale as dependências do PHP

### No php.ini
Procure pela linha que contém 
    
        ;extension=fileinfo
        ;extension=pdo_mysql
        ;extension=zip
        
Remova o ponto e vírgula (;) do início da linha para habilitar as extensões

    composer install
Configure o ambiente

Copie o arquivo .env.example para .env e ajuste as configurações do banco de dados e outras variáveis conforme necessário.


    cp .env.example .env
Gere a chave da aplicação

    php artisan key:generate
Execute as migrações e a seed

    php artisan migrate
    php artisan db:seed
    php artisan db:seed --class=UfSeeder
    php artisan db:seed --class=RodoviaSeeder

Compile os assets

    npm install
    npm run dev
Inicie o servidor

    php artisan serve
O aplicativo estará disponível em http://localhost:8000.

### Estrutura do Projeto
app/: Contém o código-fonte do aplicativo, incluindo controladores, modelos e serviços.
database/: Contém arquivos de migração e seeds.
resources/: Contém as views e os arquivos de front-end (CSS, JavaScript).
routes/: Define as rotas da aplicação.
tests/: Contém os testes automatizados do projeto.
Contribuição
Faça um fork do repositório.
Crie uma branch para sua feature (git checkout -b feature/nome-da-feature).
Faça as alterações necessárias e commit (git commit -am 'Adiciona nova feature').
Envie para o repositório (git push origin feature/nome-da-feature).
Abra um pull request.