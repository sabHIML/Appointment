# Appointment
Simple Web-based Appointment management calendar. This is a good resource/project for learning php Namespace, psr-4 Autoloader, Design patterns, HTML5 local storage, AJAX on raw JS, RESTful API by developing own simple MVC framework.

### Features
The high level features are as follows: 

* View a table of the current appointments for next 30 days. 
* Add an appointment using a name and email address. Disallow adding appointments 
on days that already have one. 
* Work in offline mode and sync while get internet connection.

### Installation :
1. open ```<Project root>/src/config/config.ini``` on any editor and put database information.

2. To initialize project, open terminal , then cd to project root:
    now run :
    ```
    php install.php
    ```
    ```Installed successfully``` message will be appeared.

### Technical points of development 
* Application server is Created as a service using RESTful API, so that it becomes easy 
to create other clients for the same application.
* Developed a simple MVC with raw PHP.
* Technology covered : ```MVC, OOP, Namespace, psr-4 Autoloader, HTML5 local storage, AJAX, RESTful API```

### Future plans
* Remind an appointee using email.
* make calendar filter for particular date range.
* make syncing more robust and bug free.
* make more smooth AJAX handing. 

### Contributing
Any good patches are always appreciated.

	
	
