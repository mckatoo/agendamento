docker run --name=agendamento-dev -ti \
-v $(pwd)/html:/var/www/html \
-p 3306:3306 \
-p 8001:80 \
ubuntu:18.04 \
bash
