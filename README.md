Official Vegas CMF page.
======================

Check online version [here](http://vegas.amsterdamstandard.pl)

Requirements
------------
1. PHP >= 5.4

2. Phalcon extension
    The **Vegas CMF** based on the **Phalcon** framework (in version 1.3), which works as php extension.
    Check [http://docs.phalconphp.com/en/latest/reference/install.html](http://docs.phalconphp.com/en/latest/reference/install.html) for more information.

3. Mongo and **PHP mongo extension**

How to setup page
-----------------
1. After cloning repo you need to run **composer** from project root directory and install latest vendors.
    ```
    php composer.phar install
    ```
    **Problem?** If you have trouble with this step check [https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) for info how to install composer.

2. Create your **app/config/config.php** file, you can do it by copying and modifying **app/config/config.sample.php** file.
    ```
    cp app/config/config.sample.php app/config/config.php
    ```

3. Publish default forms and media assets by running this command:
    ```
    php cli/cli.php vegas:assets publish
    ```
    **Problem?** Some of files are already included in this project's public/assets directory so don't worry about *File already exists.* notices.

4. Create default user:
    ```
    php cli/cli.php app:user:user create -e=user@vegasdemo.com -p=pa55w0rd -n="Vegas User"
    ```

After those steps you can check project by starting local php server:
```
php -S 0.0.0.0:8080 -t public/ public/index.php
```
