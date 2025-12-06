<div align="center">
  <img src="public/assets/images/ponto-git.png" alt="Ponto-Git Logo" width="160"/>
  
  # **Ponto-Git**
  Sistema de gerenciamento de ponto eletrônico **open-source**, moderno e escalável.
</div>

---

## 📘 Descrição

**Ponto-Git** é uma API REST open-source para controle de ponto eletrônico, desenvolvida com foco em **boas práticas de programação**, **arquitetura limpa** e **testabilidade**.  
O sistema é robusto, extensível e pode ser utilizado ou adaptado por empresas, equipes de TI e desenvolvedores que desejam uma solução real e de qualidade para registro e gestão de jornada de trabalho.

## 🚀 Funcionalidades

- Registro de entrada e saída via API  
- Cálculo automatizado da jornada de trabalho  
- Relatórios de ponto em múltiplos formatos  
- Gestão completa de colaboradores  
- Dashboard administrativo (frontend opcional)  
- Autenticação e autorização via JWT  
- API documentada com OpenAPI/Swagger  
- Arquitetura modular e preparada para escalar  

## 🧪 Tecnologias Utilizadas

- **PHP 8.4**  
- **Symfony Framework**  
- **MySQL / PostgreSQL**  
- **Doctrine ORM**  
- **JWT Authentication**  
- **PHPUnit** para testes  
- **Composer** para gerenciamento de dependências  

## 📦 Instalação

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/ponto-git.git

# Entre no diretório
cd ponto-git

# Instale as dependências
composer install

# Configure as variáveis de ambiente
cp .env.example .env
# Ajuste seu banco de dados no .env

# Execute as migrações
php bin/console doctrine:migrations:migrate

# Inicie o servidor de desenvolvimento
symfony server:start

```

## Contribuição

Para contribuir com o projeto, por favor:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request
