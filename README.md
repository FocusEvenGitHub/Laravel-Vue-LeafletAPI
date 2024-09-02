# Sistema Rodovias

## Descrição

O Sistema Rodovias é um projeto desenvolvido em Laravel e Vue para gerenciar informações sobre rodovias, incluindo trechos, quilometragem e dados geoespaciais. O objetivo é fornecer uma interface para visualizar e manipular dados rodoviários com um mapa integrado e interativo.

Esse sistema guarda as informações de pesquisas onde podem ser acessados através da listagem, podendo alterar, excluir ou criar um novo.

## Tecnologias Utilizadas

- **Laravel**: Framework PHP para desenvolvimento web.
- **MySQL**: Sistema de gerenciamento de banco de dados.
- **PHP**: Linguagem de programação para o back-end.

## Requisitos

- PHP >= 8.0
- Composer
- MySQL
- Node.js
- Git Bash

## Instalação

1. **Clone o repositório com o Git Bash terminal**


   ```bash
   git clone https://github.com/FocusEvenGitHub/Laravel-Vue-LeafletAPI.git
Navegue para o diretório do projeto

    cd sistema-rodovias

####  No php.ini
Procure pela linha que contém 
    
        ;extension=fileinfo
        ;extension=pdo_mysql
        ;extension=zip
        
Remova o ponto e vírgula (;) do início da linha para habilitar as extensões
### Instale as dependências do PHP

    composer install
Configure o ambiente

Copie o arquivo .env.example para .env e ajuste as configurações do banco de dados e outras variáveis conforme necessário.


    cp .env.example .env
Gere a chave da aplicação

    php artisan key:generate
Execute as migrações e a seed

    php artisan migrate
    php artisan migrate:fresh --seed


Compile os assets

    npm install
# Iniciando o servidor (localmente)
Execute o comando PHP e Vite em terminais separados e os mantenha aberto.

Primeiro o PHP

    php artisan serve
e o vite

    npm run dev
O aplicativo estará disponível em http://localhost:8000.

### Estrutura do Projeto
app/: Contém o código-fonte do aplicativo, incluindo controladores, modelos e serviços.

database/: Contém arquivos de migração e seeds.

resources/: Contém as views e os arquivos de front-end (CSS, JavaScript).

routes/: Define as rotas da aplicação.


## Teste de diversidade programativa
Trabalhei de uma forma na página inicial e de outra forma nas páginas secundárias (trechos).

Na inicial pode-se notar que fui diretamente direcionado para o vue.js e a partir daí, ele lidava com o front montando o site usando as bibliotecas do NPM.

Nas páginas de trechos eu trabalhei com tudo no blade.php e busquei as bibliotecas através do serviço CDN.

>Ambos os modos funcionam corretamente, tudo testado com Postman e com retorno do JSON direto para o usuário.