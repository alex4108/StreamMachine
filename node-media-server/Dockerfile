FROM node:14-alpine

# Curl!
RUN apk add --update \
    curl \
    && rm -rf /var/cache/apk/*
    
# Node-Media-Server
RUN mkdir /nms && cd /nms && npm install node-media-server
COPY app.js /nms/Node-Media-Server-2.1.4/app.js

# ffmpeg
RUN curl -o /nms/ffmpeg.tar.xz https://johnvansickle.com/ffmpeg/releases/ffmpeg-release-amd64-static.tar.xz && cd /nms && tar xvf ffmpeg.tar.xz && mv ffmpeg-4.4-amd64-static/ffmpeg /nms/ffmpeg

# Entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Start container
EXPOSE 8000 1935
ENTRYPOINT "/entrypoint.sh"
