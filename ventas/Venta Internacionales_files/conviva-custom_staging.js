(function(exports){
	"use strict";
	
	function ConvivaMonitor(){
		
		var _s = this;
		_s.sessionKey =null;
		_s.client = null;
		_s.config = null;
		_s.streammbr = null;
		var TEST_CUSTOMER_KEY = "3192a4cdc304b5f4acf2c95fb28e131eaf3521df";
		var TOUCHSTONE_SERVICE_URL = "https://robertscommunicationsnetwork.testonly.conviva.com";
		//var url = 'rtmp://nap7fmsorigin01.rcnstream.com/live?' + '<?php echo $stream; ?>' + '_fm_' + '1308' + '?cust=RCN&type=live&user=&cdn=LLNW&streammbr=' + '<?php echo $stream."_mbr"; ?>';
		var live = true;
		var bitrateKbps = 0; // Default Bitrate in Kbps
		var applicationName = "H2Live Player";
		var viewerId = "0000";
		var duration = 0; //Duration in seconds
		var resource = "RCNCDN";
		var encodedFrameRate = 20; // Encoded Framerate in fps

		var systemSettings = new Conviva.SystemSettings();
		
		this.init = function(config, streammbr, apiretobj, isHLS, bitrate, rcnmonitorinstance){
			_s.config = config;
			_s.streammbr = streammbr;
			_s.isHLS	= isHLS;
			var systemInterface = new Conviva.SystemInterface(
				new Html5Time(),
				new Html5Timer(),
				new Html5Http(),
				new Html5Storage(),
				new Html5Metadata(),
				new Html5Logging()
			);
			if(_s.client == undefined || _s.client == null){
				var systemFactory = new Conviva.SystemFactory(systemInterface, systemSettings);
				console.log("--------------------------- initialize Client");
				//set gatewayUrl only during testing/integration phase
				var clientSettings = new Conviva.ClientSettings(TEST_CUSTOMER_KEY);
				//clientSettings.gatewayUrl = TOUCHSTONE_SERVICE_URL;
				_s.client = new Conviva.Client(clientSettings, systemFactory);
				//_s.playerStateManager = _s.client.getPlayerStateManager();
				//_s.config.playerStateManager = _s.client.getPlayerStateManager();
				//debugger;
			}
			_s.playerStateManager = _s.client.getPlayerStateManager();
			//debugger;
			

			//console.log(typeof  new NanostreamPlayerInterface(playerStateManager, config));
			//debugger;
			if(_s.isHLS){
				var videoelement = _s.config;
				//debugger;
				_s.playerStateManager.setBitrateKbps(2200);
				Html5PlayerInterface(_s.playerStateManager, videoelement.getVideoElement());
			}else{
				NanostreamPlayerInterface(_s.playerStateManager, _s.config, rcnmonitorinstance, this);
			}
			
			//playerstateManager.setClientMeasureInterface(/* Instance of ClientMeasureInterface */);
			//alert('eaea');
			//Create metadata
			_s.contentMetadata = new Conviva.ContentMetadata();
			_s.contentMetadata.assetName = _s.streammbr;
			//_s.contentMetadata.streamUrl = apiretobj.rtmp_url + '/' + apiretobj.rtmp_streamname;
			_s.contentMetadata.streamUrl = apiretobj.wss_url +  '/?' + apiretobj.rtmp_url + '/' + apiretobj.rtmp_streamname;
			_s.contentMetadata.streamType = live ? Conviva.ContentMetadata.StreamType.LIVE : Conviva.ContentMetadata.StreamType.VOD;
			_s.contentMetadata.defaultBitrateKbps = bitrateKbps; // in Kbps
			_s.contentMetadata.applicationName = applicationName;
			_s.contentMetadata.viewerId = apiretobj.userid;
			_s.contentMetadata.duration = duration;
			_s.contentMetadata.defaultResource = resource;
			_s.contentMetadata.encodedFrameRate = encodedFrameRate;
			_s.contentMetadata.custom = {"cust" : apiretobj.cust, "platform" : apiretobj.platform, streamtype: "live", playerplatform: "h2live"};

			// Create a Conviva monitoring session.
			//_s.sessionKey = _s.client.createSession(_s.contentMetadata);
			//console.log(_s.sessionKey);
			
			// sessionKey was obtained as shown above
			//_s.client.attachPlayer(_s.sessionKey, _s.playerStateManager);
		}.bind(this);
		
		this.attachSession = function(){
			//console.log('session attached');
			//_s.client.releasePlayerStateManager(_s.playerStateManager);
			//debugger;
			_s.sessionKey = _s.client.createSession(_s.contentMetadata);
			console.log("SESSION KEY IS " + _s.sessionKey);
			//debugger;
			_s.client.attachPlayer(_s.sessionKey, _s.playerStateManager);
		}
		
		this.reportError = function(errorType, message){
			if(_s.sessionKey != null){
				if(errorType == "warning"){
					_s.client.reportError(_s.sessionKey, message, Conviva.Client.ErrorSeverity.WARNING);
				}else{
					_s.client.reportError(_s.sessionKey, message, Conviva.Client.ErrorSeverity.FATAL);
				}
			}
		}
		
		this.stopMonitor = function(){
			if(_s.sessionKey != null){
				_s.client.cleanupSession(_s.sessionKey);
				_s.client.releasePlayerStateManager(_s.playerStateManager);
			}
		}.bind(this);
		
		
	}
	
	
	
	exports.ConvivaMonitor = ConvivaMonitor;
}(window));
function Html5Http () {

    function _constr() {
        // nothing to initialize
    }

    _constr.apply(this, arguments);

    this.makeRequest = function (httpMethod, url, data, contentType, timeoutMs, callback) {
    	// XDomainRequest only exists in IE, and is IE8-IE9's way of making CORS requests.
    	// It is present in IE10 but won't work right.
    	// if (typeof XDomainRequest !== "undefined" && navigator.userAgent.indexOf('MSIE 10') === -1) {
    	// 	return this.makeRequestIE89.apply(this, arguments);
    	// }
		return this.makeRequestStandard.apply(this, arguments);
    };

    this.makeRequestStandard = function (httpMethod, url, data, contentType, timeoutMs, callback) {
	    var xmlHttpReq = new XMLHttpRequest();

	    xmlHttpReq.open(httpMethod, url, true);
	 
        if (contentType && xmlHttpReq.overrideMimeType) {
            xmlHttpReq.overrideMimeType = contentType;
        }
	    if (contentType && xmlHttpReq.setRequestHeader) {
	        xmlHttpReq.setRequestHeader('Content-Type',  contentType);
	    }
	    if (timeoutMs > 0) {
	        xmlHttpReq.timeout = timeoutMs;
	        xmlHttpReq.ontimeout = function () {
	            // Often this callback will be called after onreadystatechange.
	            // The first callback called will cleanup the other to prevent duplicate responses.
	            xmlHttpReq.ontimeout = xmlHttpReq.onreadystatechange = null;
	            if (callback) callback(false, "timeout after " + timeoutMs + " ms");
	        };
	    }

	    xmlHttpReq.onreadystatechange = function () {
	        if (xmlHttpReq.readyState === 4) {
		        xmlHttpReq.ontimeout = xmlHttpReq.onreadystatechange = null;
		        if (xmlHttpReq.status == 200) {
	           		if (callback) callback(true, xmlHttpReq.responseText);
		        } else {
	            	if (callback) callback(false, "http status " + xmlHttpReq.status);
		        }
		    }
	    };

	    xmlHttpReq.send(data);

	    return null; // no way to cancel the request
    };

    this.release = function() {
        // nothing to release
    };

}
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
function Html5Storage () {

    function _constr() {
        // nothing to initialize
    }

    _constr.apply(this, arguments);

    this.saveData = function (storageSpace, storageKey, data, callback) {
        var localStorageKey = storageSpace + "." + storageKey;
        try {
            localStorage.setItem(localStorageKey, data);
            callback(true, null);
        } catch (e) {
            callback(false, e.toString());
        }
    };

    this.loadData = function (storageSpace, storageKey, callback) {
        var localStorageKey = storageSpace + "." + storageKey;
        try {
            var data = localStorage.getItem(localStorageKey);
            callback(true, data);
        } catch (e) { 
            callback(false, e.toString());
        }
    };

    this.release = function() {
        // nothing to release
    };

}
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