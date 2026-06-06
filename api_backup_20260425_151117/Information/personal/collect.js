(function() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://api.ljgy123.top/api/v1/Information/personal/if', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    var data = {
        screen_resolution: screen.width + 'x' + screen.height,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        platform: navigator.platform,
        language: navigator.language,
        cookies_enabled: navigator.cookieEnabled,
        do_not_track: navigator.doNotTrack
    };
    xhr.send(JSON.stringify(data));
})();
