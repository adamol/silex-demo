#!/bin/bash

find src tests config db Framework utility '*.php' | xargs wc -l
