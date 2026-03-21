    
if [ -f /etc/apache2/mods-enabled/mpm_event.load ]; then
    a2dismod mpm_event
fi
if [ -f /etc/apache2/mods-enabled/mpm_worker.load ]; then
    a2dismod mpm_worker
fi

a2enmod mpm_prefork rewrite headers
exec apache2-foreground