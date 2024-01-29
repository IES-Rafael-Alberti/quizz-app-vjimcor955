<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Quiz - Parte 3</title>
  <link rel="stylesheet" href="quiz.css">
</head>

<body>
  <form method="post">
    <h1>PHP Quiz - Parte 3</h1>
    <?php
      $servername = "db";
      $username = "root";
      $password = "pestillo";
      $database = "Quizz_app-Parte_3";

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
          $database = "Quizz_app-Parte_3";
  
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
        $database = "Quizz_app-Parte_3";
  
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
        $database = "Quizz_app-Parte_3";
  
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
    <select name="question_id" id="questions">
      <?php
        $servername = "db";
        $username = "root";
        $password = "pestillo";
        $database = "Quizz_app-Parte_3";

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
        $database = "Quizz_app-Parte_3";
  
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
    <select name="question_id" id="questions">
      <?php
        $servername = "db";
        $username = "root";
        $password = "pestillo";
        $database = "Quizz_app-Parte_3";

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
        $database = "Quizz_app-Parte_3";
  
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
</body>

</html>