#########
# PROXY #
#########

FROM ubuntu:14.04

MAINTAINER SYSRES

# Installation d'hipache
RUN apt-get update && apt-get install -y --force-yes npm curl
RUN	npm install hipache -g
ADD ./conf/hipache-json.conf /etc/hipache-json.conf
RUN mkdir -p /var/log/nginx/

# Configuration logstashforwarder
ADD ./packages/logstash-forwarder_0.3.1_amd64.deb /tmp/
RUN dpkg -i /tmp/logstash-forwarder_0.3.1_amd64.deb
RUN rm -f /tmp/logstash-forwarder_0.3.1_amd64.deb
RUN mkdir -p /etc/logstash/ssl
ADD ./conf/logstash-forwarder /etc/logstash-forwarder
ADD ./conf/logstash-forwarder.crt /etc/logstash/ssl/
ADD ./conf/logstash-forwarder.init /etc/init.d/logstash-forwarder
RUN chmod u+x /etc/init.d/logstash-forwarder


# Gestion  du /etc/hosts
ADD ./bin/* /usr/local/bin/
RUN chmod u+x /usr/local/bin/json-parser.bash /usr/local/bin/get-hosts.bash

# Copie du script de demarrage
ADD ./conf/start.init /etc/init.d/start
RUN chmod u+x /etc/init.d/start

EXPOSE 80 443

ENTRYPOINT ["/etc/init.d/start", "start"]
