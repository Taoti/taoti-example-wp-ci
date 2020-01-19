/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

// console.log('inside theme customizer script');



// 404 Page Title
wp.customize('jp_404_page_title', function (value) {
    value.bind(function (newval) {
        var tagline = document.querySelectorAll('.js-customizer-404Title');

        if (tagline.length) {
            tagline[0].innerHTML = newval;
        }

    });
});

// 404 Page Content
wp.customize('jp_404_content', function (value) {
    value.bind(function (newval) {
        var tagline = document.querySelectorAll('.js-customizer-404Content');

        if (tagline.length) {
            tagline[0].innerHTML = newval;
        }

    });
});
