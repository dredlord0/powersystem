#!/usr/bin/python

import RPi.GPIO as GPIO            # import RPi.GPIO module
from time import sleep             # lets us have a delay
import sys
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)             # choose BCM or BOARD

gpio=int(sys.argv[1])
gpio_status=int(sys.argv[2])

if GPIO.gpio_function(gpio)!='OUT':
    GPIO.setup(gpio, GPIO.OUT)           # set GPIO24 as an output 

if (gpio_status==1):
    GPIO.output(gpio,1)
else:
    GPIO.output(gpio,0)