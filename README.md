# StatsWebInterface
Little PHP+Javascript Interface to access my local MySQL database that collects sensor data from a
DHT11 Sensor attached to my Raspberry Pi. 

Two python scripts scheduled as a crontab collect Temperature, Humdity
as well as RTT to Google DNS, RAM usage and CPU temperature and log it into a database.

Originally started as a fun project to create a 'big database' which has 'lots of data' to
get some experience, it is now a local webserver with a nice web interface that displays
graphs and tables.

