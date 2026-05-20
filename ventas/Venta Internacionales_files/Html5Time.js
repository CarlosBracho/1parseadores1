function Html5Time () {

    function _constr() {
        // nothing to initialize
    }

    _constr.apply(this, arguments);

    this.getEpochTimeMs = function () {
        var d = new Date();
        return d.getTime();
    };

    this.release = function() {
        // nothing to release
    };
}
