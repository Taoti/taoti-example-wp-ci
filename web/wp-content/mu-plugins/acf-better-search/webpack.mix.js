const mix = require('laravel-mix');

mix.js([
  'resources/_dev/js/Core.js',
], 'public/build/js/scripts.js');

mix.sass(
  'resources/_dev/scss/Core.scss'
, 'public/build/css/styles.css');

/* ---
  Config
--- */
const fs     = require('fs');
const mqSort = require('sort-css-media-queries');

mix
  .disableSuccessNotifications()
  .setPublicPath('/')
  .babelConfig({
    'presets': [
      [
        '@babel/preset-env',
        {
          targets: JSON.parse(fs.readFileSync('./package.json')).browserslist
        },
      ]
    ]
  })
  mix.options({
    processCssUrls: false,
    postCss: [
      require('autoprefixer')({
        cascade: false,
      }),
      require('css-mqpacker')({
        sort: mqSort.desktopFirst,
      }),
    ],
  })
;

Mix.manifest.refresh = () => { void 0; };
