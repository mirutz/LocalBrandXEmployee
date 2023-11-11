# LocalBrandXEmployee
Repo for the assessment task of LocalBrandX


#### Server installation
+ `composer install`
+ Create .env file: `cp .env .env.dev.local`
+ `php bin/console doctrine:database:create` -- this is only required
+ `php bin/console doctrine:migrations:migrate`
+ `symfony serve -d --port=9009`
+ API URL: `https://localhost:9527`


You can then proceed to import the given
[import.csv](https://t36654621.p.clickup-attachments.com/t36654621/cc240282-787a-4c10-9ee5-93e9f65f4128/import.csv)
file using cUrl, using the following command

`curl -X POST -H "Content-Type: text/csv" --data-binary @import.csv https://localhost:5005/api/employee --ssl-no-revoke`

The last argument is optional and depends on your server-settings, e.g. if you´re using http or https

Once the employee-data is successfully imported, you may 