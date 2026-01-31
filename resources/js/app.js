import './bootstrap.js'
import 'bootstrap/dist/css/bootstrap.min.css'
// import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import '../css/custom.css'

import $ from 'jquery';
window.$ = window.jQuery = $;

document.addEventListener('DOMContentLoaded', async () => {

    // Capacitor exists ONLY inside mobile app
    if (window.Capacitor?.getPlatform?.() === 'android') {

        // Dynamically access plugin (no import!)
        const { StatusBar } = window.Capacitor.Plugins || {};

        if (StatusBar) {
            await StatusBar.setOverlaysWebView({ overlay: true });

            // SET STATUS BAR BACKGROUND COLOR
            await StatusBar.setBackgroundColor({
                color: '#00000072' // example: Bootstrap primary
            });

            // SET ICON COLOR (IMPORTANT)
            await StatusBar.setStyle({
                style: 'LIGHT' // LIGHT = white icons, DARK = dark icons
            });


            await SystemBars.setStyle({ style: SystemBarsStyle.Dark });

        }

        document.body.classList.add('android');
    }

});







