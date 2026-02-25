# 📘 Exercise 2 — Simulating Database Timeout in Production

## 🎯 Objective

This exercise demonstrates a real-world production issue:

> A poorly optimized backend request that performs multiple heavy database queries, eventually causing a **database timeout** under constrained resources.

The goal is to understand:

* Why database timeouts are hard to simulate
* How MySQL behaves under stress
* The impact of resource limits in production
* The difference between development and production environments

---

## 🧠 Context

Simulating a real database timeout is **not trivial** because:

* The default MySQL timeout is relatively high
* MySQL is highly optimized
* Modern machines are fast enough to handle heavy queries
* Query execution time is different from connection timeout

To reproduce a real failure scenario, the following changes were necessary:

* Reduce MySQL CPU and memory resources
* Configure `max_execution_time`
* Generate a large dataset in the production environment
* Separate environment initialization steps

Because of this, the setup process requires special attention.

---

# ⚙️ First-Time Environment Setup

⚠️ Important:
Before running everything together, we must temporarily disable the MySQL resource limits.

---

## 1️⃣ Comment the `deploy` section in docker-compose

Inside the `mysql` service, comment this section:

```yaml
deploy:
  resources:
    limits:
      cpus: '0.25'
      memory: 256M
```

This prevents the seed process from taking excessively long.

---

## 2️⃣ Start only the MySQL container

```bash
docker compose up mysql
```

Wait until the database is fully initialized.

---

## 3️⃣ Prepare Production Environment

Run:

```bash
docker compose run exercise-prod sh -c "set -e && php artisan migrate:fresh --force && php artisan db:seed --force --class=DBProductionSeeder && php-fpm -D && nginx -g 'daemon off;'"
```

---

## 4️⃣ Prepare Development Environment

Run:

```bash
docker compose run exercise sh -c "set -e && composer install && php artisan migrate:fresh && php artisan db:seed && php-fpm -D && nginx -g 'daemon off;'"
```

⚠️ Depending on your machine performance, the seed process may take a long time.

This is expected.

---

# 🚨 Activating the Timeout Scenario

After the environment is fully prepared:

1️⃣ Uncomment the `deploy` section in the MySQL service.

2️⃣ Restart everything:

```bash
docker compose down
```

```bash
docker compose up
```

Now the MySQL container will run with constrained CPU and memory.

---

# 🧪 Testing the Scenario

Test the endpoint:

```
/api/users
```

Expected behavior:

| Environment | Result                 |
| ----------- | ---------------------- |
| Development | Works normally         |
| Production  | Database timeout error |

This simulates a real production degradation scenario caused by:

* Heavy queries
* Insufficient optimization
* Resource constraints

---

# ⚠️ Important Notes

Simulating database stress is inherently unpredictable.

You may experience:

* Timeout errors (expected)
* Memory allocation errors
* Slow responses without timeout

If you do **not** get a timeout:

* Reduce CPU even further
* Reduce memory limits
* Lower `max_execution_time`
* Increase dataset size

The objective is to reproduce stress, not to achieve a single deterministic error.

---

# 🧩 What This Exercise Teaches

* MySQL timeout ≠ connection timeout
* Resource limits dramatically affect performance
* Poorly optimized queries may work in development but fail in production
* Reproducing production issues locally requires controlled degradation

---

# 🏁 Final Result

You now have:

* A working development environment
* A constrained production environment
* A reproducible database stress scenario
* A realistic timeout simulation