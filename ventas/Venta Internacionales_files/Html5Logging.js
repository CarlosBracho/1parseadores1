function Html5Logging () {

    function _constr () {
        // nothing to initialize
    }

    _constr.apply(this, arguments);

    this.consoleLog = function (message, logLevel) {
        if (typeof console === 'undefined') return;
        if (console.log && logLevel === Conviva.SystemSettings.LogLevel.DEBUG ||
            logLevel === Conviva.SystemSettings.LogLevel.INFO) {
            console.log(message);
        } else if (console.warn && logLevel === Conviva.SystemSettings.LogLevel.WARNING) {
            console.warn(message);
        } else if (console.error && logLevel === Conviva.SystemSettings.LogLevel.ERROR) {
            console.error(message);
        }
    };

    this.release = function () {
        // nothing to release
    };

}

