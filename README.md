# StreamMachine

[![Build Status](https://travis-ci.com/alex4108/StreamMachine.svg?branch=master)](https://travis-ci.com/alex4108/StreamMachine)
![Docker Pulls](https://img.shields.io/docker/pulls/alex4108/streammachine)
[![GitHub issues](https://img.shields.io/github/issues/alex4108/StreamMachine)](https://github.com/alex4108/StreamMachine/issues)
[![GitHub forks](https://img.shields.io/github/forks/alex4108/StreamMachine)](https://github.com/alex4108/StreamMachine/network)
[![GitHub stars](https://img.shields.io/github/stars/alex4108/StreamMachine)](https://github.com/alex4108/StreamMachine/stargazers)
[![GitHub license](https://img.shields.io/github/license/alex4108/StreamMachine)](https://github.com/alex4108/StreamMachine/blob/master/LICENSE)
![GitHub All Releases](https://img.shields.io/github/downloads/alex4108/StreamMachine/total)
![GitHub contributors](https://img.shields.io/github/contributors/alex4108/StreamMachine)
[![Discord](https://img.shields.io/discord/742969076623605830)](https://discord.gg/FpDjFEQ)



[![Join Us in Discord](https://user-images.githubusercontent.com/7796475/89976812-2628c080-dc2f-11ea-92a1-fe87b6a9cf92.jpg)](https://discord.gg/FpDjFEQ)

## Why is this here

* Stream higher quality than free tiers of popular streaming platforms (1080p, 4K, 8K?)
* Not subject to content guidelines of other streaming platforms


## Screenshots

![Screenshot_25](https://user-images.githubusercontent.com/7796475/89960557-f95fb380-dc04-11ea-9116-ed86e1c9ecd3.jpg)

![Screenshot_26](https://user-images.githubusercontent.com/7796475/89960585-0c728380-dc05-11ea-8821-6005163b3d12.jpg)

## Setup

### Before you start

* Stream Keys are your Unique ID used on the streaming server to identify your stream from another stream.  I usually set this to my username, eg alex4108

### The server (Website + Streaming Server)
1. Pull the container: `docker pull alex4108/streammachine:latest`
1. Run the container

`docker run -d -p 1935:1935 -p 8000:8000 -p 80:80 alex4108/streammachine:latest` 

##### Run Conatiner with non-default credentials

`docker run -e ADMIN_USER=otherAdmin -e ADMIN_PASS=aSecur3Password! -d -p 1935:1935 -p 8000:8000 -p 80:80 alex4108/streammachine:latest`

##### Run Container with a local config file

`docker run -d -p 1935:1935 -p 8000:8000 -p 80:80 -v /path/to/your/streamers.php:/var/www/streamers.php alex4108/streammachine:latest`

##### Start the container in one line

`docker pull alex4108/streammachine:latest && docker run -d -p 1935:1935 -p 8000:8000 -p 80:80 alex4108/streammachine:latest`

### Your client

1. Use [OBS](https://obsproject.com/) or similar stream software to publish a stream to the container at URL `rtmp://container_ip/live/` with any non empty stream key.
1. You should be able to see your stream in the "Online Streams" list in the left bar of the app

## What does it do

* Runs a [Node-Media-Server](https://github.com/illuspas/Node-Media-Server) who accepts RTMP streams.
* Runs a PHP app that connects to the Node-Media-Server API to determine online/offline status
* Features [Titan Embed]() to put a chat module on your stream's page for discord

## Configuration Guidelines

Configuration of the streamers.php file isn't required.  Streams will be accepted using any stream key, and will immediately show as Online in the webapp.

To enabled additional features, such as Discord join links, the Titan widget, or to list your key in the offline streams list, you must modify the streamers.php configuration file.

## Production Deployment Notes

* Restrict traffic on 1935 to authorized hosts only.  This way, unknown users cannot publish streams to the container.
* Terminate HTTPS at HAProxy and pass plaintext into the container.
* Use HAProxy for ports 80, 443, AND 8000.  
* In the HAProxy rules for 8000, restrict access to /admin/ and /api/.  This way, http://container:8000/admin/ and http:///container:8000/api/ are only accessible from the internal network and not to the outside world

_Maybe it's worth bringing HAProxy into the container as well_

# Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

# Known Issues

* Cross-Site cookies are forbidden by default in the browser.  This prevents the chat widget from loading.
* Video player may "bounce" in the browser.  This can be resolved by zooming out

# Support

[Join the Discord Server](https://discord.gg/FpDjFEQ)

# Credits

* [illuspas (Node-Media-Server)](https://github.com/illuspas/Node-Media-Server)
* [azouaoui-med (Pro-Sidebar-Template)](https://github.com/azouaoui-med/pro-sidebar-template)
* [video.js](https://github.com/videojs/video.js)

