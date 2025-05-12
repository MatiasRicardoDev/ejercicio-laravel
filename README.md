<h2>Configuracion de ambiente</h2>
<p>Para poder configurar correctamente el ambiente debemos dirigirnos al archivo <i>.env</i>, el cual vamos a cargar las siguientes variables:
</p>
<code>
EXTERNAL_TYPE=
</code>
<br>
<br>
<code>
EXTERNAL_URL=
</code>
<p>Donde la variable <b>EXTERNAL_TYPE</b> es el tipo de origen del "Recurso Externo" por ejemplo: <br>
<i>json_file</i> para archivos json
<br>
<i>web_service</i> para servicios web
</p>

<p>Por otro lado tenemos la variable <b>EXTERNAL_URL</b>
donde sera la encargada de tener la ruta de acceso del recurso, por ejemplo el link web, o el path de archivo
</p>
<hr>
<br>
<h2>Ejecucion del servicio</h2>
<p>Para poder ejecutar el servicio necesitamos correr en la terminal el siguiente comando
<code>php artisan app:seed-data</code> El cual obtendra los datos del recurso proporcionado, y guardara los datos en la base de datos.
</p>
<hr>

<h2>Pruebas de Testing</h2>

<p>Para poder ejecutar las pruebas debemos correr el siguiente comando en la terminal</p>

<code>php artisan test</code>

<p>
Luego se ejecutaran las funciones de testing, y nos informara el resultado con la informacion necesaria para poder analizar el funcionamiento del sistema.
</p>

