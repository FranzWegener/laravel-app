# Case Study Document and Ticketing System
This web app is written in PHP using the Laravel Framework

## Basic Structure
Laravel is a bit opinionated where you can put things, unfortunately.

### Controllers
app/Http/Controllers

### Database layer
Typically this is in app/Models. 
However currently Salesforce serves as single source of truth. 
This increases traffic on the Salesforce API but removes any chance of systems being out of sync.

### Salesforce Service/Module
app/Services/SalesforceService.php

### Salesforce mock data
storage/app/private/mocks

### Views
resources/views
