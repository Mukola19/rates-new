## Rates

This site is intended for viewing the exchange rates of Ukrainian banks.

## Instructions for deployment

#

Installing all dependencies

```console
 run_after_clone.sh
```

Lifting containers

```console
 sail up -d
```

Application of migrations

```console
 sail artisan migrate
```

Installing all dependencies node

```console
 sail npm install
```

Seeded database

```console
 sail artisan db:seed
```


Running the scheduler

```console
 sail artisan schedule:work
```

  
