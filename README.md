## Despliegue con docker (opcional)
- Clonar el repositorio
- Configurar archivo ``.env`` tomar como ejemplo ``.env-test``
- Crear un dns local ``127.0.0.1 claro-insurance.local`` o con el nombre que prefiera
- Configurar el dominio en ``nginx\vhost\default.conf`` en la linea 2 parametro server_name
- Ejecutar comando ``docker-compose up -d``


## Instalacion (el proyecto se encuentra en www)

- Clonar el repositorio
- Ir a la ruta del proyeto 
- Crear archivo de entorno ``.env``
- Ejecutar comando ``composer install``
- Ejecutar comando ``php artisan key:generate``
- Ejecutar comando ``npm install``
- Ejecutar comando ``npm run dev``
- Ejecutar comando ``php artisan migrate``
- Ejecutar comando ``php artisan db:seed``

## Configuraciones adicionales
- Se deben configurar las siguiente variables de entorno

* Necesario para conección a base de datos
``DB_CONNECTION=mysql``
``DB_HOST=database``
``DB_PORT=3306``
``DB_DATABASE=``
``DB_USERNAME=``
``DB_PASSWORD=``

* Necesario para el envio de correos
``MAIL_MAILER=smtp``
``MAIL_HOST=smtp.mailtrap.io``
``MAIL_PORT=2525``
``MAIL_USERNAME=``
``MAIL_PASSWORD=``
``MAIL_ENCRYPTION=tls``
``MAIL_FROM_ADDRESS='admin@admin.com'``
``MAIL_FROM_NAME="${APP_NAME}"``

## Usuario admin
- usuario: admin@admin.com
- clave: admin

## Requerimientos
- php 8+
- composer
- node.js
- recomendado: base de datos MySql

## Comandos
- Para ejecutar cola de correos: ``php artisan email:send``