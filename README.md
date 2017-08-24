# Setup instructions

* Install composer (https://getcomposer.org/download/)
  * Composer requires PHP (http://windows.php.net/download)
* Run `composer install` from `src` dir
* Create `src/.env` w/ credentials from `docker-compose.yml`
  * Import an SQL dump  to fill the DB (not versioned)
* Install Docker on your local machine (https://docs.docker.com/engine/installation/)
* Make sure to **mount** the drive the project is on under `Settings -> Shared Drives`
  * If you update Docker, you need to re-mount
* Run `docker-compose up` **_using PowerShell_** to run the dev containers
* Go to localhost:8080

## Tips
* When making adjustments to docker-compose.yml / Dockerfile, run `docker-compose up --build`
* To remove a container (e.g. to update host mappings), run `docker-compose rm *image*`
* Remove all (also running) containers: `docker rm -f $(docker ps -a -q)`
* Remove all images: `docker rmi -f $(docker images -q)`
* Remove all volumes (persistent storage): `docker volume rm $(docker volume ls -q)`  

  
## DB schema
Schema only (no data) resides in `src/database/eaziup.sql`.  
If schema changes, replace the SQL file.