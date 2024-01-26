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
        // Create a PDO instance
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        echo "<p>Connected successfully</p>";
    
        // Perform database operations here
    
      } catch (PDOException $e) {
          die("Connection failed: " . $e->getMessage());
      }
      
      $conn = null;
    ?>

    <!-- <div class="question">
      <p>10. ¿Cuál de los siguientes se utiliza para crear un objeto en PHP?</p>
      <label><input type="radio" name="q10" value="a Answer"> a) new (Respuesta correcta)</label>
      <label><input type="radio" name="q10" value="b"> b) objeto</label>
      <label><input type="radio" name="q10" value="c"> c) crear</label>
      <label><input type="radio" name="q10" value="d"> d) instancia</label>
    </div> -->

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

        for ($i = 0; $i < count($lista_respuestas); $i++) {
          if (empty($lista_respuestas[$i])) {
            $lista_respuestas[$i] = "";
          }
          if (str_contains($lista_respuestas[$i], 'Answer')) {
            echo "<p>- Pregunta " . ($i + 1) . ": Correcta</p>";
            $nota++;
          } else {
            echo "<p>- Pregunta " . ($i + 1) . ": Incorrecta</p>";
          }
        }
      
        echo "<p>Tu nota es: $nota</p>";
      }
    ?>
  </div>
</body>

</html>