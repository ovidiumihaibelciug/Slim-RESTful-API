#RESTful API
This is a RESTful api built with SlimPHP and Mysql(for storage).

##Instalation
Import db from _sql

Edit src/config/db.php parameters

Install SlimPHP and dependencies

       $ composer
       
ENDPOINTS

    $ GET    public/api/customers
    $ GET    public/api/customer/{id}
    $ POST   public/api/customer/add
    $ POST   public/api/customer/update/{id}
    $ DELETE public/api/customer/delete/{id}