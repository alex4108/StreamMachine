#!/bin/bash

# Default API auth credentials
if [[ ${ADMIN_USER} -eq '' ]]; then
    ADMIN_USER=admin
fi

if [[ ${ADMIN_PASS} -eq '' ]]; then
    ADMIN_PASS=admin
fi

# Put the Node-Media-Server credentials where PHP will find them
echo -e "<?php\\n \$ADMIN_USER=\"${ADMIN_USER}\";\\n\$ADMIN_PASS=\"${ADMIN_PASS}\";\\n ?>" > /var/www/api_auth.php

# Start apache
apache2-foreground
