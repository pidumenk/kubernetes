FROM rockylinux:8

LABEL \ 
description="This is a base image for tests in Kubernetes clusters" \
author="Pavel Dumenko" \
email="pashadumenko35738@gmail.com"

RUN yum -y update && \
yum -y install nginx php php-fpm && \
yum -y -q clean all && rm -rf /var/cache/*

# If you add a custom CMD in the Dockerfile, be sure to include -g daemon off; in the CMD in order for nginx to stay in the foreground, so that Docker can track the process properly (otherwise your container will stop immediately after starting)!
# Create directory for php-fpm, otherwise it won't be running.
RUN echo "daemon off;" >> /etc/nginx/nginx.conf && mkdir /run/php-fpm 

COPY ./assets/* /usr/share/nginx/html/

# Set a proper timezone (tzdata is already installed in the image)
ENV TZ=Europe/Berlin

EXPOSE 80
 
# If comment 14th line, it also can be running like CMD ["sh", "-c", "/usr/sbin/php-fpm -D; nginx -g 'daemon off;'"]
# This JSON form is similar to use shell command php-fpm -D; nginx
CMD ["sh", "-c", "php-fpm -D; nginx"]
