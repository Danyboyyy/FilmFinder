<?php
  session_start();
  $usuario = $_SESSION['username'];
?>

<html>
  <style type="text/css">
  </style>
  <script type="text/javascript">
  </script>
  <head>
    <h1>FilmFinder</h1>
    <h2>Usuario</h2>
  </head>
  <body>
    <p><a href="mostrar_x_nombre.php">Buscar por nombre</a></p>
    <p><a href="mostrar_x_actor.php">Buscar por actor</a></p>
    <p><a href="mostrar_x_director.php">Buscar por director</a></p>
    <p><a href="mostrar_x_año.php">Buscar por año</a></p>
    <p><a href="mostrar_x_plataforma.php">Buscar por plataforma</a></p>
    <p><a href="mostrar_x_genero.php">Buscar por género</a></p>
    <p><a href="ver_favoritos.php">Ver favoritos</a></p>
    <p><a href="hacer_sugerencia.php">Hacer sugerencia</a></p>
    <p><a href="añadir_favorito.php">Añadir Favorito</a></p>
    <p><a href="añadir_comentario.php">Añadir Comentario</a></p>

    <br><br><a href="/../index.php">Salir</a>
  </body>
</html>
