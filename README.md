# Loans and Credits System Demo

## Description

Dashboard to manage Financial Products like Credit Cards, Loans, Invest Founds, etc.
Also, the user can get automatic new products recommendations based on his/her financial and personal information
and the products available at the moment.

The App has two type of users: 

1- Admin users (ROLE_ADMIN), that manage products, users and types of products categories.

2- Client users (ROLE_USER), manage their financial products, set their personal information and financial preferences and
receive recommendations for new products.

## Business Rules

1- The only way to get new products is from "Nuevo préstamo" section, that will run an algorithm to determine the best product to offer
to the client based on his personal and financial information.

2- Once a Product Recommendation has be offered to the client, he will have to accept or reject it. If the client accept the recommendation, 
The product associated will be acquired by the client with the conditions fixed in his Financial Preferences (interest rate, max term of loan, loan amount).

3- All recommendations created by the App, will be stored for historical and analytical purposes in order to improve the algorithm.

4- Clients only will have access to his own data.

5- For get a Product Recommendation, a client must have set his Financial preferences before.

6- The fallowing basic constraints have been taken into account to get Recommendations to the client: 

- The sum of the client age and the max term of the loans the client are requesting, can't be equal or greater than 80.
- The total monthly spends of the client (including other debts), can't be greater than the 40% of his monthly net income.

## Local development environment

### Technical requirements

- Docker and Docker Compose v2

### Set up the environment

Once cloned the repository, fallow these steps (Linux shell):

```
cd project/root/dir 
``` 

```
docker compose build --pull --no-cache
```

```
docker compose up -d
```

Run make command to install dependencies and create database schema with populated test data

```
$ docker exec -i loans-demo-php sh -c "make build"
```

Open https://localhost/loans in your browser

### Test Users

- client1@myemail.com:test  [ROLE_USER]
- admin@myemail.com:test    [ROLE_ADMIN]

There are more test client users, with same password, same username except first part of email (client1, client2, client..n)

### Run Unit Tests

```
$ docker exec -i loans-demo-php sh -c "vendor/phpunit/phpunit/phpunit"
```

