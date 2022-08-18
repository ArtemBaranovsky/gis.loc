Trips time Solution
===================

***Environment requirements***
- PHP 8.1
- Composer


Steps to check:
____
- Run:
  ```
   composer install 
  ```
  then:
  ```
   composer dump-autoload -o 
  ```
- Seed the database using script command:
  ```
   composer seed 
  ```
- Export the necessary data to csv to project's root folder using script command
  ```
   composer test 
  ```