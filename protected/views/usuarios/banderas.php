<label for="">Toda le gestion de paises de realiza directamente desde la plataforma web accede desde aqui: <a href="https://apitest.grupoqimera.co/front/" target="blank">Click Aqui para ir</a></label>
<table>
    <tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Moneda</th>
        <th>Bandera</th>
    </tr>
<?php 
    if(!empty($paises)){
        foreach($paises as $pais){
?>
    <tr>
        <td><?php echo $pais['codigo'] ?></td>
        <td><?php echo $pais['nombre'] ?></td>
        <td><?php echo $pais['moneda'] ?></td>
        <td><img src="<?php echo $pais['bandera'] ?>" width="150" height="100"></td>
    </tr>
<?php            
        }
    }
?>
</table>
