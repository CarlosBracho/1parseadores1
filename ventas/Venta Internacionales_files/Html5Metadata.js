function Html5Metadata () {

    function _constr() {
        // nothing to initialize
    }

    _constr.apply(this, arguments);

    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getBrowserName = function () {
        return null;
    };

    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getBrowserVersion = function () {
        return null;
    };

    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getDeviceBrand = function () {
        return null;
    };

    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getDeviceManufacturer = function () {
        return null;
    };
    
    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getDeviceModel = function () {
        return null;
    };

    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getDeviceType = function () {
        return null;
    };

    // There is no value we can access that qualifies as the device version.
    this.getDeviceVersion = function () {
        return null;
    };

    // HTML5 can qualify as an application framework of sorts.
    this.getFrameworkName = function () {
        return "HTML5";
    };

    // No convenient way to detect HTML5 version.
    this.getFrameworkVersion = function () {
        return null;
    };

    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getOperatingSystemName = function () {
        return null;
    };

    // Relying on HTTP user agent string parsing on the Conviva Platform.
    this.getOperatingSystemVersion = function () {
        return null;
    };

    this.release = function() {
        // nothing to release
    };

}

