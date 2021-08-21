# compose_PIP
packager for openPIP

***@** Docker version 20.10.7, build f0df350*

***&** docker-compose version 1.29.2, build 5becea4c*

----------- SUMMARY


1. get superuser access: ```sudo su```
2. run this command inside openPIP folder:

```
cp -r ./Docker\ OpenPIP\ package/* ./../ && chown -R www-data:www-data app/cache && chown -R www-data:www-data app/logs && sudo chmod -R 777 web/uploads && cd .. && docker-compose build && docker-compose up
```



----------- EXPLANATION
1.
Exec into mysql container running: `docker exec -it <container_name> /bin/bash`

then, login into db: `mysql -uroot --password=secret`

then, RUN: source `/db/init_new.sql`

====

2.
In Case if this error occurs:
`RuntimeException: Unable to create the cache directory`
Run:
  - chown -R www-data:www-data app/cache
  - chown -R www-data:www-data app/logs
  - sudo chmod -R 777 web/uploads
 
 Ref: https://stackoverflow.com/questions/20127884/runtimeexception-unable-to-create-the-cache-directory-var-www-sonata-app-cach
 and,
 https://askubuntu.com/questions/768791/how-to-remove-files-with-no-permission

====

3.
In Case `bootstrap.php.cache` is missing
Run:
  - composer run-script post-update-cmd
 
 Ref: https://stackoverflow.com/questions/6072081/symfony2-updating-bootstrap-php-cache 
 
====

4. If you are having trouble in deleting files from server: deletefilecontroller:
    make sure you have replaced '\' in path with '/', in ubuntu.


--------

