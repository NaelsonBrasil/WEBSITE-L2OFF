###################
 L2OFF DASHBOARD
###################


##### Linux Ubuntu #####
//apache2
<Directory /home/kabaite/www/>
	Options Indexes FollowSymLinks
	AllowOverride All               //none for all
	Require all granted
</Directory>
sudo service apache2 restart

##### Windows #####
Guide how install

- Microsoft -> ODBC Driver 13 for SQL Server x64
- Download SQLSRV53
- php_sqlsrv_72_ts_x86.dll // x86 case Xampp86bits
- Enable Named Pipes
- Open All Port 1433

SQL SERVER CONFIGURATION MANAGER
Enable TCP/IP and for web site online add TCP PORT = 1433. For offline not necessary add port;
###################
Command development
###################

- Truncate table xxx; reset auto_increment;
- sass --watch internal.scss:internal.css

###################
Protection
###################
- XSS active
- CSRF active


###################
Function Name Crypt
###################
- guard (unknown1000)

https://www.youtube.com/watch?v=QQGnaNuzQIM&feature=youtu.be
