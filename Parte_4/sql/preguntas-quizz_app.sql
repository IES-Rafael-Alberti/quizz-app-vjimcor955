CREATE TABLE `Quizz_app-Parte_4`.`Pregunta` (
    `question_id` INT NOT NULL , 
    `quiz_id` INT NOT NULL , 
    `question_text` TEXT NOT NULL , 
    `option_a` VARCHAR(255) NOT NULL , 
    `option_b` VARCHAR(255) NOT NULL , 
    `option_c` VARCHAR(255) NOT NULL , 
    `option_d` VARCHAR(255) NOT NULL , 
    `correct_option` CHAR(1) NOT NULL , 
    `question_type` VARCHAR(50) NOT NULL , 
    `question_details` TEXT NOT NULL ,
    PRIMARY KEY (`question_id`), 
    FOREIGN KEY (`quiz_id`) REFERENCES `Cuestionario`(`quiz_id`)
);


INSERT INTO `Pregunta` (`question_id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `question_type`, `question_details`) VALUES 
('1', '1', '¿Qué significa PHP?', 'Página de inicio personal', 'Procesador de hipertexto', 'Procesador de hipervínculos privados', 'Página de enlace PHP', 'b', 'short_answer', 'Respuesta correcta única'), 
('2', '1', '¿Cuál de los siguientes NO es un tipo de dato de PHP?', 'Entero', 'Booleano', 'Carácter', 'Flotante', 'c', 'short_answer', 'Respuesta correcta única'),
('3', '1', '¿Cuál es el resultado de `echo "Hola" . " " . "Mundo";`?', 'HelloWorld', 'Hola Mundo', 'HelloWorld', '"Hola Mundo"', 'b', 'short_answer', 'Respuesta correcta única'),
('4', '1', 'En PHP, ¿qué bucle se utiliza para ejecutar un bloque de código un número especificado de veces?', 'Bucle for', 'Bucle while', 'Bucle do...while', 'Bucle foreach', 'a', 'short_answer', 'Respuesta correcta única'),
('5', '1', '¿Qué función de PHP se utiliza para abrir un archivo para escritura?', 'fopen', 'file_open', 'open_file', 'Ninguna de las anteriores', 'd', 'short_answer', 'Respuesta correcta única'),
('6', '1', '¿Cuál es el propósito de la superglobal `$_GET` en PHP?', 'Recuperar datos de un formulario con el método POST', 'Almacenar variables de sesión', 'Recuperar datos de la cadena de consulta URL', 'Definir constantes globales', 'c', 'short_answer', 'Respuesta correcta única'),
('7', '1', '¿Cuál de los siguientes es un ejemplo de constante mágica de PHP?', '$this', 'LINE', '$var', 'functionName()', 'b', 'short_answer', 'Respuesta correcta única'),
('8', '1', '¿Qué hace la función `include` en PHP?', 'Ejecuta un bloque de código solo si una condición es verdadera', 'Incluye y evalúa un archivo especificado', 'Define una nueva función', 'Genera un número aleatorio', 'b', 'short_answer', 'Respuesta correcta única'),
('9', '1', '¿En PHP, qué comprueba el operador `===`?', 'Igualdad', 'Asignación', 'Desigualdad', 'Comparación', 'a', 'short_answer', 'Respuesta correcta única'),
('10', '1', '¿Cuál de los siguientes se utiliza para crear un objeto en PHP?', 'new', 'objeto', 'crear', 'instancia', 'a', 'short_answer', 'Respuesta correcta única')