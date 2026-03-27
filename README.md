# Case Study Document and Ticketing System
This web app is written in PHP using the Laravel Framework

## Basic Structure
The backend resides in the `app/` folder.
It is subdivided into `app/Modules`, which operate independently and may be separated to different servers if desired.

### Modules
Each module is structured like this:
```
-> Application (containing "use cases" or "services")
-> Domain (containing Domain objects)
-> Infrastructure (containing anything that interacts with concrete external dependencies, 
    like the framework or external service providers)
```
Consequently, controllers also live in Infrastructure because they interact with the client.

### Data layer
Laravel has a love for static Database models with Active Record pattern, which creates strong dependencies to the framework.
This is why I create Repositories that encapsulate the ORM.
Migrations are in `database/migrations`

Currently, Salesforce serves as single source of truth. 
This increases traffic on the Salesforce API but removes any chance of systems being out of sync.

### Views
HTML views reside in `resources/views`.
The React SPA resides in `resources/js/spa`.

### Routing
Is defined in `routes/web.php` for Web-Requests and in `routes/api.php` for API-Requests.

### Case Study Data
Is saved in `storage/app/private/mocks/salesforce`.
Each user has their own json-file for the data with the user_id in the filename.

Documents for download are stored in the "files" folder underneath. 

### Start the Frontend React App
npm run dev
