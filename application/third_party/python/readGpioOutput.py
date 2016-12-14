#!/usr/bin/python

import RPi.GPIO as GPIO            # import RPi.GPIO module
from time import sleep             # lets us have a delay
import sys

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)             # choose BCM or BOARD

gpio=int(sys.argv[1])

if GPIO.gpio_function(gpio)!='OUT':
    GPIO.setup(gpio, GPIO.OUT)

print GPIO.input(gpio)