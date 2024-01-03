#!/bin/bash

export PATH=$PATH:/snap/bin
chown -R www-data:www-data app/logs &&
	sudo chmod -R 777 web/uploads && \ 
cd ./'Docker OpenPIP package' && \ 
docker-compose build && \ 
docker-compose up
