## Loan API
REST API for a Loan Application which allows users to Request, Get Pending Payments and Make Payments for a Loan.


### Development environment setup
Uses Laravel Sail to setup local development environment. 
- Make sure that you have composer installed on your system
- Run ```chmod +x ./setup.sh```
- Run ```./setup.sh```  

This should setup and start a server at http://localhost:8080. 
The MySQL server will be accessible on the port *33060*. 
These ports can be changed by changing the values of *APP_PORT* and *FORWARD_DB_PORT* values in .env file. 

### Running tests
```
./vendor/bin/sail test
```

### Admin user
An admin user is created with the following credentials:  
```
email: admin@example.com  
password: secret1234
```

### Postman collection
Aspire-Loan-Api.postman_collection.json

### Developer Note
Leveraged Test Driven Development for building this application using Laravel 10 & Php8. 
Followed Domain Driven Design development; Ref: https://stitcher.io/laravel-beyond-crud
and implemented most of the DDD ideas the Laravel way.