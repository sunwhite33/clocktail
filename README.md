# clocktail 

clocktail is a lightweight, accurate to the second and compatible crontab program written in PHP


Server Requirements
------------

+ PHP>=7.1
+ composer>=2.0.2


Install
---------------

+ git clone https://github.com/sunwhite33/clocktail.git
+ composer install 


Run
------------------

+ edit /etc/clocktail.crontab
+ touch /var/log/clocktail.log
+ cd clocktail
+ php clocktail.php


Stop
------------------

+ kill -9 pid


compatible crontab format
-----------

    0   1   2   3   4   5
    |   |   |   |   |   |
    |   |   |   |   |   +------ day of week (0 - 6) (Sunday=0)
    |   |   |   |   +------ month (1 - 12)
    |   |   |   +-------- day of month (1 - 31)
    |   |   +---------- hour (0 - 23)
    |   +------------ min (0 - 59)
    +-------------- sec (0-59)
    [0 bit can be omitted, if there is no 0 bit, then the minimum time granularity is minutes]


Remark
------------------

+ You can check log information in the log file
+ Run clocktail program with nohup or & to daemon
