# Exercício 1 — Timeout em APIs Externas

## Contexto

Este exercício simula um **problema real de produção**:
falhas ao consumir **APIs externas lentas ou indisponíveis**.

Em ambientes reais, a ausência de tratamento adequado de timeout pode causar:

* requisições travadas
* filas congestionadas
* efeito cascata de falhas
* indisponibilidade parcial ou total do sistema

O objetivo aqui é **trazer consciência de produção**, não apenas fazer o código “funcionar localmente”.

---

## Rota do exercício

Endpoint disponível para simulação:

```
http://localhost/api/delay
```

Essa rota responde **intencionalmente com atraso**, simulando:

* lentidão de rede
* timeout de serviço externo
* comportamento comum em integrações reais

---

## Objetivo do exercício

Compreender e corrigir um cenário onde:

* uma API externa é chamada **sem proteção**
* o sistema **não trata timeout**
* não existem **logs adequados**
* não há **estratégia de retry ou fallback**

O participante deve evoluir o código para um comportamento **seguro em produção**.

---

## Importante

Este laboratório foi construído com foco **didático**:

* nomes simplificados
* arquitetura propositalmente reduzida
* ausência de padrões avançados

Isso é **intencional**, para que o foco seja:

> identificar o problema
> entender o risco em produção
> aplicar uma solução robusta

Nada impede — e é incentivado — que quem resolver:

* proponha melhorias arquiteturais
* aplique boas práticas de observabilidade
* utilize padrões de resiliência

---

## Resultados esperados

Ao final do exercício, espera-se que o participante compreenda:

* por que timeout é crítico em produção
* como proteger chamadas externas
* a importância de logs úteis para investigação
* a responsabilidade do desenvolvedor sobre o comportamento em produção
