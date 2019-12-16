#!/bin/bash -x

set -e

rm -rf layer
docker build -t geoip-layer .
CONTAINER=$(docker run -d geoip-layer false)
docker cp $CONTAINER:/opt layer
docker rm $CONTAINER
touch layer/.slsignore
cat > layer/.slsignore << EOF
**/*.a
**/*.la
share/**
include/**
bin/**
EOF
