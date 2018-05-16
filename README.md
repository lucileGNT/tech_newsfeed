# tech_newsfeed

Inspired by YCombinator's Hacker news : news.ycombinator.com

To install the project :

- Checkout the project in your computer
- Edit the parameters.yml values with your own local server values.
- Create an empty database
- Edit the parameters.yml database name and credentials
- In your terminal, run <pre>Composer install</pre> to install all the dependencies
- Run <pre>php bin/console doctrine:migrations:migrate</pre> to create the tables in the database
- Run the server with <pre>php bin/console server:run</pre> and open your browser
- The project is ready!