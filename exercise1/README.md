# Exercise 1 — Timeout in External APIs

## Context

This exercise simulates a **real production issue**:
failures when consuming **slow or unavailable external APIs**.

In real-world environments, the lack of proper timeout handling can cause:

* stuck requests
* overloaded queues
* cascading failures
* partial or total system downtime

The goal is to build **production awareness**, not just make the code “work locally”.

---

## Exercise Endpoint

Available route for simulation:

```
http://localhost/api/delay
```

This endpoint intentionally responds **with delay**, simulating:

* network latency
* external service timeout
* common behavior in real-world integrations

---

## Objective

Understand and fix a scenario where:

* an external API is called **without protection**
* the system **does not handle timeouts**
* there are **no proper logs**
* there is **no retry or fallback strategy**

The participant must evolve the code toward a **production-safe behavior**.

---

## Important

This lab was built with a **didactic focus**:

* simplified naming
* intentionally reduced architecture
* absence of advanced patterns

This is **intentional**, so the focus remains on:

> identifying the problem
> understanding production risk
> applying a robust solution

Nothing prevents — and it is encouraged — that participants:

* propose architectural improvements
* apply observability best practices
* implement resilience patterns

---

## Expected Outcomes

By the end of this exercise, the participant should understand:

* why timeouts are critical in production
* how to protect external calls
* the importance of meaningful logs for investigation
* the developer’s responsibility for production behavior

