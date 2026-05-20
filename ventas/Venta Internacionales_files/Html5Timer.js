function Html5Timer () {

    function _constr() {
        // nothing to initialize
    }

    _constr.apply(this, arguments);

    this.createTimer = function (timerAction, intervalMs, actionName) {
        var timerId = setInterval(timerAction, intervalMs);
        var cancelTimerFunc = (function () {
            if (timerId !== -1) {
                clearInterval(timerId);
                timerId = -1;
            }
        });
        return cancelTimerFunc;
    };

    this.release = function() {
        // nothing to release
    };

}