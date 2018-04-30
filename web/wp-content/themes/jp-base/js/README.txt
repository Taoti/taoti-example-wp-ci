### How We Organize .js files (with Gulp) ###

Gulp will concatenate all JS files within the js/development/ folder and within the modules/ folder. The concatenation creates two files: scripts.js and scripts.min.js

The minified file is the only one used in practice, but the non-minified one is there for reference.

The order in which the JS files are concatenated is as follows:
    1. Every JS file within the js/development/before-libs/ folder.
    2. Every JS file within the js/development/libs/ folder.
    3. Every JS file within the js/development/after-libs/ folder.
    4. Every JS file within the modules/ folder (searches through sub-folders).

In this way, you can set up any JS that needs to happen before libraries are loaded (like configs). Then it after it loads the libraries, you can set up JS that is dependent on those libraries.
