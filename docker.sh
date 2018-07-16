docker run --name=agendamento-dev -ti \
--link=mysql \
-v $(pwd)/html:/var/www/html \
-p 8001:80 \
ubuntu:18.04 \
bash
