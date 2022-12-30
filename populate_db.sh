#!/bin/bash
touch docker.txt
docker ps >> docker.txt
#cat docker.txt
input="docker.txt"
while IFS= read -r line
do
  #echo "$line"
  b=${line:0:12}
  #echo "$b"
  #string='mysql:8.0.0'
  if [[ $line == *"mysql:8.0.0"* ]]; then
  echo "$b";break
  fi
done < "$input"
rm docker.txt
docker exec -i $b /bin/bash << DockerContainer
mysqladmin -uroot --password=secret flush-tables
mysql -uroot --password=secret <<SQL
#SHOW DATABASES;
#sudo mysqladmin flush-tables;
DROP TABLE IF EXISTS admin_settings
source /db/init_new.sql;
SQL
#echo "Adidev"
DockerContainer
