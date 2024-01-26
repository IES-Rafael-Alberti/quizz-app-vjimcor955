<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Quiz - Parte 2</title>
  <link rel="stylesheet" href="quiz.css">
</head>

<body>
  <form method="post">
    <h1>PHP Quiz - Parte 2</h1>

    <?php
      $servername = "db";
      $username = "root";
      $password = "pestillo";
      $database = "Quizz_app";

      try {
        $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $queryPreguntas = "SELECT * FROM `Preguntas` WHERE `Cuestionario_quiz_id` = 1";
        $statementPreguntas = $connection->prepare($queryPreguntas);
        $statementPreguntas->execute();

        $i = 1;
        while ($row = $statementPreguntas->fetch(PDO::FETCH_ASSOC)) {
          echo "<div class='question'>";
            echo "<p>$i. " . $row["question_text"] . "</p>";
            echo "<label><input type='radio' name='q$i' value='a'> a) " . $row["option_a"] . "</label>";
            echo "<label><input type='radio' name='q$i' value='b'> b) " . $row["option_b"] . "</label>";
            echo "<label><input type='radio' name='q$i' value='c'> c) " . $row["option_c"] . "</label>";
            echo "<label><input type='radio' name='q$i' value='d'> d) " . $row["option_d"] . "</label>";
          echo "</div>";
          $i++;
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      } finally {
        $connection = null;
      }
    ?>
    <input type="submit" value="Submit">
    <a href="?retake=true">Reintentar formulario</a>
  </form>
  <div class="resutlado">
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $q1 = strval($_POST["q1"]);
        $q2 = strval($_POST["q2"]);
        $q3 = strval($_POST["q3"]);
        $q4 = strval($_POST["q4"]);
        $q5 = strval($_POST["q5"]);
        $q6 = strval($_POST["q6"]);
        $q7 = strval($_POST["q7"]);
        $q8 = strval($_POST["q8"]);
        $q9 = strval($_POST["q9"]);
        $q10 = strval($_POST["q10"]);
        $nota = 0;
        
        $lista_respuestas = [$q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10];

        $servername = "db";
        $username = "root";
        $password = "pestillo";
        $database = "Quizz_app";
  
        try {
          $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
          $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
          $queryPreguntas = "SELECT * FROM `Preguntas` WHERE `Cuestionario_quiz_id` = 1";
          $statementPreguntas = $connection->prepare($queryPreguntas);
          $statementPreguntas->execute();
  
          $i = 0;
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
          echo "Error: " . $e->getMessage();
        } finally {
          $connection = null;
        }      
        echo "<p>Tu nota es: $nota</p>";
      }
    ?>
  </div>
</body>

</html>