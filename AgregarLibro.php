<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>Crear Nuevo Libro</title>
 <style type="text/css" rel="stylesheet">
 .error{
 color: red;
 }
 </style>
</head>
<body>

<?php
 //incluir conexión a la base de datos
 include 'ConexionBD.php';

 $nombre = isset($_POST["nombre"]) ? mb_strtoupper(trim($_POST["nombre"]), 'UTF-8') : null;
 $isbn= isset($_POST["isbn"]) ? mb_strtoupper(trim($_POST["isbn"]), 'UTF-8') : null;
 $numpagina= isset($_POST["numpagina"]) ? mb_strtoupper(trim($_POST["numpagina"]), 'UTF-8') : null;
 $numcapitulo =isset($_POST["numcapitulo"]) ? mb_strtoupper(trim($_POST["numcapitulo"]), 'UTF-8') : null;
 $titulo = isset($_POST["titulo"]) ? mb_strtoupper(trim($_POST["titulo"]), 'UTF-8') : null;         
 $autor = isset($_POST["autor"]) ? mb_strtoupper(trim($_POST["autor"]), 'UTF-8') : null; 
 $nacionalidad = isset($_POST["nacionalidad"]) ? mb_strtoupper(trim($_POST["nacionalidad"]), 'UTF-8') : null; 
 
 $maxval = $conn->query("SELECT lib_codigo FROM Libro WHERE lib_codigo=(SELECT max(lib_codigo) FROM Libro)");
 $maxval1 = $conn->query("SELECT cap_codigo FROM Capitulos WHERE cap_codigo=(SELECT max(cap_codigo) FROM Capitulos)");
 while ($row = $maxval->fetch_assoc() && $row1= $maxval1->fetch_assoc()) {
     $Vusuario = $row['lib_codigo'];
     $Vusuario1 = $row1['cap_codigo'];
 }
 $Vusuario+=1;
 echo($Vusuario);
 $Vusuario1+=1;
 echo($Vusuario1);
  
 $sql = "INSERT INTO Libro VALUES (0, '$nombre', '$isbn', '$numpagina', 'ACTIVO')";

 $sql1 = "INSERT INTO Capitulos VALUES (0,'$numcapitulo','$titulo','ACTIVO','$Vusuario')";        
 $sql2= "INSERT INTO Autor VALUES (0,'$autor','$nacionalidad','ACTIVO','$Vusuario1')";  

 if ($conn->query($sql) === TRUE && $conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
 echo "<p>Se ha creado los datos correctamemte!!!</p>";
 } else {
 if($conn->errno == 1062){
 echo "<p class='error'>El isbn $isbn ya esta registrado en el sistema </p>";
 }else{
 echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
 }
 }
 //cerrar la base de datos
 $conn->close();
 ?>
</body>
</html>