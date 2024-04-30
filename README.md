# JUKEBOX - TODOList

Projeto de lista de tarefas desenvolvido utilizando Laravel, Vue.js e Vuetify.

## Começando

Siga estas instruções para configurar e executar o projeto localmente:

1. Clone este repositório em sua máquina local.
2. Navegue até o diretório do projeto.

### Pré-requisitos

Certifique-se de ter os seguintes requisitos instalados em seu ambiente:

- Servidor PHP (como Apache)
- Composer
- Node.js e npm

### Instalação

Siga os passos abaixo para instalar e configurar o projeto:

Copie o arquivo de configuração de ambiente:
```bash
cp .env.example .env
```
No arquivo .env, certifique-se de ajustar as configurações de banco de dados, caso necessário. O nome padrão do banco de dados é todolist.

Instale as dependências do Composer:
```bash
composer install
```

Instale as dependências do npm:
```bash
npm install
```

Gere a chave de aplicação do Laravel:
```bash
php artisan key:generate
```

### Acesso

```bash
php artisan serve
```
```bash
npm run watch
```

Após a conclusão da instalação, você pode acessar o TODOList em: http://localhost:8000


## Agradecimentos

Agradeço por visitar meu projeto! Seja bem-vindo e espero que você encontre o TODOList útil e eficiente para suas necessidades de gerenciamento de tarefas. Obrigado por dedicar seu tempo para explorar este trabalho. 🚀