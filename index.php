<?php
include "conexion.php";
session_start();
$sql = "SELECT * FROM productos ORDER BY nombre Asc";
$query = $dbConn->prepare($sql);
$query->execute(array());
$aviso=0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>CompuMundoHiperMegaRed</title>
	<link rel="stylesheet" type="text/css" href="./css/estilos.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script type="text/javascript"  href="./js/scripts.js"></script>
</head>
<body>
	<header>
		<h1>CompuMundoHiperMegaRed</h1>
		<a href="./carrito.php" title="ver carrito de compras">
			<img src="./imagenes/carrito.png">
		</a>
		
	</header>
	<nav>
		<center>
		<?php
        if(isset($_SESSION['autorizado'])){
        	?>
        	<span><font color="black">Hola: <?php echo $_SESSION['nom_cliente'];?></font></span><br>
        	<span><font color="black">Correo: <?php echo $_SESSION['email_cliente'];?></font></span>
        	<?php
        }else{
		?>
		<a href="./login.html" title="Ingresar">
			<img src="./imagenes/login.png" width="50" height="50">
		</a>
		<?php
}
		?>

	</nav>
	<section>
			 <?php
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    ?>
 
			<div class="producto">
			<center>
				<form method="get" action="carrito.php">
			    <span><input type="number" name="id" value="<?php echo $row['id_producto'];?>" style="visibility:hidden"><br>
				<img src="./productos/<?php echo $row['nombre'];?><?php echo $row['foto'];?>"><br>
				<span><?php echo $row['nombre'];?></span><br>
				<span>Precio: <?php echo $row['precio'];?></span><br>
				<span>Cantidad: <input type="number" name="cantidad" step="1" min="1" max="20"></span>
				<?php
				if (isset($_SESSION['carrito'])) {
                 for ($i=0; $i <count($_SESSION['carrito']) ; $i++) { 
                 	$datos=$_SESSION['carrito'];
                 	if($datos[$i]['Id']==$row['id_producto']){
                 		$aviso=1;
                 		break;
                 }else{
                 	$aviso=0;	
                 }
                 	}
                 	if($aviso==0){
                 		?>
                 	<input type="submit" name="Submit" value="Agregar" /></span>
                        <?php

                 	}else{
                 		?>
                 		 <input type="submit" name="eliminar" value="Eliminar" /></span>
                 		<?php

                 	}
                 	
                 }else{
                 	?>
                 	<input type="submit" name="Submit" value="Agregar" /></span>
                       
                        <?php
                 }
                 
				?>
				</form>	
			</center>
		</div>
	<?php
		}
	?>		
	</section>
</body>
</html>