#!/bin/bash

# generating ssl key and certificate
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
-subj "/C=BR/ST=Rio Grande do Sul/L=Porto Alegre/O=UFRGS/OU=CPD/CN=tarsius.dev" \
-keyout nginx/certs/dev-app.key -out nginx/certs/dev-app.crt

# generating DH key
sudo openssl dhparam -out nginx/certs/dhparam.pem 2048