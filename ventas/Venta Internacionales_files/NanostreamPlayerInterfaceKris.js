// Monitor Nanostream player and reports video quality data
// to Conviva via playerStateManager
function NanostreamPlayerInterface (playerStateManager, configInstance, rcnmonitorinstance, convivainstance) {
	var _s = this;
	_s._currentbitrate = 0;
	_s.bufferflag = false;
	_s._width = 0;
	_s._height = 0;
	_s.eventdata = null;
	_s.upperbound = 20;
	_s.lowerbound = 1;
	_s.convivainstance = null;
	_s.pauseflag = false;
	_s.initplay = true;
	_s.debug = true;

	
	// We happen to reuse some of the system interfaces we defined to bootstrap the Conviva SDK here.
    // We could use system APIs directly as well.
    //this._timerInterface = new Html5Timer();
    ////this._loggingInterface = new Html5Logging();
	
	
	this._registerVideoEventListeners = function(){
		this._configInstance.events.onError = function (event){
		
			if(_s.debug) console.log("Error here : " + event.state);
			//console.log("Error");
			//this._log("Player error");
			if(event.state == 9){	//PLAYBACK_NOT_STARTED
				_s.convivainstance.reportError('warning', "Playback not started");
				//_s.convivainstance.client.reportError("Playback not started", Conviva.Client.ErrorSeverity.Fatal);
				//_s._receivedNanostreamEvent("pause");
				//_s._endSession();
			}
			if(event.state == 1){	//UNINITIALIZED
				_s.convivainstance.reportError('fatal', "Player uninitialized");
				//_s.convivainstance.client.reportError("Player uninitialized", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.state == 10){	//PLAYBACK_SUSPENDED
				_s.convivainstance.reportError('fatal', "Player suspended");
				//_s.convivainstance.client.reportError("Player suspended", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.state == 12){	//PLAYBACK_ERROR
				_s.convivainstance.reportError('fatal', "Playback error");
				//_s.convivainstance.client.reportError("Playback error", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.state == 14){	//CONNECTION_ERROR
				_s.convivainstance.reportError('fatal', "Connection Error");
				//_s.convivainstance.client.reportError("Connection Error", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.state == 15){	//DESTROYING
				_s.convivainstance.reportError('fatal', "Player destroyed");
				//_s.convivainstance.client.reportError("Player destroyed", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.state == 18){	//NOT_ENOUGH_DATA
				_s.convivainstance.reportError('fatal', "Not enough data");
				//_s.convivainstance.client.reportError("Not enough data", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.state == 19){	//SOURCE_STREAM_STOPPED
				_s.convivainstance.reportError('fatal', "Source stream stopped");
				//_s.convivainstance.client.reportError("Source stream stopped", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("destroy");
				_s._endSession();
			}
		}
		this._configInstance.events.onLoading = function (event){

			//this._log("Loading content");
			if(typeof drawPlayPause != "undefined"){
				drawPlayPause(event.player);
			}
			_s._receivedNanostreamEvent("onLoading");
			if(_s.initplay){
				_s.convivainstance.attachSession();
				_s.initplay = false;
			}
		}
		this._configInstance.events.onMetaData = function (event){
			//this._log("Meta data defined...");
			return;
		}
		this._configInstance.events.onPause = function (event){
			if(_s.debug)console.log("Pause here : " + event.data.reason );
			if(typeof drawPlayPause !== "undefined"){
				switch(event.data.reason)
				{
					case "buffer":
					case "playbackerror":
					case "streamnotfound":
					case "playbackerror":
					case "notenoughdata":
						attemptLowerBitrate(event);
						break;
				}
				
				drawPlayPause(event.player);
			}
			if(event.data.reason == "connectionclose" || event.data.reason == "destroy"){
				//playerStateManager.sendError("Wowza server connection lost", Conviva.Client.ErrorSeverity.FATAL);
				if(_s.debug) console.log("Pause to destroy");
				_s._receivedNanostreamEvent("error");
				//_s._endSession();
			}
			if(event.data.reason == "normal"){
				_s._receivedNanostreamEvent("pause");
			}
			//Playback warning errors
			
			
			//Playback blocking errors
			if(event.data.reason == "interactionrequired"){
				playerStateManager.sendError("Browser prevented autoplay", Conviva.Client.ErrorSeverity.FATAL);
				//_s._receivedNanostreamEvent("error");
				_s._resetSession();
			}
			if(event.data.reason == "buffer"){
				playerStateManager.sendError("Buffer underrun timeout", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.data.reason == "servernotfound"){
				playerStateManager.sendError("H2Live Server Not found", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.data.reason == "streamnotfound"){
				playerStateManager.sendError("Stream Not found", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.data.reason == "playbacksuspended"){
				playerStateManager.sendError("Playback Suspended", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.data.reason == "playbackerror"){
				playerStateManager.sendError("Playback Error", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.data.reason == "notenoughdata"){
				playerStateManager.sendError("Not enough data", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.data.reason == "sourcestreamstopped"){
				playerStateManager.sendError("Source stream stopped", Conviva.Client.ErrorSeverity.FATAL);
				_s._receivedNanostreamEvent("error");
				_s._endSession();
			}
			if(event.data.reason == "reconnectionimminent"){
				_s._receivedNanostreamEvent("onLoading");
			}
				
		}
		this._configInstance.events.onPlay = function (event){
			if(typeof drawPlayPause != "undefined"){
				drawPlayPause(event.player);
			}
			_s._receivedNanostreamEvent("playing");
		}
		this._configInstance.events.onReady = function (event){
			return;
		}
		this._configInstance.events.onStartBuffering = function (event){
			if(typeof addBufferEvent != "undefined") {
				addBufferEvent();
			}
			_s._receivedNanostreamEvent("onLoading");
			_s.bufferflag = true;
		}
		this._configInstance.events.onStats = function (event){
	
			if(typeof drawTime != "undefined"){	
				drawTime(event);
				
				// If the buffer threshold has been met, then attempt to lower the bitrate
				if(buffer >= adaptiveBitrateControl.buffer.eventThreshold)
				{
					attemptLowerBitrate(event);
				}
				
				if(buffer < 1)
				{
					noBufferEvents += 1;
					
					//console.log("No Buffer: " + noBufferEvents);
					
					if(noBufferEvents > 100)
					{
						attemptRaiseBitrate(event);
					}
				}
				else
				{
					noBufferEvents = 0;
				}
				
				//console.log("Threshold "+currBitrate * (adaptiveBitrateControl.averageBitrate.percentageThreshold/100));
				//console.log("Current Bitrate "+event.data.stats.bitrate.avg/1024);
				
				if(Math.floor(event.data.stats.currentTime) >= 10 && event.data.stats.bitrate.avg/1024 < currBitrate * (adaptiveBitrateControl.averageBitrate.percentageThreshold/100))
				{
					//lowerBitrate(event);
				}
			}
			
			//console.log("Sending stream info..");
			//debugger;
			var rand = Math.floor(Math.random() * _s.upperbound) + _s.lowerbound;
			if(rand <= Math.floor(_s.upperbound/6)){
				//console.log("Rand here " + rand);
				_s._currentTime = event.data.stats.currentTime;
				_s.eventdata = event.data.stats;
				_s._currentbitrate = event.data.stats.bitrate.current/1000; //kbps
				if(!_s.bufferflag){
					if(typeof currBitrate != "undefined"){	//jacobs ABR bitrate values
						if(_playerStateManager != null){
							_playerStateManager.setBitrateKbps(currBitrate);
						}
					}else{
						if(_playerStateManager != null){
							//BITRATE IS SET HERE FOR JAVASCRIPT INJECTION METHOD
							//console.log("Current Bitrate is : " +  typeof _s.convivainstance.getCurrentBitrate());
							_playerStateManager.setBitrateKbps(parseInt(_s.convivainstance.getCurrentBitrate()));
							//_playerStateManager.setBitrateKbps(_s._currentbitrate);
						}
					}
					//_s._receivedNanostreamEvent("updatebitrate");
				}
			}
			//_s._rcnmonitor.updatestats(event.data.stats);
			
			if(_s._rcnmonitors != undefined){
				//console.log(_s._rcnmonitors);
				_s._rcnmonitors.forEach(function(monitorinstance){
					monitorinstance.updatestats(event.data.stats);
				});
			}
		}
		this._configInstance.events.onStopBuffering = function (event){
			if(typeof drawPlayPause != "undefined"){
				drawPlayPause(event.player);
			}
			_s._receivedNanostreamEvent("playing");
		}
		this._configInstance.events.onStreamInfo = function (event){
			_s._vidwidth 	= event.data.streamInfo.videoInfo.width;
			_s._vidheight	= event.data.streamInfo.videoInfo.height;
		}
		this._configInstance.events.onMuted = function (event){
			if(typeof drawMuteButton != "undefined"){
				$("div#"+event.player).data({ "mute_state" :  MUTE_STATE.MUTED });
				drawMuteButton(event.player);
			}
			return;
		}
		this._configInstance.events.onUnmuted = function (event){
			if(typeof drawMuteButton != undefined){
				$("div#"+event.player).data({ "mute_state" :  MUTE_STATE.UNMUTED});
				drawMuteButton(event.player);
			}
			return;
		}
		this._configInstance.events.onVolumeChange = function (event){
			if(typeof drawVolume != "undefined"){
				$("div#"+event.player).data({ "volume" :  event.data.volume })
				drawVolume(event.player);
			}
			return;
		}
		this._configInstance.events.onWarning = function (event){
			return;
		}
		this._configInstance.events.onDestroy = function (event){
			_s._receivedNanostreamEvent("destroy");
			//_s._endSession();
			return;
		}
	}
	
	// Extract Conviva video quality data from Nanostream Event
    this._receivedNanostreamEvent = function (nanoEvent) {
        var convivaPlayerState = _s._convertNanostreamEventToConvivaPlayerState(nanoEvent);

        _s._log("Received HTML5 event: " + nanoEvent + ". Mapped to Conviva player state: " + convivaPlayerState);
		if(_playerStateManager != null){
			_s._updateConvivaPlayerState(convivaPlayerState);
		}
    };
	
	this._endSession = function() {
		if(_playerStateManager != null){
			_s.convivainstance.stopMonitor();
		}
	};
	
	//this will only reset session for browser that prevents autoplay
	this._resetSession = function(){
		if(_playerStateManager != null){
			console.log("Call to cleanup Session");
			_s.convivainstance.resetMonitor();
		}
	};
	
	 // Maps relevant HTML5 video element events to the corresponding Conviva player state.
    this._convertNanostreamEventToConvivaPlayerState = function (nanoEvent) {
        switch (nanoEvent) {
			case "streaminfo":
				if(_playerStateManager != null){
					//console.log("streaminfo - play status video with : "+ _s._vidwidth);
					if(_s._vidwidth !== undefined){
						//_playerStateManager.setVideoResolutionWidth(_s._vidwidth);
						//_playerStateManager.setVideoResolutionHeight(_s._vidheight);
					}
					return Conviva.PlayerStateManager.PlayerState.PLAYING;
				}
				if(_s.debug) console.log("PlayerStateManager: null streaminfo - play status");
				break;
			case "updatebitrate":
				if(_s.debug) console.log("PlayerStateManager: null updatebitrate - play status");
				break;
			case "error":
				if(_playerStateManager != null){
					if(_s.debug) console.log("error - stop status");
					//convivainstance.stopMonitor();
					//_s.cleanup();
					return Conviva.PlayerStateManager.PlayerState.STOPPED;
				}
				if(_s.debug) console.log("PlayerStateManager: null stop - play status");
				break;
            case "playing":				
				if(_playerStateManager != null){
					if(_s._vidwidth !== undefined){
						//console.log("Video width is " + _s._vidwidth);
						_playerStateManager.setVideoResolutionWidth(_s._vidwidth);
						_playerStateManager.setVideoResolutionHeight(_s._vidheight);
					}
					if(_s.debug) console.log("playing - play status");
					//console.log("SESSION while playing key is " + _s.convivainstance.getSessionKey());
					_s.bufferflag = false;
					return Conviva.PlayerStateManager.PlayerState.PLAYING;
				}
				if(_s.debug) console.log("PlayerStateManager: null play - play status");
				break;
            case "onLoading":
				if(_playerStateManager != null){
					return Conviva.PlayerStateManager.PlayerState.BUFFERING;
				}
				break;
            case "onStartBuffering":
				if(_s.debug) console.log("onStartBuffering - buffering status");
				if(_playerStateManager != null){
					return Conviva.PlayerStateManager.PlayerState.BUFFERING;
				}
				if(_s.debug) console.log("PlayerStateManager: null onStartBuffering - buffering status");
				break;
            case "ended":
            case "stopped":
			case "destroy":
				//dont need to stop monitor here since its already been stopped by error case
				if(_playerStateManager != null){
					if(_s.debug) console.log("ended, stopped, destroy - buffering status");
					//_s.convivainstance.stopMonitor();
					//_s.cleanup();
					return Conviva.PlayerStateManager.PlayerState.STOPPED;;
				}
				if(_s.debug) console.log("PlayerStateManager: null ended, stopped, destroy - buffering status");
				break;
            case "pause":
				if(_playerStateManager != null){
					if(_s.debug) console.log("paused - paused status");
					return Conviva.PlayerStateManager.PlayerState.PAUSED;
				}
				if(_s.debug) console.log("PlayerStateManager: null paused - paused status");
				break;
            default:
				if(_playerStateManager != null){
					if(_s.debug) console.log("Unknown Play Status");
					return Conviva.PlayerStateManager.PlayerState.UNKNOWN;
				}
				if(_s.debug) console.log("PlayerStateManager: null Unknown Play Status");
				return 0;
        }
    };
	
	this._updateConvivaPlayerState = function (newConvivaPlayerState) {
		if(_playerStateManager != null){
			//if (newConvivaPlayerState !== undefined && _s._playerStateManager.getPlayerState() !== newConvivaPlayerState && _s._playerStateManager.getPlayerState() != "UNKNOWN") {
			if (newConvivaPlayerState !== undefined && _s._playerStateManager.getPlayerState() !== newConvivaPlayerState) {
				_s._log("Changing Conviva player state to: " + newConvivaPlayerState);

				// Report the new player state to Conviva.
				if(_s.debug) console.log("update conviva player state : " + newConvivaPlayerState);				
				_s._playerStateManager.setPlayerState(newConvivaPlayerState);
				if(_s.debug) console.log("This is player state : " + _s._playerStateManager.getPlayerState());
				// Failsafe to avoid overcorrecting the player state when we just changed it.
				_s._playerStateRecentlyChanged = true;
			}
		}
    };
	
	this._log = function(message){
		//console.log(message);
	}
	
	this.getPHT = function() {
        //return _s._currentTime * 1000;
		if (_s.eventdata !== null) {
            return _s.eventdata.currentTime*1000;
        } else {
            return -1;
        }

    };
	
	this.getBufferLength = function() {
		//this._log(_s.eventdata);
		if(_s.eventdata !== null){
			return (_s.eventdata.buffer.end - _s.eventdata.buffer.start) * 1000;
		}else{
			return -1;
		}
    };
	
	this.getSignalStrength = function() {
		if(_playerStateManager != null){
			return _playerStateManager.DEFAULT_SIGNAL_STRENGTH;
		}
    };
	
	this.getRenderedFrameRate = function() {
		if(_s.eventdata !== null){
			return _s.eventdata.framerate.current;
		}else{
			return -1;
		}
    };
	// Constructor

    function _constr (playerStateManager, configInstance, rcnmonitorinstance, convivainstance) {
        //this._log("Html5PlayerInterface._constr()");
		_s.convivainstance = convivainstance;
        if (!playerStateManager && rcnmonitorinstance == null) {
            throw new Error("Html5PlayerInterface: playerStateManager argument cannot be null.");
        }
        if (!configInstance) {
            throw new Error("Html5PlayerInterface: videoElement argument cannot be null.");
        }

        this._playerStateManager = playerStateManager;
        this._configInstance = configInstance;
		if(_s._rcnmonitors == undefined){
			_s._rcnmonitors = [];
		}
		_s._rcnmonitors.push(rcnmonitorinstance);

        // Start listening for HTML5 video element events.
        //this._eventListeners = [];
        //this._registerVideoEventListeners();

        // Start polling for the current position in the video.
        //this._startPolling();

        //this._findCurrentState();
		if(_playerStateManager != null){
			this._registerVideoEventListeners();
			this._playerStateManager.setClientMeasureInterface(this);
		}
		
		
    }
	
	_constr.apply(this, arguments);

    // Destructor

    this.cleanup = function () {
        //this._log("Html5PlayerInterface.cleanup()");

        //this._stopPolling();
        //this._removeVideoEventHandlers();

        this._configInstance = null;
        this._playerStateManager = null;
    };

}