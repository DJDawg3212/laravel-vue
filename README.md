## Primeros Pasos

Bienvenido a la documentación de la prueba tecnia de innclod que indicaba realizar un CRUD de registro de datos utilizando PHP, en este caso me apoye de los frameworks de Laravel y Vuejs, implementado con Inertiajs.

Es importante tener en cuenta que previamente se debe haber configurado la carpeta en la cual se ejecutan un proyecto de php, en este caso se realizaron pruebas con xamp para windows, y composer en mac.

Y para comenzar configuramos la base de datos, en MySQL la creamos con los siguientes comandos (con xamp podemos utilizar phpMyAdmin):
DROP DATABASE IF EXISTS laravelvue; #Recordar que esta acción elimina la base de datos si existe alguna con este nombre.
CREATE DATABASE laravelvue;
USE laravelvue

 
Los usuarios pre-definidos para efectos de prueba son los siguientes:
correo: admin@example.com
contraseña: password

## Instalación Local

- Clonar el repositorio en la carpeta en donde tengamos los proyectos de php (en windows con xamp buscar la carpeta xamp/htdocs) de la siguiente forma:
"git clone [https://github.com/DJDawg3212/laravel-vue.git] (https://github.com/DJDawg3212/laravel-vue.git)".
psdt: Si se presentan errores de permisos, favor indicarme el correo con el cual intentan clonar ya que algunas veces genera errores por no ser colaboradores.

- Ya clonado el repositorio, nos dirijimos a la carpeta con "cd laravel-vue" y "cp .env.example .env" para copiar el .env con esto procedemos a configurarlo con nuestra conexion a la bd.

- Ya configurado comenzamos a ejecutar los comandos de instalación "composer" y "npm install".

- Si no se presento nignun problema procedemos con la creación de los datos en la base de datos y la generación de la llave: 
    php artisan migrate:fresh --seed
    php artisan key:generate
    npm run build
(Para windows)
si todo se ejecuto bien y todo salio correctamente ejecutamos en el navegador: [http://127.0.0.1:8000]
(Desde mac)
Si todo salio bien ejecutamos en el navegador: http://laravel-vue.test/ 

Procediendo los pasos anteriores, en la esquina superior derecha realizamos el inicio de sesion con las credenciales das y podremos navegar entre el sistema.