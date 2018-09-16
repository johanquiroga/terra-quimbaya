## Instalación

Para los siguientes pasos se deberá tener instalado y configurado la [EB CLI](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli3-install.html) y adicionalmente configuradas las credenciales de GIT (u otro método definido por el equipo de trabajo). Para mayor información, [aquí](https://docs.aws.amazon.com/codecommit/latest/userguide/setting-up.html).

1. Clonar el repositorio `git clone https://git-codecommit.us-west-2.amazonaws.com/v1/repos/TerraQuimbaya`
2. Sobre la carpeta donde se clonó el proyecto ejecutar `composer install`
3. Crear y configurar la base de datos que va a ser utilizada para el proyecto
4. Crear el archivo `.env` mediante `cp .env.example .env`
5. Actualizar las variables de entorno según las configuraciones locales que serán utilizadas en el proyecto, sobre el archivo `.env`. Tener en cuenta configurar correctamente la información referida a la Base de Datos creada en el punto 3.

    Principales configuraciones asociadas en este archivo:

    ```
    DB_CONNECTION
    DB_HOST
    DB_PORT
    DB_DATABASE (configurada en el punto 3)
    DB_USERNAME= usuario para la conexión a la BD
    DB_PASSWORD= contraseña para la conexión a la BD

    APP_IVA=0.05 (variable utilizada para el cálculo del IVA sobre los productos ofrecidos en la plataforma)
    JWT_SECRET= Llave secreta del JSON WEB TOKEN (utilizado para la comunicación entre la API y el aplicativo móvil)

    PROVIDER_FORM= Dirección web del formulario inscripción de Proveedores.
    ```

6. Adicionalmente, en el archivo `.env` se deberá configurar la información respecto a los servicios de mensajería, [Pusher](https://pusher-community.github.io/real-time-laravel/getting-started/setting-env-vars.html), [PayU](http://developers.payulatam.com/es/web_checkout/sandbox.html), entre otras.

7. Sobre la carpeta del proyecto, ejecuta `php artisan migrate` y luego `php artisan db:seed`.


### Nota:

-  Para la publicación a producción de una nueva versión de la plataforma se debe tener instalado y configurado correctamente (con el comando `eb init`) el cliente por línea de comandos EB CLI, por medio de este se administra la instancia de Elastic Beanstalk donde se encuentra publicada la plataforma. Para realizar la publicación se deben tener todos los cambios confirmados en el repositorio (con `git commit`) y posteriormente ejecutar el comando `eb deploy`. Para mayor información, [aquí](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli-codecommit.html#eb-cli-codecommit-deploy).