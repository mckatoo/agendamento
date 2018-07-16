docker run --name=agendamento -ti \
--link=mysql \
-v $(pwd)/html:/var/www/html \
-p 8888:80 \
ubuntu:18.04 \
/bin/bash

