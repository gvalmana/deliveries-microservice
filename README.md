### Descripción del proyecto

- Microservicio para la gestión de las órdenes de comida a la cosina
- Esta desarrollado en Laravel 10 con base de datos MariaDB version 10.4.6
- Usa Kafka como protocolo de comunicación los demás microservcios del proyecto o o emplea una comunicación mediante peticiones HTTP
- Usa Reddis como motor de gestión de las colas de los eventos disparados

### Instrucciones de despliegue
- Para desplegar en entorno local de clonarse el repositorio
- En caso de tener docker instalado debe ejecutarse docker-compose up para la creación de los contenedores de la plataforma
- copiar contenido del fihcero .env.example para las variabels de configuración
- en caso de no tener docker instalado deben ejecutarse los comandos necesarios para la instalación y configuración de un proyecto en Laravel
- debe ejecutarse** php artisan migrate --seed** en caso de espelgarse localmente sin docker para la carga de los datos de pruebas iniciales

### Variables de configuración necesarias
**STOCK_INGREDIENTS_URL** - representa la URL del microservicio que gestiona el stock de productos (bodega)
**KAFKA_BROKERS** - indica el servidor de Kafka que se usará como broker de mensajería
**KAFKA_CONSUMER_GROUP_ID** - grupo por defecto que se usara para la comunicacion entre microservicios
**APP_COMUNICATION_PROTOCOL** - indica el protocolo a usar para comunicarse entre ambos microservicios, tener en cuenta de que en caso de usarse este protocolo debe considerarse tener además desplegado el microservicio del stock de productos, por tanto no es aconsejable usarlo
**APP_SECURITY_KEY** - es el token cifrado que se debe usar en el header Authorizathion para la comunicación HTTP entre microservicios
**Nota:** una vez ejecutadas las configuraciones puede ejecutarse el test funcional que chequea las configuraciones con el comando
`php artisan test tests/Feature/AppConfigTest.php`
### Middlewares personalizados
**app/Http/Middleware/LogHttpRequests.php** - Middleware para guardar en logs las peticiones HTTP entre microservicios
**app/Http/Middleware/CheckAuthorizationHeader.php** - Middleware que valida el header Authorization en la comunicacion HTTP
### Directorios del proyecto
app/Http/UseCases - Son las implementaciones de los casos de uso del negocio
app/Traits - Diferentes traits usados en el proyecto para estandarizar el formato de las respuestas HTTP, el paginado, salida de logs y consola
app/Models/Repositories - Implementaciones de los repositorios de acceso a datos
app/Helpers - Diferentes clases Helpers con sus implementaciones de ayuda
app/Adapters - Adaptadores de conexión HTTP junto con sus implementaciones
### Documentacion de la API
La API Http Rest para el consumo de las aplicaciones clientes está confeccionada con Swagger2 y puede consultarse mediante el endpoint http:://host/api/documentacion
