#!/bin/bash

chown -R www-data:www-data app/logs &&\
sudo chmod -R 777 web/uploads 
docker-compose build &&\ 
docker-compose up