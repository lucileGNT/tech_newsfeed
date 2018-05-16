# tech_newsfeed

Inspired by YCombinator's Hacker news : news.ycombinator.com

To install the project :

- Clone the project in your computer
- Create an empty database
- In your terminal, run <pre>Composer install</pre> at project root to install all the dependencies. It will also ask you to provide your server and database details
- Run <pre>php bin/console doctrine:migrations:migrate</pre> to create the tables in the database
- Run the server with <pre>php bin/console server:run</pre> and open your browser
- The project is ready!