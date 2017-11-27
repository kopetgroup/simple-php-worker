#!/bin/bash
IP=`hostname -I`
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
echo $DIR;
php $DIR/run.php $IP
