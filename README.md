# backend-test
Backend Test Priverion

Acesso General = https://apitest.grupoqimera.co/index.php/

Usuario admin - clave 123456<br/

Bienvenidos al Api Test Priverion
Documentacion
Introduccion
Metodos
Introduccion
Esta API fue creada con el fin de presentar una prueba de BackEnd para la empresa PRIVERION, aqui encontraremos los metodos para Crear, Leer, Actualizar y Borrar Paises

Metodos
<h1>Autenticacion</h1>
Las credenciales seran otorgadas por el Administrador del Sistema<br/>

Aplicacion JSON<br/>
Metodo POST<br/>
URL: https://apitest.grupoqimera.co/index.php/api/sibco/registertoken<br/>
Formato JSON<br/>


{"nick":{{usuario}},"clave":{{clave}},"date":{{fecha}},"number":{{numero_aleatorio}}}


Salida<br/>


{"name":{{usuario}},"token":{{token}},"vendedor":null,"tienda":null}


<h1>Traer Paises</h1>
Todos los request que se realicen deben incluir el header Authorization con el valor del token.<br/>
Aqui vamos a traer los paises en el sistema, puedes traer todos los paises o solo un pais<br/>

Aplicacion JSON<br/>
Metodo GET<br/>
Datos Codigo del pais, se puede quitar para traer todos los paises<br/>
URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises/{{codigo}}<br/>
Formato JSON<br/>



 


Salida<br/>


{"success":true,"message":"Object Paises","data":{"totalCount":1,"data":[{"_id":{"oid":"63cf46c572cbbb1942176562"},"nombre":"ALEMANIA","moneda":"EUR","codigo":"DEU","bandera":""}]}}<br/>


<h1>Crear Pais</h1>
Todos los request que se realicen deben incluir el header Authorization con el valor del token.<br/>
Aqui vamos a crear un pais nuevo en el sistema<br/>

Aplicacion JSON<br/>
Metodo PUT<br/>
URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises<br/>
Formato JSON<br/>


{"codigo":"DEU","nombre":"ALEMANIA","moneda":"DEU","bandera":""}<br/>


Salida<br/>


{"success":true,"message":"Object Paises","data":{"totalCount":5,"data":{"_id":{"oid":"63cf55db6c9b7d32d42c90e2"},"nombre":"CROACIA","moneda":"EUR","codigo":"CRO","bandera":""}}}<br/>


<h1>Actualizar Pais</h1>
Todos los request que se realicen deben incluir el header Authorization con el valor del token.<br/>
Aqui vamos a actualizar un pais nuevo en el sistema<br/>

Aplicacion JSON<br/>
Metodo POST<br/>
URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises<br/>
Formato JSON<br/>


{"codigo":"DEU","nombre":"ALEMANIA","moneda":"DEU","bandera":""}<br/>


Salida<br/>


{"success":true,"message":"Object Paises","data":{"totalCount":5,"data":{"_id":{"oid":"63cf55db6c9b7d32d42c90e2"},"nombre":"CROACIA","moneda":"EUR","codigo":"CRO","bandera":""}}}<br/>


<h1>Borrar Pais</h1>
Todos los request que se realicen deben incluir el header Authorization con el valor del token.<br/>
Aqui vamos a actualizar un pais nuevo en el sistema<br/>

Aplicacion JSON<br/>
Metodo DELETE<br/>
URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises/{{cdigo}}<br/>
Formato JSON<br/>



 


Salida<br/>


{"success":true,"message":"Object Paises","data":{"totalCount":1,"data":{"Delete":"El codigo CRO ha sido borrado"}}}<br/>
