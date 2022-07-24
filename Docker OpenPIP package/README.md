
# INSTALLATION GUIDE FOR OPEN-PIP : composePIP 
## Packager for openPIP

Required and tested on: *@ Docker version 20.10.7 and docker-compose version 1.29.2*

## STEPS:

***Prerequisites***
<br>
**STEP 1:** Install Docker Engine <br>
*Reference:* https://docs.docker.com/engine/install/ubuntu/ <br>
**STEP 2:** Install Docker compose <br>
*Reference:* https://docs.docker.com/compose/install/ <br>


***Source Code***
<br>
**STEP 3:** Clone OpenPIP repo from GitHub <br>
>git clone https://github.com/BaderLab/openPIP.git 

**STEP 4:** Inside OpenPIP folder run script `start.sh` <br>
>chmod 777 ./start.sh && ./start.sh

<br>

Hurray! :tada: :tada: The server is now running on <br>  

:rocket: [localhost:80](http://localhost:80/app.php)  :rocket: 

<br><br>
 
<br><br>
<br><br>
<br><br>
<br><br>




## TROUBLESHOOTING:


START.SH: 

  1. get superuser access: ```sudo su```
  2. run this command inside openPIP folder:

    ```
    cp -r ./Docker\ OpenPIP\ package/* ./../ && chown -R www-data:www-data app/cache && chown -R www-data:www-data app/logs && sudo chmod -R 777 web/uploads && cd .. && docker-compose build && docker-compose up
    ```
 (this may take few minutes)
 <br>

START.SH: populate database with `admin_settings` and `users` to establish connection.

  
    1. Exec into mysql container running:
        `docker exec -it <container_id> /bin/bash`
        
        ## MySQL container name can be found by running *docker ps* , and copying the container id.

    2. Login into db: 
        `mysql -uroot --password=secret`

    3. RUN Command: 
        `source /db/init_new.sql`
  



1.

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

2.

In Case `bootstrap.php.cache` is missing
Run:
  - composer run-script post-update-cmd
 
 Ref: https://stackoverflow.com/questions/6072081/symfony2-updating-bootstrap-php-cache 
 
====


3. If you are having trouble in deleting files from server: deletefilecontroller:

    make sure you have replaced '\' in path with '/', in ubuntu.


-------- 

