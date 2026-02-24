# Laboratório de Falhas de Produção

## Sobre o projeto

Este repositório foi criado com o objetivo de **simular problemas reais de produção** por meio de exercícios práticos.

A proposta é sair do cenário comum de desenvolvimento — onde tudo funciona localmente — e expor situações que frequentemente ocorrem em ambiente produtivo, como:

* timeouts de integrações externas
* concorrência e duplicidade de processamento
* ausência de logs e observabilidade
* falhas de consistência de dados
* problemas de performance em escala

Cada exercício foi pensado para desenvolver:

* senso de responsabilidade sobre o código entregue
* visão de comportamento em produção
* capacidade de investigação de incidentes
* aplicação de boas práticas de resiliência

---

## Estrutura do repositório

O repositório está organizado em **pastas de exercícios independentes**:

```
/exercise1
/exercise2
/exercise3
...
```

Dentro de cada pasta você encontrará:

* um **README específico** explicando o cenário do problema
* um **código em modo de desenvolvimento**, que aparentemente funciona sem erros
* uma configuração de **Docker Compose** para simular o comportamento de produção

---

## Simulação de produção com Docker

Para tornar os cenários mais realistas:

* cada exercício pode utilizar uma **imagem de produção já preparada**
* essa imagem é distribuída via **Docker Hub**
* o `docker compose` do exercício faz o **pull direto dessa imagem**
* o ambiente resultante reproduz o **erro real de produção desejado**

Enquanto isso:

* o código presente na pasta representa o **estado de desenvolvimento**
* quando executado isoladamente, ele **não apresenta falhas aparentes**

Isso cria intencionalmente a diferença entre:

> **“funciona localmente”**
> vs
> **“falha em produção”**

---

## Objetivo dos exercícios

Cada exercício desafia o participante a:

1. **Reproduzir o problema de produção**
2. **Investigar a causa raiz**
3. **Corrigir o código de forma segura**
4. **Aplicar boas práticas de engenharia**
5. **Garantir que o erro não volte a ocorrer**

O foco não é apenas corrigir o bug, mas desenvolver:

* pensamento crítico
* maturidade operacional
* responsabilidade sobre impacto em produção

---

## Público-alvo

Este laboratório é voltado para:

* desenvolvedores backend
* equipes que trabalham com sistemas distribuídos
* times que desejam evoluir cultura de engenharia e qualidade

Especialmente útil para:

* treinamentos internos
* onboarding técnico
* workshops de confiabilidade
* preparação para incidentes reais

---

## Observação importante

Os códigos e arquiteturas presentes nos exercícios são **intencionalmente simplificados** para fins didáticos.

O objetivo principal é:

* evidenciar o problema
* permitir investigação clara
* facilitar a aplicação de soluções robustas

Melhorias arquiteturais e sugestões de boas práticas são **bem-vindas e incentivadas**.

---


# 2. Dupla execução de Job (falta de idempotência)

## Erro real

Fila reprocessa → cobra cliente 2x.

## Por que não aparece em dev

* job roda uma vez só
* sem concorrência

## Código com bug

```php
public function handle()
{
    $order = Order::find($this->orderId);

    ChargeService::charge($order);

    $order->update(['status' => 'paid']);
}
```

## Problemas

* pode rodar 2x
* sem verificação de status
* sem lock

## Correção esperada

* idempotência
* transaction
* unique constraint
* check de status

---

# 3. Condição de corrida ao atualizar saldo

## Erro real

Saldo negativo ou duplicado.

## Por que não aparece em dev

* sem concorrência
* poucos requests

## Código com bug

```php
DB::transaction(function () {
    $wallet = Wallet::find($this->walletId);

    $wallet->balance -= $this->amount;
    $wallet->save();
});
```

## Problema

* dois processos leem mesmo saldo

## Correção

* `lockForUpdate()`
* ou operação atômica

---

# 5. Uso errado de timezone

## Erro real

Cobrança antes/depois do horário correto.

## Por que não aparece em dev

* mesma timezone local

## Código com bug

```php
if ($order->expires_at < now()) {
    $order->cancel();
}
```

## Problema

* banco em UTC
* app em localtime

## Correção

* padronizar UTC
* casts corretos

---


# 7. N+1 escondido

## Erro real

Página lenta em produção.

## Por que não aparece em dev

* poucos registros

## Código com bug

```php
$orders = Order::all();

foreach ($orders as $order) {
    echo $order->customer->name;
}
```

## Correção

* `with('customer')`

---

# 8. Validação inexistente em entrada externa

## Erro real

Dados inválidos quebram processamento assíncrono.

## Código com bug

```php
public function store(Request $request)
{
    User::create($request->all());
}
```

## Correção

* FormRequest
* DTO
* regras claras

---

# 9. Memory leak em Job grande

## Erro real

Worker morre após horas.

## Código com bug

```php
$users = User::all();

foreach ($users as $user) {
    $this->process($user);
}
```

## Correção

* `chunk()`
* `cursor()`

---

# 10. Falta de transaction em fluxo crítico

## Erro real

Metade dos dados salvos.

## Código com bug

```php
$order = Order::create([...]);
Payment::create([...]);
Invoice::create([...]);
```

## Correção

* `DB::transaction`

---

# Como usar isso com a equipe

### Formato de exercício

Você entrega:

* código bugado
* cenário de produção
* logs incompletos

Eles precisam:

1. descobrir o problema
2. corrigir
3. explicar causa raiz
4. provar com teste

---

Se quiser, eu posso no próximo passo montar:

* **um laboratório completo em Laravel**
* **com 10 exercícios prontos**
* **com testes quebrando**
* **roteiro de aula pra você aplicar na equipe**

Só me dizer que eu já te entrego o pacote pronto.

-- REDIS

-- RabbitMQ