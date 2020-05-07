# StatsWebInterface
Little PHP+Javascript Interface to access my local MySQL database that collects sensor data from a
DHT11 Sensor attached to my Raspberry Pi. 

Two python scripts scheduled as a crontab collect Temperature, Humdity
as well as RTT to Google DNS, RAM usage and CPU temperature and log it into a database.

Originally started as a fun project to create a _big database_ which has _lots of data_ to
get some experience, it is now a local webserver with a nice web interface that displays
graphs and tables.

It only uses some minor JQuery to deal with the async requests. In the future it should be ported to a more
readable javascript style.
