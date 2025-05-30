# TODO List - Sistema de Ponto Eletrônico RCC Brasil

## Validações CRUD
- [ ] Implementar validações para operação de atualização (UPDATE)
- [ ] Implementar validações para operação de leitura (READ)
- [ ] Implementar validações para operação de exclusão (DELETE)

## Cálculo de Saldo de Horas
- [ ] Desenvolver função para calcular saldo quando ponto estiver completo
    - [ ] Definir regras de cálculo
    - [ ] Implementar lógica de horas trabalhadas
    - [ ] Considerar intervalos
    - [ ] Validar fechamento do ponto

## Segurança e Autenticação
- [ ] Implementar autenticação JWT
    - [ ] Criar middleware de validação de token
    - [ ] Configurar geração de tokens
    - [ ] Definir tempo de expiração
- [ ] Configurar rotas protegidas
- [ ] Implementar refresh token
- [ ] Criar endpoints de login/logout

## Testes
- [ ] Criar testes unitários para novas validações
- [ ] Testar fluxo de autenticação
- [ ] Validar cálculo de saldo de horas