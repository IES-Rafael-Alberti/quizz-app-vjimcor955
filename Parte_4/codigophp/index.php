<?php
  session_start();

  // cerrar la sesion
  if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Quiz - Parte 4</title>
  <link rel="stylesheet" href="quiz_4.css">
</head>

<body>
  <form method="post">
    <h1>PHP Quiz - Parte 4</h1>
    <?php
      // comprobar si hay usuario al que mantenerle la sesion
      if (isset($_SESSION["username"])) {
        echo "<p>Usuario: " . $_SESSION["username"] . "</p>";
      } else {
        echo "<p>Usuario: Invitado</p>";
      }

      // boton para cerrar la sesion en caso de que haya una iniciada
      if (isset($_SESSION["username"])) {
        echo "<p><a href='?logout=true'>Cerrar sesión</a></p>";
      }

      $servername = "db";
      $username = "root";
      $password = "pestillo";
      $database = "Quizz_app-Parte_4";

      try {
        $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $queryPreguntas = "SELECT * FROM `Pregunta` WHERE `quiz_id` = 1 LIMIT 0, 5";
        $statementPreguntas = $connection->prepare($queryPreguntas);
        $statementPreguntas->execute();

        $i = 1;
        while ($row = $statementPreguntas->fetch(PDO::FETCH_ASSOC)) {
          echo "<div class='question' id='question$i'>";
            echo "<p>$i. " . $row["question_text"] . "</p>";
            echo "<label><input type='radio' name='q$i' value='a'> a) " . $row["option_a"] . "</label>";
            echo "<label><input type='radio' name='q$i' value='b'> b) " . $row["option_b"] . "</label>";
            echo "<label><input type='radio' name='q$i' value='c'> c) " . $row["option_c"] . "</label>";
            echo "<label><input type='radio' name='q$i' value='d'> d) " . $row["option_d"] . "</label>";
          echo "</div>";
          $i++;
        }
      } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
      } finally {
        $connection = null;
      }
    ?>
    <input type="submit" value="Submit" name="Resultado">
    <a href="?retake=true">Reintentar formulario</a>
  </form>

  <div class="resultado">
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["Resultado"])) {
          $servername = "db";
          $username = "root";
          $password = "pestillo";
          $database = "Quizz_app-Parte_4";
  
          try {
            $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $queryPreguntas = "SELECT * FROM `Pregunta` WHERE `quiz_id` = 1 LIMIT 0, 5";
            $statementPreguntas = $connection->prepare($queryPreguntas);
            $statementPreguntas->execute();
  
            $lista_respuestas = [];
            while ($row = $statementPreguntas->fetch(PDO::FETCH_ASSOC)) {
              $respuesta = strval($_POST["q" . $row["question_id"]]);
              $lista_respuestas[] = $respuesta;
            }    
  
            $nota = 0; 
            $i = 0;
  
            $queryPreguntas = "SELECT * FROM `Pregunta` WHERE `quiz_id` = 1 LIMIT 0, 5";
            $statementPreguntas = $connection->prepare($queryPreguntas);
            $statementPreguntas->execute();
  
            while ($row = $statementPreguntas->fetch(PDO::FETCH_ASSOC)) {
              if (empty($lista_respuestas[$i])) {
                $lista_respuestas[$i] = "";
              }
              if ($row["correct_option"] === $lista_respuestas[$i]) {
                echo "<p>- Pregunta " . ($i + 1) . ": Correcta</p>";
                $nota++;
              } else {
                echo "<p>- Pregunta " . ($i + 1) . ": Incorrecta</p>";
              }
              $i++;
            }
          } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
          } finally {
            $connection = null;
          }      
          echo "<p>Tu nota es: $nota</p>";
        }
      }
    ?>
  </div>
  <div class="funcionalidades">
    <div class="crud">
      <h1>CRUD</h1>
      <form method="post">
        <h2>Crear pregunta (C)</h2>
        <input type="text" name="question_id" placeholder="ID pregunta">
        <input type="text" name="quiz_id" placeholder="ID cuestionario">
        <input type="text" name="question_text" placeholder="Texto pregunta">
        <input type="text" name="option_a" placeholder="Opción A">
        <input type="text" name="option_b" placeholder="Opción B">
        <input type="text" name="option_c" placeholder="Opción C">
        <input type="text" name="option_d" placeholder="Opción D">
        <input type="text" name="correct_option" placeholder="Opción correcta">
        <input type="text" name="question_type" placeholder="Tipo de pregunta">
        <input type="text" name="question_details" placeholder="Detalles">
        <br><br>
        <input type="submit" value="Submit" name="Crear">
        <?php
          if (isset($_POST["Crear"])) {
            $servername = "db";
            $username = "root";
            $password = "pestillo";
            $database = "Quizz_app-Parte_4";
      
            try {
              $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              // Recoger los datos del formulario
              $question_id = $_POST["question_id"];
              $quiz_id = $_POST["quiz_id"];
              $question_text = $_POST["question_text"];
              $option_a = $_POST["option_a"];
              $option_b = $_POST["option_b"];
              $option_c = $_POST["option_c"];
              $option_d = $_POST["option_d"];
              $correct_option = $_POST["correct_option"];
              $question_type = $_POST["question_type"];
              $question_details = $_POST["question_details"];
    
              // Query para insertar los datos
              $queryPreguntas = "INSERT INTO `Pregunta` (`question_id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `question_type`, `question_details`) VALUES ('$question_id', '$quiz_id', '$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option', '$question_type', '$question_details')";
              $statementPreguntas = $connection->prepare($queryPreguntas);
              $statementPreguntas->execute();
      
              // Confirmacion de insertar los datos
              echo "<p>Se ha insertado la pregunta correctamente</p>";
            } catch (PDOException $e) {
              echo "<p>Error: " . $e->getMessage() . "</p>";
            } finally {
              $connection = null;
            }
          }
        ?>
      </form>
    
      <form method="post">
        <h2>Leer preguntas (R)</h2>
        <input type="submit" value="Submit" name="Leer">
        <?php
          if (isset($_POST["Leer"])) {
            $servername = "db";
            $username = "root";
            $password = "pestillo";
            $database = "Quizz_app-Parte_4";
      
            try {
              $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              $queryPreguntas = "SELECT * FROM `Pregunta` WHERE `quiz_id` = 1";
              $statementPreguntas = $connection->prepare($queryPreguntas);
              $statementPreguntas->execute();
      
              $i = 1;
              while ($row = $statementPreguntas->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>" . $row["question_id"] . ". " . $row["question_text"] . "</p>";
                $i++;
              }    
            } catch (PDOException $e) {
              echo "<p>Error: " . $e->getMessage() . "</p>";
            } finally {
              $connection = null;
            }
          }
        ?>
      </form>
      
      <form method="post">
        <h2>Actualizar pregunta (U)</h2>
        <select name="question_id">
          <?php
            $servername = "db";
            $username = "root";
            $password = "pestillo";
            $database = "Quizz_app-Parte_4";
    
            try {
              $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              $queryPreguntas = "SELECT * FROM `Pregunta` WHERE `quiz_id` = 1";
              $statementPreguntas = $connection->prepare($queryPreguntas);
              $statementPreguntas->execute();
    
              while ($row = $statementPreguntas->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row["question_id"] . "'>Pregunta " . $row["question_id"] . "</option>";
              }    
            } catch (PDOException $e) {
              echo "<p>Error: " . $e->getMessage() . "</p>";
            } finally {
              $connection = null;
            }
          ?>
        </select>
        <br><br>
        <input type="text" name="quiz_id" placeholder="ID cuestionario">
        <input type="text" name="question_text" placeholder="Texto pregunta">
        <input type="text" name="option_a" placeholder="Opción A">
        <input type="text" name="option_b" placeholder="Opción B">
        <input type="text" name="option_c" placeholder="Opción C">
        <input type="text" name="option_d" placeholder="Opción D">
        <input type="text" name="correct_option" placeholder="Opción correcta">
        <input type="text" name="question_type" placeholder="Tipo de pregunta">
        <input type="text" name="question_details" placeholder="Detalles">
        <br><br>
        <input type="submit" value="Actualizar" name="Actualizar">
        <?php
          if (isset($_POST["Actualizar"])) {
            $servername = "db";
            $username = "root";
            $password = "pestillo";
            $database = "Quizz_app-Parte_4";
      
            try {
              $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              // Recoger los datos del formulario
              $question_id = $_POST["question_id"];
              $quiz_id = $_POST["quiz_id"];
              $question_text = $_POST["question_text"];
              $option_a = $_POST["option_a"];
              $option_b = $_POST["option_b"];
              $option_c = $_POST["option_c"];
              $option_d = $_POST["option_d"];
              $correct_option = $_POST["correct_option"];
              $question_type = $_POST["question_type"];
              $question_details = $_POST["question_details"];
    
              // Query para actualizar los datos
              $queryPreguntas = "UPDATE `Pregunta` SET `question_id` = '$question_id', `quiz_id` = '$quiz_id', `question_text` = '$question_text', `option_a` = '$option_a', `option_b` = '$option_b', `option_c` = '$option_c', `option_d` = '$option_d', `correct_option` = '$correct_option', `question_type` = '$question_type', `question_details` = '$question_details' WHERE `Pregunta`.`question_id` = '$question_id'";
              $statementPreguntas = $connection->prepare($queryPreguntas);
              $statementPreguntas->execute();
      
              // Confirmacion de insertar los datos
              echo "<p>Se ha actualizado la pregunta " . $question_id . " correctamente</p>";
            } catch (PDOException $e) {
              echo "<p>Error: " . $e->getMessage() . "</p>";
            } finally {
              $connection = null;
            }
          }
        ?>
      </form>
    
      <form method="post">
        <h2>Eliminar pregunta (D)</h2>
        <select name="question_id">
          <?php
            $servername = "db";
            $username = "root";
            $password = "pestillo";
            $database = "Quizz_app-Parte_4";
    
            try {
              $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              $queryPreguntas = "SELECT * FROM `Pregunta` WHERE `quiz_id` = 1";
              $statementPreguntas = $connection->prepare($queryPreguntas);
              $statementPreguntas->execute();
    
              while ($row = $statementPreguntas->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row["question_id"] . "'>Pregunta " . $row["question_id"] . "</option>";
              }    
            } catch (PDOException $e) {
              echo "<p>Error: " . $e->getMessage() . "</p>";
            } finally {
              $connection = null;
            }
          ?>
        </select>
        <br><br>
        <input type="submit" value="Eliminar" name="Eliminar">
        <?php
          if (isset($_POST["Eliminar"])) {
            $servername = "db";
            $username = "root";
            $password = "pestillo";
            $database = "Quizz_app-Parte_4";
      
            try {
              $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
              $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              // Recoger los datos del formulario
              $question_id = $_POST["question_id"];
    
              // Query para eliminar los datos
              $queryPreguntas = "DELETE FROM `Pregunta` WHERE `Pregunta`.`question_id` = '$question_id'";
              $statementPreguntas = $connection->prepare($queryPreguntas);
              $statementPreguntas->execute();
      
              // Confirmacion de borrar la pregunta
              echo "<p>Se ha eliminado la pregunta " . $question_id . " correctamente</p>";
            } catch (PDOException $e) {
              echo "<p>Error: " . $e->getMessage() . "</p>";
            } finally {
              $connection = null;
            }
            
          }
        ?>
      </form>
    </div>
    <div class="usuario">
      <h1>Usuario</h1>
      <div class="login">
        <form method="post" class="login">
          <h2>Iniciar Sesion</h2>
          <input type="text" name="username" placeholder="Username">
          <input type="password" name="password" placeholder="Password">
          <input type="submit" value="Login" name="Login">
          <?php
            if (isset($_POST["Login"])) {
              $servername = "db";
              $username = "root";
              $password = "pestillo";
              $database = "Quizz_app-Parte_4";
        
              try {
                $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Recoger los datos del formulario
                $username = $_POST["username"];
                $password = $_POST["password"];
      
                // Query para obtener los datos del usuario
                $queryUsuario = "SELECT `username`, `password` FROM `User` WHERE `username` = '$username'";
                $statementUsuario = $connection->prepare($queryUsuario);
                $statementUsuario->execute();
        
                // Confirmacion del login del usuario
                if ($row = $statementUsuario->fetch(PDO::FETCH_ASSOC)) {
                  if (password_verify($password, $row["password"])) {
                    // Guardar el useranme en la sesion
                    $_SESSION["username"] = $username;
                    echo "<p>Se ha logeado el usuario correctamente, actualiza la página para activar la sesion.</p>";
                  } else {
                    echo "<p>Contraseña incorrecta</p>";
                  } 
                } else {
                  echo "<p>Usuario incorrecto</p>";
                } 
              } catch (PDOException $e) {
                echo "<p>Error: " . $e->getMessage() . "</p>";
              } finally {
                $connection = null;
              }
            }
          ?>
        </form>
      </div>
      <div class="register">
        <form method="post" class="registro">
          <h2>Registrarse</h2>
          <input type="text" name="user_id" placeholder="User_id">
          <input type="text" name="username" placeholder="Username">
          <input type="text" name="password" placeholder="Password">
          <input type="email" name="email" placeholder="Email">
          <input type="submit" value="Registro" name="Registro">
          <?php
            if (isset($_POST["Registro"])) {
              $servername = "db";
              $username = "root";
              $password = "pestillo";
              $database = "Quizz_app-Parte_4";
        
              try {
                $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Recoger los datos del formulario
                $user_id = $_POST["user_id"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];

                // Encriptar la contraseña
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      
                // Query para insertar el usuario
                $queryUsuario = "INSERT INTO `User` (`user_id`, `username`, `password`, `email`) VALUES ('$user_id', '$username', '$hashed_password', '$email')";
                $statementUsuario = $connection->prepare($queryUsuario);
                $statementUsuario->execute();
        
                // Confirmacion de insertar el usuario
                echo "<p>Se ha registrado el usuario correctamente</p>";
              } catch (PDOException $e) {
                echo "<p>Error: " . $e->getMessage() . "</p>";
              } finally {
                $connection = null;
              }
            }
          ?>
        </form>
      </div>
    </div>
  </div>
</body>

</html>