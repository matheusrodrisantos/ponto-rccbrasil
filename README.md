# Ponto-git

Sistema de gerenciamento de ponto eletrônico de código aberto

## Descrição

Este projeto é uma API REST open-source para controle de ponto eletrônico, desenvolvida com foco em boas práticas de programação e arquitetura. É um sistema real, robusto e escalável, que pode ser utilizado, estudado e adaptado livremente por empresas e desenvolvedores.

## Funcionalidades

- Registro de entrada e saída via API
- Controle de jornada de trabalho
- Relatórios de ponto em múltiplos formatos
- Gestão de colaboradores
- Dashboard administrativo
- Autenticação e autorização
- API documentada com OpenAPI/Swagger

## Tecnologias

- PHP 8.4
- Symfony Framework
- PHPUnit para testes
- MySQL/PostgreSQL
- Doctrine ORM
- JWT para autenticação
- Composer

## Instalação

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/ponto-rccbrasil.git

# Entre no diretório
cd ponto-rccbrasil

# Instale as dependências
composer install

# Configure as variáveis de ambiente
cp .env.example .env
# Configure seu banco de dados no .env

# Execute as migrações
php bin/console doctrine:migrations:migrate

# Inicie o servidor de desenvolvimento
symfony server:start
```

## Testes

```bash
# Execute os testes unitários
php bin/phpunit
```

## Licença

MIT

## Contribuição

Para contribuir com o projeto, por favor:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

