
# Network Maintenance Web App

<img align="right" src="https://github.com/ndom91/NewtelcoMaintenance/raw/master/public/dist/images/newtelco_full_300w.png">

[![newtelco](https://img.shields.io/badge/Version-1.0.3-brightgreen.svg?style=flat-square)](https://crm.newtelco.de) 
[![Uptime Robot ratio (7 days)](https://img.shields.io/uptimerobot/ratio/7/m781781334-0112a59d100b992b0132080d.svg?style=flat-square&colorB=brightgreen&label=Uptime)](https://uptime.newtelco.de/) 
[![newtelco](https://img.shields.io/badge/Contact%20Me-%40-brightgreen.svg?style=flat-square)](mailto:ndomino@newtelco.de) 
[![PIPELINE](https://git.newtelco.dev/ndomino/maintenancedb/badges/master/pipeline.svg?style=flat-square)](https://git.newtelco.dev/ndomino/maintenance)


👨 [`ndomino@newtelco.de`](mailto:ndomino@newtelco.de)  
🌍 [`maintenance.newtelco.de`](https://maintenance.newtelco.de)

Newtelco Maintenance Web Application, designed and developed in-house, to replace Excel Tables + Emails back and forth in order to track incoming network circuit maintenance and inform our customers of effected circuits of theirs.

### 🏗️ Requirements

- [x] G Suite Account @ newtelco.de  
- [x] MySQL Database
- [x] PHP 7.0+
- [x] Webserver

> **Tested On**:
>  
> - Ubuntu 18.04.01 and CentOS 6
> - MariaDB 10.1.34 and 10.1.38 and 10.3
> - PHP 7.1.25 + 7.2.16
> - Apache 2.4.29 + 2.4.39

### 👷 Installation

If you're internal to Newtelco, push anything to the repo at our internal Gitlab and just let the Gitlab Pipeline install it to our production web server. 

If you've stumbled upon this repo and want to check it out, simply: 

**1)** Clone this repo  
> `git clone https://git.newtelco.de/ndomino/maintenancedb`

**2)** Run `install.sh` as root 

**3)** Create database  
> `sudo mysql -u[user] -p maintenancedb < configs/create_maintenanceDB.sql`  

**4)** Copy Apache Configs from configs/apache2 to your apache sites config (on Ubuntu located at `/etc/apache2/sites-enabled`)  
**5)** Restart Apache  
> systemd - `sudo systemctl restart apache2`  
> init.d - `sudo service apache2 restart`  

**6)** Enjoy, and please push back upstream any improvements :)


### 📺 Screenshots  

<img src="http://i.imgur.com/1x7gBWw.png" width="860" height="436">  
<img src="http://i.imgur.com/oZUba6i.png" width="860" height="436">  
<img src="http://i.imgur.com/davu6Pv.png" width="860" height="436">

---

#### 📝 License: [`MIT`](https://github.com/ndom91/NewtelcoMaintenance/blob/master/LICENSE)
