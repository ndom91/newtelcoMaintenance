![Newtelco](./dist/images/newtelco_full_300w.png)  

[![newtelco](https://img.shields.io/badge/Version-0.8.0_beta-green.svg?style=flat-square)](https://crm.newtelco.de) 
[![Uptime Robot ratio (7 days)](https://img.shields.io/uptimerobot/ratio/7/m781781334-0112a59d100b992b0132080d.svg?style=flat-square&colorB=green&label=Uptime)](https://uptime.newtelco.de/) 
[![newtelco](https://img.shields.io/badge/Contact%20Me-%40-green.svg?style=flat-square)](mailto:ndomino@newtelco.de) 
[![PIPELINE](https://git.newtelco.dev/ndomino/maintenancedb/badges/master/pipeline.svg)](https://git.newtelco.dev/ndomino/maintenance)


#### Maintenance Web App
**Author**: [ndomino@newtelco.de](mailto:ndomino@newtelco.de)  
**URL**: [https://maintenance.newtelco.de](https://maintenance.newtelco.de)

### Intro

Newtelco Maintenance Web Application, designed and developed in-house, to replace Excel Tables + Emails back and forth.

### Screenshots  
<img src="https://maintenance.newtelco.de/dist/images/maintenanceScreenshot1.png" width="400" height="250">
<img src="https://maintenance.newtelco.de/dist/images/maintenanceScreenshot2.png" width="400" height="250">

### Requirements

1) G Suite Account @ newtelco.de  
2) MySQL/MariaDB  
3) PHP 7.0+ and webserver (i.e. nginx or apache)

> **Tested On**:

> - MariaDB 10.1.34  
> - PHP 7.1.25  
> - Apache 2.4.29

### Installation

1) Clone this repo  
> `git clone https://git.newtelco.de/ndomino/maintenancedb`

2) Run install.sh  
> `sudo ./install.sh`  

3) Create database  
> `sudo mysql -u[user] -p maintenancedb < configs/create_maintenanceDB.sql`  

4) Copy Apache Configs from configs/apache2 to your apache sites config (on Ubuntu located at `/etc/apache2/sites-enabled`)  
5) Restart Apache  
> systemd - `sudo systemctl restart apache2`  
> init.d - `sudo service apache2 restart`  

6) Enjoy!

--- 

### To Dos:

1) Generalize install.sh script  
2) Clean-up minor bugs  
3) Improve DB performance  
4) Double check serviceworker behavior
