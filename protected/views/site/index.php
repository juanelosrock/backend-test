<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Bienvenidos al <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<h1>Documentacion</h1>

<ul>
	<li>Introduccion</li>
	<li>Metodos</li>
</ul>

<hr>

<h2>Introduccion</h2>
<p>Esta API fue creada con el fin de presentar una prueba de BackEnd para la empresa PRIVERION, aqui encontraremos los metodos para Crear, Leer, Actualizar y Borrar Paises
</p>

<hr>
<h2>Metodos</h2>

<ul>
	<li>
		<h1>Autenticacion</h1>
		<p>Las credenciales seran otorgadas por el Administrador del Sistema </p>
		<h4>Aplicacion JSON</h4>
		<h4>Metodo POST</h4>
		<h4>URL: https://apitest.grupoqimera.co/index.php/api/sibco/registertoken</h4>
	</li>
	<li>
		<h3>Formato JSON</h3>
		<p>
		 <pre>{"nick":{{usuario}},"clave":{{clave}},"date":{{fecha}},"number":{{numero_aleatorio}}}</pre> 
		</p>
	</li>
	<li>
		<h3>Salida</h3>
		<p>
			<pre>{"name":{{usuario}},"token":{{token}},"vendedor":null,"tienda":null}</pre>
		</p>
	</li>
	<li>
		<h1>Traer Paises</h1>
		<p>Todos los request que se realicen deben incluir el header Authorization con el valor del token. <br> Aqui vamos a traer los paises en el sistema, puedes traer todos los paises o solo un pais</p>
		<h4>Aplicacion JSON</h4>
		<h4>Metodo GET</h4>
		<h4>Datos Codigo del pais, se puede quitar para traer todos los paises</h4>
		<h4>URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises/{{codigo}}</h4>
	</li>
	<li>
		<h3>Formato JSON</h3>
		<p>
		 <pre></pre> 
		</p>
	</li>
	<li>
		<h3>Salida</h3>
		<p>
			<pre>{"success":true,"message":"Object Paises","data":{"totalCount":1,"data":[{"_id":{"oid":"63cf46c572cbbb1942176562"},"nombre":"ALEMANIA","moneda":"EUR","codigo":"DEU","bandera":""}]}}</pre>
		</p>
	</li>
	<li>
		<h1>Crear Pais</h1>
		<p>Todos los request que se realicen deben incluir el header Authorization con el valor del token. <br> Aqui vamos a crear un pais nuevo en el sistema</p>
		<h4>Aplicacion JSON</h4>
		<h4>Metodo PUT</h4>		
		<h4>URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises</h4>
	</li>
	<li>
		<h3>Formato JSON</h3>
		<p>
		 <pre>{"codigo":"DEU","nombre":"ALEMANIA","moneda":"DEU","bandera":""}</pre> 
		</p>
	</li>
	<li>
		<h3>Salida</h3>
		<p>
			<pre>{"success":true,"message":"Object Paises","data":{"totalCount":5,"data":{"_id":{"oid":"63cf55db6c9b7d32d42c90e2"},"nombre":"CROACIA","moneda":"EUR","codigo":"CRO","bandera":""}}}</pre>
		</p>
	</li>
	<li>
		<h1>Actualizar Pais</h1>
		<p>Todos los request que se realicen deben incluir el header Authorization con el valor del token. <br> Aqui vamos a actualizar un pais nuevo en el sistema</p>
		<h4>Aplicacion JSON</h4>
		<h4>Metodo POST</h4>		
		<h4>URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises</h4>
	</li>
	<li>
		<h3>Formato JSON</h3>
		<p>
		 <pre>{"codigo":"DEU","nombre":"ALEMANIA","moneda":"DEU","bandera":""}</pre> 
		</p>
	</li>
	<li>
		<h3>Salida</h3>
		<p>
			<pre>{"success":true,"message":"Object Paises","data":{"totalCount":5,"data":{"_id":{"oid":"63cf55db6c9b7d32d42c90e2"},"nombre":"CROACIA","moneda":"EUR","codigo":"CRO","bandera":""}}}</pre>
		</p>
	</li>
	<li>
		<h1>Borrar Pais</h1>
		<p>Todos los request que se realicen deben incluir el header Authorization con el valor del token. <br> Aqui vamos a actualizar un pais nuevo en el sistema</p>
		<h4>Aplicacion JSON</h4>
		<h4>Metodo DELETE</h4>		
		<h4>URL: https://apitest.grupoqimera.co/index.php/api/sibco/paises/{{cdigo}}</h4>
	</li>
	<li>
		<h3>Formato JSON</h3>
		<p>
		 <pre></pre> 
		</p>
	</li>
	<li>
		<h3>Salida</h3>
		<p>
			<pre>{"success":true,"message":"Object Paises","data":{"totalCount":1,"data":{"Delete":"El codigo CRO ha sido borrado"}}}</pre>
		</p>
	</li>
</ul>