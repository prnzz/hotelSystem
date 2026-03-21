#!/bin/bash
set -e

# Clear any old PID files that might cause restart loops
rm -f /var/run/apache2/apache2.pid

# Start apache
exec apache2-foreground