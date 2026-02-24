CREATE DATABASE IF NOT EXISTS `exercise2`;
CREATE DATABASE IF NOT EXISTS `exercise2prod`;

# Optional: create a user and grant privileges for the new databases
CREATE USER 'exercise2'@'%' IDENTIFIED BY 'exercise2password';
CREATE USER 'exercise2prod'@'%' IDENTIFIED BY 'exercise2prodpassword';
GRANT ALL PRIVILEGES ON `exercise2`.* TO 'exercise2'@'%';
GRANT ALL PRIVILEGES ON `exercise2prod`.* TO 'exercise2prod'@'%';
FLUSH PRIVILEGES;