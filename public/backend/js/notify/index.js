"use strict";
// var notify = $.notify('<i class="fa fa-bell-o"></i><strong>Loading</strong> page Do not close this page...', {
//     type: 'theme',
//     allow_dismiss: true,
//     delay: 2000,
//     showProgressbar: true,
//     timer: 300,
//     animate:{
//         enter:'animated fadeInDown',
//         exit:'animated fadeOutUp'
//     }
// });

// setTimeout(function() {
//     notify.update('message', '<i class="fa fa-bell-o"></i><strong>Loading</strong> Inner Data.');
// }, 1000);

    // Check for session notification
    if (typeof notifyMessage !== 'undefined' && notifyMessage) {
        $.notify('<i class="fa fa-check"></i><strong>' + notifyMessage + '</strong>', {
            type: 'theme',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: true,
            timer: 300,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
        });
    }
    if (typeof notifyMessageWarning !== 'undefined' && notifyMessageWarning) {
        $.notify('<i class="fa fa-warning"></i><strong>' + notifyMessageWarning + '</strong>', {
            type: 'theme',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: true,
            timer: 300,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            }
        });
    }

