CREATE TABLE `Quizz_app-Parte_4`.`Cuestionario` (
    `quiz_id` INT NOT NULL , 
    `title` VARCHAR(255) NOT NULL , 
    `description` TEXT NOT NULL , 
    `created_at` DATE NOT NULL , 
    PRIMARY KEY (`quiz_id`)
);

INSERT INTO `Cuestionario` (`quiz_id`, `title`, `description`, `created_at`) VALUES 
('1', 'Cuestionario 1', 'Examen de PHP Básico', '2024-01-22 08:40:00.000000'),
('2', 'Cuestionario 2', 'Examen de Desarrollo Web', '2024-01-22 09:00:00.000000')
