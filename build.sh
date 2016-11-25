#!/usr/bin/env bash

# SQWEB - PHP SDK - RELEASE BUILDER
# ------------------------------------------------------------------------------
# This script simply zip all the required files for distribution.

BUILD=build/sqweb-sdk-php

# Create destination folder
mkdir -p $BUILD

# Copy source files
cp -R src/ $BUILD/src/

# Copy Documentation
cp README.md CHANGELOG.md $BUILD

# Zipping the build
pushd build; zip -r -X sqweb-sdk-php.zip sqweb-sdk-php; popd

# Cleaning up the build files
rm -rf $BUILD/*
