#!/bin/bash

find src tests config db Framework utility scripts '*.php' | xargs wc -l
