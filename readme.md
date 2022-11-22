The project is written by pure php without using any framework or libraries.

There are three different sources:
 1. "Post" demonstration of using a third party API to request data and examples of responding
for GET, POST, PUT, DELETE requests
 2. "User" depicting emulation of working with local database and work with JSON nested elements
 by performing serialization/deserialization operations
 3. "Google Analytics Items" showing the implementation with analytical request using JSON mock data

Routes

- "Posts" have several routes for CRUD operations:
- GET http://[domain:port]/posts - get list of all posts  
- GET http://[domain:port]/posts/{id} - get a specific post
- POST http://[domain:port]/posts - create a new post
- PUT http://[domain:port]/posts/{id} - update a specific post
- DELETE http://[domain:port]/posts/{id} - DELETE a selected post


- "User" have one route  
- GET http://[domain:port]/users - get list of all users

- "Google Analytics Items" have one route
- GET http://[domain:port]/ganalytics - get list of analytics items


Processing the request

1. When request comes to the implemented API, first step is to register functions to handle errors,
   exceptions and unexpected shutdown to send a correct response from API.
2. Next step is to initialize available routes which are implemented with using class and method attributes
3. As all routes are initialized, following action is to define controller and its method to handle the request 
4. When the controller is found it sends the request data to the service that is responsible for processing request data
5. The service uses data gateway to prepare request data for sending ot to external API or any database
6. Data gateway uses specific client to send and receive data to API or database and converts response
   to the entity or set of entities of the corresponding type 
7. The service performs business logic operations on these entities and sends the data back to the calling controller   
8. The Controller serializes obtained data to the request format

Notices

Since composer is not used there is a need to implement autoloading functions with spl_autoload_register function
The correct way of working with services is to use Dependency Injection technique. 
To make implementation concise there was used ContainerEmulator to get services.
All routes are functional although some parts were shortened. They contain comments or todo blocks
