import './bootstrap.js'
import 'bootstrap/dist/css/bootstrap.min.css'
// import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import '../css/custom.css'

import $ from 'jquery';
window.$ = window.jQuery = $;

document.addEventListener('DOMContentLoaded', async () => {

    // ✅ Reliable Capacitor detection
    if (!window.Capacitor || !window.Capacitor.isNativePlatform()) {
        console.log('Not running inside Capacitor');
        return;
    }

    console.log('Running inside Capacitor');

    const Plugins = window.Capacitor.Plugins || {};
    const StatusBar = Plugins.StatusBar;
    const Network = Plugins.Network;

    /* -------------------------------
     * STATUS BAR
     * ------------------------------- */
    if (StatusBar) {
        await StatusBar.setOverlaysWebView({ overlay: false });

        await StatusBar.setBackgroundColor({
            color: '#00000072'
        });

        await StatusBar.setStyle({
            style: 'LIGHT'
        });

        console.log('StatusBar configured');
    } else {
        console.warn('StatusBar plugin not found');
    }

    /* -------------------------------
     * NETWORK
     * ------------------------------- */
    // if (Network) {
    //     const status = await Network.getStatus();
    //     console.log('Initial network status:', status);
    //     alert('Connected: ' + status.connected);
    //
    //     Network.addListener('networkStatusChange', status => {
    //         console.log('Network changed:', status);
    //         alert('Connected: ' + status.connected);
    //     });
    // } else {
    //     console.warn('Network plugin not found');
    // }

    document.body.classList.add('android');
});








