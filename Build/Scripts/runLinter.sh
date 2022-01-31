#!/bin/bash

composer run-script ci:sniff
composer run-script ci:phpstan
