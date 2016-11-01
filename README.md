# vaibhavpandeyvpz/silex-skeleton
Scaffolding for [silex/silex](http://silex.sensiolabs.org/) to kick-start creation of responsive administration panels.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f20cf80f-8fe5-4572-b276-bf5c70115ab1/mini.png)](https://insight.sensiolabs.com/projects/f20cf80f-8fe5-4572-b276-bf5c70115ab1) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vaibhavpandeyvpz/silex-skeleton/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/vaibhavpandeyvpz/silex-skeleton/?branch=master) [![Total Downloads](https://img.shields.io/packagist/dt/vaibhavpandeyvpz/silex-skeleton.svg?style=flat-square)](https://packagist.org/packages/vaibhavpandeyvpz/silex-skeleton) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md) 

Features
-------
- User authentication and management
- Role-based access control
- Email address confirmations
- Password reset via email
- Assets are built & minified using [Gulp](http://gulpjs.com/)
- Full MVC w/ [Doctrine](http://www.doctrine-project.org/projects/orm.html) ORM, [Twig](http://twig.sensiolabs.org/) templates
- Secure by default w/ CSRF protection
- Various caching systems for performance
- Source-code as per [PSR](http://www.php-fig.org/psr/) coding standards

Install
-------
```bash
# Install Node.js (if not already)
sudo apt-get install nodejs

# Install Bower & Gulp globally
sudo npm i -g bower gulp

# Create a new project in a folder named 'yourapp'
composer create-project vaibhavpandeyvpz/silex-skeleton:@dev yourapp

# Setup configuration in '.env' file
cd yourapp && nano .env

# Prepare database & create admin user
mysql -u 'db_username' -p 'db_name' < app/migrations/00000000000000_create_security_tables.sql
mysql -u 'db_username' -p 'db_name' < app/migrations/11111111111111_insert_admin_user.sql
```

Development
-------
For development, you can start a development server using [PHP](http://www.php.net/)'s built-in [server](http://php.net/manual/en/features.commandline.webserver.php) as follows:
```bash
php -S localhost:8080 -t public_html public_html/index_dev.php
```

Default **admin** username is ```admin@silex-skeleton.app``` and password is ```12345678```.

Deployment
-------
Set ```APP_ENV``` to ```production``` in ```.env``` file as follows to enable various caching systems:
```
APP_ENV=production
```

Minify static assets before deployment to server:
```
gulp build --production
```

On server, it is recommended to install a [SSL](https://www.ssls.com/) certificate and uncomment the following lines in ```public_html/.htaccess``` to enforce **https://** protocol and enable auto-redirect if accessed via **http://**:
```htaccess
RewriteCond %{HTTPS} off
RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
```

License
------
See [LICENSE.md](https://github.com/vaibhavpandeyvpz/silex-skeleton/blob/master/LICENSE.md) file.
