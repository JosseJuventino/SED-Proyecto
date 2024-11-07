# Proyecto de Seguridad

Este repositorio contiene el codigo fuente del proyecto de seguridad informatica

# Instalación de PHP en UBUNTU

```shell
    sudo apt update
    sudo apt install php libapache2-mod-php apache2
```

Una vez que hayas instalado PHP y Apache, hay que revisar que el servidor este corriendo.

```shell
    sudo systemctl start apache2
```

Tambien podemos habilitar para que se inicie automaticamente en cada reinicio

```shell
    sudo systemctl enable apache2
```

Como no tenemos dependencias de composer, solo vamos a iniciar el proyecto con el siguiente comando

```shell
    php -S localhost:8000 -t public
```

- `localhost:8000` es la dirección y el puerto en el que se ejecutará el servidor.
- `-t public` indica que el servidor debe apuntar al directorio public, que es donde usualmente está el archivo index.php principal para proyectos PHP.

## Estructura del proyecto

```plaintext
    SED-PROYECTO/
    ├── src/                # Código fuente principal
    │   ├── Controllers/    # Controladores de la aplicación
    │   ├── Models/         # Modelos que representan la lógica de negocio o datos
    │   └── Views/          # Vistas (templates o plantillas HTML)
    ├── public/             # Archivos públicos accesibles desde el navegador
    │   ├── index.php       # Archivo principal de entrada
    │   ├── css/            # Archivos CSS
    │   ├── js/             # Archivos JavaScript
    │   └── images/         # Imágenes del proyecto
    ├── config/             # Archivos de configuración
    │   └── config.php      # Configuración principal de la aplicación
    ├── vendor/             # Dependencias de Composer (De momento no lo usremos)
    ├── .env                # Variables de entorno 
    ├── .gitignore          
    ├── composer.json       # Archivo de configuración de Composer
    └── README.md           # Información básica del proyecto
```