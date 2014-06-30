Refencrence:

http://www.cs.wcupa.edu/~rkline/php/redbean-orm.html

Support for MySQL and SQLite

RedBean uses the PDO API for MySQL and SQLite. For most UNIX-based systems, the MySQL PDO API will be installed automatically when Php/MySQL support is installed. For the Windows installation, you will need this setting in the Php init file:

extension=php_pdo_mysql.dll

PDO SQLite support is also common in UNIX systems, but may need to be installed separately. For example, in Ubuntu Linux, install the package:

php5-sqlite

In Windows, you will need this setting in the init file:

extension=php_pdo_sqlite.dll
