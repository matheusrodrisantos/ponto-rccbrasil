# Regras de Negócio: Inclusão de Férias

## Permissões para inclusão de férias

### Perfis autorizados:
- **GERENTE** e **RH** podem incluir férias para qualquer funcionário.
- **SUPERVISOR** pode incluir apenas para funcionários do mesmo departamento supervisionado.

### Restrições:
- O usuário que faz a inclusão precisa estar ativo.
- Funcionários comuns não podem incluir férias.
- O início das férias **não pode coincidir com domingos, feriados ou repouso semanal**
- Pode ser **fracionado** em até 3 períodos:
  - Um dos períodos **não pode ser inferior a 14 dias**
  - Os outros dois **não podem ser inferiores a 5 dias corridos**

 



## Referência de código
- Método: `Funcionario::podeIncluirFeriasDe(Funcionario $outro)`
- Serviço: `App\Service\RegrasFerias
