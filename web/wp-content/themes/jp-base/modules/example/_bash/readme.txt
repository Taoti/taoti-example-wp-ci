I have set up a bash script that you can run in Terminal and auto-generate a new module for you.

Based on a filename and PHP Class name you enter, it will generate a folder with the base files needed for a module.


### STEP 1
To get this set up on your computer, make a folder called "bash" in your user directory.

    mkdir ~/bash

Copy/paste three files into that directory:
    - makemodule
    - template-module.php
    - template-module.twig


### STEP 2
In your user directory, if you don't already have a hidden file called .bash_profile, create it. If you already have this file, skip ahead to Step 3.

    touch ~/.bash_profile


### STEP 3
You might need to open .bash_profile with nano since it's a hidden file. (Or use vim if you're a masochist dev who don't need no friendly user experience).

    nano ~/.bash_profile


### STEP 4
Add the following to your .bash_profile file. Replace {YOUR USER NAME} with whatever your username directory is called. (I don't think using the ~ shortcut works here.)

    alias makemodule="/Users/{YOUR USER NAME}/bash/makemodule"

In nano, press Ctrl-X to exit (make sure to save the changes when prompted). If you're in vim, god help you.


### STEP 5
In a terminal, cd to the modules directory in your theme. Now run `makemodule` in the terminal, follow the prompts, and it will create the starting files for your module.



### NOTES
I set this up on OS X, so I assume it will work in Linux but the whole .bash_profile thing might be different there, YMMV.
