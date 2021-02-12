FROM php:7.3-apache-buster


# NodeJS and NPM
RUN apt-get -y update
RUN apt-get -y install nodejs wget
RUN curl -L https://npmjs.org/install.sh | sh

# Node-Media-Server
RUN mkdir /nms && cd /nms && npm install node-media-server
COPY app.js /nms/Node-Media-Server-2.1.4/app.js

# ffmpeg
RUN curl -o /nms/ffmpeg.tar.xz https://johnvansickle.com/ffmpeg/releases/ffmpeg-release-amd64-static.tar.xz && cd /nms && tar xvf ffmpeg.tar.xz && mv ffmpeg-4.3.1-amd64-static/ffmpeg /nms/ffmpeg

# Install website
COPY ./src/ /var/www/html
COPY streamers.php /var/www/
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Start container
EXPOSE 80 8000 1935
ENTRYPOINT "/entrypoint.sh"
