#!/bin/bash

# Default API auth credentials
if [[ ${ADMIN_USER} -eq '' ]]; then
    ADMIN_USER=admin
fi

if [[ ${ADMIN_PASS} -eq '' ]]; then
    ADMIN_PASS=admin
fi

# Put the Node-Media-Server credentials where PHP will find them
echo -e "<?php\\n \$ADMIN_USER=${ADMIN_USER}\\n\$ADMIN_PASS=${ADMIN_PASS}\\n ?>" > /var/www/api_auth

# Start node-media-server
cd /nms/Node-Media-Server-2.1.4/ && node app.js &

# Start apache
apache2-foreground
