# Setup instructions

* Install PHP and extensions:
  * `sudo add-apt-repository ppa:ondrej/php`
  * `sudo apt-get update`
  * `sudo apt install php7.2-cli`
  * `sudo apt install php7.2-mbstring php7.2-dom`
* Install composer `sudo apt install composer`
* Run `composer install` from `src` dir
* Run `chmod 777 src/storage/logs` from root dir
* Install Docker `sudo apt install docker.io`
* Install Docker Compose:
  * ``sudo curl -L https://github.com/docker/compose/releases/download/1.18.0/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose``
  * `sudo chmod +x /usr/local/bin/docker-compose`
* Run the containers from root dir:
  * Windows: `docker-compose up` **_using PowerShell_** 
  * Linux: `sudo docker-compose up`
* Create `src/.env` w/ credentials from `docker-compose.yml`
  * Import an SQL dump  to fill the DB
* Go to localhost:8080

## Tips
* Docker on Windows: make sure to **mount** the drive the project is on under `Settings > Shared Drives`.  
If you update Docker, you need to re-mount
* When making adjustments to docker-compose.yml / Dockerfile, run `docker-compose up --build`
* To remove a container (e.g. to update host mappings), run `docker-compose rm *image*`
* Remove all (also running) containers: `docker rm -f $(docker ps -a -q)`
* Remove all images: `docker rmi -f $(docker images -q)`
* Remove all volumes (persistent storage): `docker volume rm $(docker volume ls -q)`  

## DB schema
Schema only (no data) resides in `src/database/eaziup.sql`  
If schema changes, replace the SQL file.  

How to export schema?  
* In HeidiSQL, right click DB > "Export database as SQL", in the UI do the following:
  * Databases(s): check only "Create"
  * Table(s): check only "Create"
  * Data: select "No data"
  * Options: check "Remove AUTO_INCREMENT clauses"
  * Find the SQL file under source control, replace it
* Check Git diff to see that wanted changes were added
* Commit!


## DB connection from host
Port may not be 3306, check `docker-compose.yml > mysql > ports`

## Error logging
The app error log is at `src/storage/logs/lumen.log`