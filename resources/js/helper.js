const loadScript = (url, callback) => {
    let script = document.createElement('script');
    script.src = url;
    script.async = true;
    script.onload = function() {
        console.log(`Script ${url} loaded`);
        callback();
    }
    script.onerror = function() {
        console.log(`Failed to load script ${url}`);
    }
    document.head.appendChild(script);
};

export default loadScript;