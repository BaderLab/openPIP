#!/bin/bash
sudo su << SuperUser
PATH=$PATH:/snap/bin
chown -R www-data:www-data app/logs &&\
sudo chmod -R 777 web/uploads &&\ 
cd .. &&\ 
docker-compose build &&\ 
docker-compose up
SuperUser
