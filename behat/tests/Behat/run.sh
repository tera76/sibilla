#!/usr/bin/env bash

set -e  # Fail on errors

rm -fr html_report


./vendor/bin/behat --format pretty --out std --format html --out html_report "$@"
