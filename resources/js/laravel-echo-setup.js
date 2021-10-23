

import Echo from "laravel-echo"

let host = window.location.hostname + ':6001';
window._ = require('lodash');
try {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: host,
        client: io,
        authEndpoint: '/api/broadcasting/auth'
    });
} catch (e) {
    console.log(e.toString());
    console.log("socket doesn\'t setup properly!")
}


/*
import Echo from 'laravel-echo';


window.Echo = new Echo({

    broadcaster: 'socket.io',

    host: window.location.hostname + ":" + window.laravel_echo_port

});
*/
