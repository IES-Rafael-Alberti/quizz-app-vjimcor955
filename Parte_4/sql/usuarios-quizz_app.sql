CREATE TABLE `Quizz_app-Parte_4`.`User` (
  `user_id` INT NOT NULL,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255),
  PRIMARY KEY (`user_id`)
);

-- INSERT INTO `User` (`user_id`, `username`, `password`, `email`) VALUES 
-- ('1', 'User 1', 'password1', 'user1@gmail.com'),
-- ('2', 'User 2', 'password2', 'user2@gmail.com')
