#############
# MYPROJECT #
#############

FROM ubuntu:14.04

MAINTAINER SYSRES

# Software Installation 
RUN apt-get update && apt-get install -y --force-yes apache2 php5 php5-mysql git curl redis-tools 

# Logstashforwarder Configuration 
ADD ./packages/logstash-forwarder_0.3.1_amd64.deb /tmp/
RUN dpkg -i /tmp/logstash-forwarder_0.3.1_amd64.deb
RUN rm -f /tmp/logstash-forwarder_0.3.1_amd64.deb
RUN mkdir -p /etc/logstash/ssl
ADD ./conf/logstash-forwarder /etc/logstash-forwarder
ADD ./conf/logstash-forwarder.crt /etc/logstash/ssl/
ADD ./conf/logstash-forwarder.init /etc/init.d/logstash-forwarder
RUN chmod u+x /etc/init.d/logstash-forwarder

# User creation
RUN useradd -M -s /bin/nologin -d /app/myproject -u 1001 -g www-data myproject

# Add source of the project
RUN mkdir -p /app/myproject/
ADD ./sources/ /app/myproject/
RUN chown -R myproject:www-data /app/myproject/
RUN chmod 775 /app/myproject/
RUN cd /app/myproject && curl -sS https://getcomposer.org/installer | php
RUN cd /app/myproject && php composer.phar install

# Using sample configurations
RUN mv /app/myproject/conf/common.sample.yml /app/myproject/conf/common.yml
RUN mv /app/myproject/conf/backend.sample.yml /app/myproject/conf/backend.yml
RUN mv /app/myproject/conf/propel/propel.sample.yml /app/myproject/conf/propel/propel.yml

#Apache Configuration
ADD ./conf/myproject.apache24.conf /etc/apache2/sites-available/myproject.conf
RUN a2ensite myproject
RUN a2enmod rewrite

# Disable default site
RUN a2dissite 000-default

# FS data creation
RUN mkdir -p /data/myproject
RUN chown -R myproject:www-data /data/myproject
RUN chmod 775 /data/myproject

# /etc/hosts management
ADD ./bin/* /usr/local/bin/
RUN chmod u+x /usr/local/bin/json-parser.bash /usr/local/bin/get-hosts.bash

# Add backend register
ADD ./bin/backend-register.bash /usr/local/backend-register.bash
RUN chmod u+x /usr/local/bin/backend-register.bash

# Init script
ADD ./conf/start.init /etc/init.d/start
RUN chmod u+x /etc/init.d/start

#EXPOSE 80 443

ENTRYPOINT ["/etc/init.d/start", "start"]
