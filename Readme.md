Perfeito.
Vou te entregar algo **bem direto e pronto pra usar com a equipe**.

A ideia é você ter:

* **erro real de produção**
* **por que não aparece em dev**
* **mini código com bug**
* **o que o dev precisa corrigir**

Isso vira um **laboratório de falhas reais**.

---

# 1. Timeout de integração externa sem tratamento

## Erro real

API externa demora → request trava → fila acumula → sistema cai.

## Por que não aparece em dev

* mock rápido
* localhost rápido
* sem latência real

## Código com bug

```php
public function handle()
{
    $response = Http::get('https://api.pagamento.com/status/'.$this->paymentId);

    if ($response->successful()) {
        Payment::where('id', $this->paymentId)
            ->update(['status' => $response['status']]);
    }
}
```

## Problemas

* sem timeout
* sem retry
* sem log
* pode travar worker

## O que corrigir

* timeout
* retry
* log estruturado
* fallback

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

# 4. Falta de índice causando lentidão extrema

## Erro real

Query simples → 30s → derruba banco.

## Por que não aparece em dev

* poucos dados

## Código com bug

```php
Order::where('status', 'pending')
    ->whereDate('created_at', now())
    ->get();
```

## Problema

* sem índice composto

## Correção

* criar índice
* usar range ao invés de `whereDate`

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

# 6. Falta de log em erro crítico

## Erro real

Bug acontece → ninguém sabe por quê.

## Código com bug

```php
try {
    PaymentGateway::send($data);
} catch (\Exception $e) {
    return false;
}
```

## Problema

* erro engolido

## Correção

* log estruturado
* contexto
* rethrow quando necessário

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
