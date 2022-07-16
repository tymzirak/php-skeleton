# php-skeleton

**1. Server Setup**

- Install [MySQL](https://www.mysql.com/) (or any other DBMS you prefer)

- Install [Nginx](https://nginx.org/) or [Apache](https://httpd.apache.org/):

> Set your web server root directory to **/public**

- Install [PHP](https://www.php.net/)

---

**2. Database Setup**

- Change the values according to your database settings, in the **/app/Core/Database.php** file.

```
private string $username = "username";
private string $password = "password";
private string $dbms = "mysql";
```
