# Disclaimer

This project was carried out as part of the Internet Technologies course in Computer Engineering at the Polytechnic Institute of Leiria.

**Any information provided within this project is fictitious.**

# About This Project

The aim of the project is to **create a virtual scenario with the integration of sensors, actuators and controllers capable of communicating in real time with a web server**, allowing information to be made available at any time and in any place, in other words, a prototype Internet of Things (IoT) solution using Cisco Packet Tracer (CPT) software.

Based on the objective outlined, the central theme of this project is "**Warehouse Management for an Online Technology Sales Company**".

The prototype developed demonstrates the viability and functionality of an integrated IoT solution capable of providing real-time interaction between physical devices and a web server. 

The use of Cisco Packet Tracer as a simulation platform made it possible to create a realistic virtual environment to test and validate the proposed solution.

The web server and API components were implemented using the Laravel framework, providing a solid and reliable basis for interaction with the system. Alternatively, for the presentation of the software, it was decided to develop a program in Python, offering a versatile and efficient approach to simulating a company's support tools.

The primary focus of this project is not on creating a perfect layout using CSS, nor on the security of the API endpoints or the web server, but on **effective integration and communication between various platforms with the API**.

This project **serves as a basis for future stages of development and implementation of IoT solutions in real environments**, providing valuable insights for the advancement of technology and its practical application in various sectors.
# Architecture

The prototype developed consists of a virtual IoT network made up of sensing, actuation and control devices. These devices are connected to a web server via a virtual local area network, simulated in Cisco Packet Tracer.

Features Provided:

- **Actuation Capability**
    - The actuators integrated into the prototype are capable of receiving commands from the web server and carrying out corresponding actions in the virtual environment.
- **Sensing Capability**
	- The sensors implemented in the prototype collect data from the environment or from specific devices and transmit it to the web server in real time.
- **Real-time Transmission and Availability Capability**
	- Communication between the devices and the web server is continuous and in real time, guaranteeing that the information is constantly updated.
- **Availability of Information Anytime & Anywhere**
	- The web server makes the information collected by the IoT devices available at any time and from anywhere, allowing remote access via a web interface.
- **Ability to Define and Send Events**
	- Through both software and hardware, it is possible to define events that trigger specific actions on IoT devices, and these events are sent to and processed by the web server.

The web server has 3 types of privileges:

- **Client** - processes product purchases fictitiously and accesses his own cart
- **Administrator** - maintains the company's products
- **Warehouse Administrator** - maintains the IoT devices in the warehouse

# Softwares Requeriments

This project used the following softwares:

- **Laravel** - An open-source web application framework written in PHP. It provides a structure for developing robust and secure web applications.
- **DataBase** - Laravel supports various database management systems like MySQL, PostgreSQL, SQLite, and SQL Server.
	- This project used **mysql database format** for development
- **Cisco Packet Tracer** - Network simulation tool used to design, configure and experiment with virtual networks in an educational environment.
- **Python** - High-level, interpreted scripting, imperative, object-oriented, functional, dynamically typed and strong programming language
- For dependencies **npm** - The default package manager for the JavaScript ecosystem. It is used to install and manage project dependencies.

**Optional Softwares**

- **Postman** - A collaboration tool for API development. It is used to test the application's endpoints.
- **Laragon** - A local development environment that includes Apache, PHP, MySQL, and other essential tools for web developers. It is a recommended option for web application development on Windows.

# How to run Project

Laravel Folder

```bash
# Dont forget to rename .env.example file to .env and configure it
# Inside the LaravelAPI folder (first time)
composer install
php artisan key:generate
php artisan migrate:fresh
php artisan db:seed
php artisan storage:link
npm install
npm run build

# When not using Laragon - Run Server
php artisan serve
```

## Caution

With the url of web server (laravel application) replace "**server_url**" in the following files:
- Cisco Environment
	- **In all microcontrollers** - at the beginning, in the programming tab
- Python Scripts
	- **In all files** - at the beginning of each script
