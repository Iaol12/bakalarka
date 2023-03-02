

# SecMon User Guide
## Architecture

 - **Aggregator** -
 - **Normalizer** -
 - **Enrichment modules** -
   - **Geo IP** -
   - **Network model** -
 - **Correlator** -
 - **Database** -
 - **Database retention service** -
 - **SecMon app** -

## How to Install

Prerequisite for installing SecMon system is OS CentOS7/CentOS Stream 8/Ubuntu 22.04 (tested Linux distribution) with user ***secmon*** (under which we will deploy SecMon system), internet access and installed programs [Docker Engine](https://docs.docker.com/engine/install/) and [Docker Compose](https://docs.docker.com/compose/install/) v2.3.3. The functionality of the Docker Engine can be verified with the command `docker run hello-world`. Docker Compose functionality can be verified with `docker compose version`. If the commands do not run correctly, this problem must be resolved or the installation will not be successful.

### CentOS 7

```
# System Update
sudo yum clean all
sudo yum -y update

# Install git, firewall & rsyslog
sudo yum install -y git firewalld rsyslog

# Install python packages
sudo yum install -y https://repo.ius.io/ius-release-el7.rpm
sudo yum install -y python36u python36u-libs python36u-devel python36u-pip
sudo pip3.6 install -U configparser

# Setting up firewall
sudo firewall-cmd --permanent --add-port=8080/tcp
sudo firewall-cmd --permanent --add-port=443/tcp
sudo firewall-cmd --permanent --add-port=514/tcp
sudo firewall-cmd --reload

# Download SecMon repository
git clone https://github.com/Miropanak/dockerized_secmon.git secmon

# Start preconfig script
cd secmon
./secmon_preconfig.sh

# Start deploying process
python3 secmon_manager.py deploy

# Crete password for database user 'secmon' during installation

# Default login credentials user:secmon, password:password
# Change password after first login!!!
<host_machine_IP_address>:8080/secmon/web
```

### CentOS 8

```
# System Update
sudo yum clean all
sudo yum -y update

# Install git, firewall & rsyslog
sudo yum install -y git firewalld rsyslog

# Install python packages
sudo pip3.6 install -U configparser

# Setting up firewall
sudo firewall-cmd --permanent --add-port=8080/tcp
sudo firewall-cmd --permanent --add-port=443/tcp
sudo firewall-cmd --permanent --add-port=514/tcp
sudo firewall-cmd --reload

#Download SecMon repository
git clone https://github.com/Miropanak/dockerized_secmon.git secmon

# Start preconfig script
cd secmon
./secmon_preconfig.sh

# Start deploying process
python3 secmon_manager.py deploy

# Crete password for database user 'secmon' during installation

# Default login credentials user:secmon, password:password
# Change password after first login!!!
<host_machine_IP_address>:8080/secmon/web
```

### Ubuntu 22.04

```
# System Update
sudo apt clean all
sudo apt -y update

# Install git, firewall & rsyslog
sudo apt install -y git ufw rsyslog

# Install python packages
sudo apt-get install -y make build-essential libssl-dev zlib1g-dev \
libbz2-dev libreadline-dev libsqlite3-dev wget curl llvm libncurses5-dev \
libncursesw5-dev xz-utils tk-dev libffi-dev liblzma-dev \
libgdbm-dev libnss3-dev libedit-dev libc6-dev
wget https://www.python.org/ftp/python/3.6.15/Python-3.6.15.tgz
sudo tar -xzf Python-3.6.15.tgz
cd Python-3.6.15
sudo ./configure --enable-optimizations  -with-lto  --with-pydebug
sudo make altinstall

# Setting up firewall
sudo ufw allow 8080/tcp
sudo ufw allow 443/tcp
sudo ufw allow 514/tcp

# Download SecMon repository
git clone https://github.com/Miropanak/dockerized_secmon.git secmon

#Start preconfig script
cd secmon
./secmon_preconfig.sh

# Start deploying process
python3 secmon_manager.py deploy

# Crete password for database user 'secmon' during installation

# Default login credentials user:secmon, password:password
# Change password after first login!!!
<host_machine_IP_address>:8080/secmon/web
```

## How to Use
### SecMon Manager
SecMon manager (*secmon_manager.py*) is a python script  located in root directory of SecMon repository. It is used for managing SecMon system which consists from docker containers.
```
# Show list of all available parameters
python3 secmon_manager.py help

# Stop running SecMon system
python3 secmon_manager.py stop

# Start stopped SecMon system
python3 secmon_manager.py start

# Restart running/stopped SecMon system
python3 secmon_manager.py restart

# Deploy SecMon system on a host machine
python3 secmon_manager.py deploy
```
## Configuration
#### Turn on/off enrichment module
Set value `true` /`false` in the file `./config/secmon_config.ini` for a particular enrichment module which you want to turn on/off:
```
[ENRICHMENT]
geoip = true
network_model = true
```
Save your changes and restart the SecMon system with the command:
```
python3 secmon_manager.py restart
```
####  Turn on enrichment module
Change value from 'false' to 'true' in the file `./config/secmon_config.ini` for a particular enrichment module which you want to turn on: 
```
[ENRICHMENT]
geoip = false
network_model = false
```
Save your changes and restart the SecMon system with the command:
```
python3 secmon_manager.py restart
```
### Rsyslog client config
To redirect logs from client machine to the SecMon add the following line at the end of the `/etc/rsyslog.conf` file , where `192.168.1.100` is the IP address of the remote server (SecMon), you will be writing your logs to:
```
*.* @192.168.1.100:514
```
Save your changes and restart the rsyslog service on the client with the command:
 ```
 sudo systemctl restart rsyslog
 ```

## Development
### Directory structure
Yii framework
https://yii2-framework.readthedocs.io/en/latest/
https://www.yiiframework.com/doc/guide/2.0/en

### Docker commands
Run command inside container:
- `docker exec <container_name> <command>`
- `docker exec -it secmon_app ls`

Run bash inside container:
- `docker exec -it <container_name> bash`
- `docker exec -it secmon_app bash`

Run composer update/install:
- `docker exec secmon_app composer update`
- `docker exec secmon_app composer install`

[Database migrations:](https://www.yiiframework.com/doc/guide/2.0/en/db-migrations)
- `docker exec -it secmon_app <command>`

Run migration:
- `docker exec -it secmon_app ./yii migrate`

Refreshing migration:
- `docker exec -it secmon_app ./yii migrate/fresh`

Create new migration:
- `docker exec -it secmon_app ./yii migrate/create <name>`
- `docker exec -it secmon_app ./yii migrate/create security_events_table`

Run psql:
- `docker exec -it secmon_db psql -U secmon`

### Create own Enrichment modules
TODO

### Create own Rules
To create own normalization/correlation rules. TODO

### Debug
SecMon logs are located in file `/var/log/docker/secmon.log`
