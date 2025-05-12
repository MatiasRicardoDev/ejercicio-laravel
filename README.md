## Configuración de ambiente

Para configurar correctamente el ambiente, dirígete al archivo `.env` y agrega las siguientes variables:

```env
EXTERNAL_TYPE=
EXTERNAL_URL=
```

- **EXTERNAL_TYPE**: Define el tipo de origen del "Recurso Externo". Por ejemplo:
    - `json_file` para archivos JSON
    - `web_service` para servicios web

- **EXTERNAL_URL**: Especifica la ruta de acceso al recurso, como el enlace web o la ruta del archivo.

---

## Ejecución del servicio

Para ejecutar el servicio, corre el siguiente comando en la terminal:

```bash
php artisan app:seed-data
```

Este comando obtendrá los datos del recurso proporcionado y los almacenará en la base de datos.

---

## Consulta de datos

Para consultar los datos en la base de datos, accede a la siguiente URL:

```
{SITE_URL}/api/{category}
```

Donde `{category}` es el ID de la categoría a consultar. Como resultado, obtendrás las entidades correspondientes a dicha categoría.

---

## Pruebas

Para ejecutar las pruebas, corre el siguiente comando en la terminal:

```bash
php artisan test
```

Se ejecutarán las funciones de testing y se mostrará el resultado con la información necesaria para analizar el funcionamiento del sistema.

