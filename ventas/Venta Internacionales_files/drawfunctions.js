var drawVolume = function(playerID)
{
	var canvas = $("div#"+playerID+" div#controls-"+playerID+" canvas#volume-controls-"+playerID).get(0);
	var controls = $("div#"+playerID+" div#controls-"+playerID).get(0);
	
	var volume = $("div#"+playerID).data("volume");
	
	style = canvas.currentStyle || window.getComputedStyle(canvas, null), o = isNaN(parseInt(style.borderLeftWidth)) ? 0 : parseInt(style.borderLeftWidth, 10), A = +!o;
	
	const context = canvas.getContext('2d');
	
	context.clearRect(0, 0, canvas.width, canvas.height), canvas.height = controls.clientHeight, canvas.style.right = controls.clientHeight * A + "px";
	
	//, canvas.width = 3 * canvas.height, d = canvas.width, f = canvas.height
	
	context.beginPath(), context.strokeStyle = "rgba("+customPlayerSettings.volumeControl.background.stroke.color.r+","+customPlayerSettings.volumeControl.background.stroke.color.g+","+customPlayerSettings.volumeControl.background.stroke.color.b+","+customPlayerSettings.volumeControl.background.stroke.color.opacity+")", context.lineJoin = "round", d = canvas.width,f = canvas.height, y = .1,  g = .15, h = Math.round(d * y), E = Math.round(f * (1 - g)), p = Math.round(d * (1 - y)), m = Math.round(f * g), context.moveTo(h, E), context.lineTo(p, E), context.lineTo(p, m), context.fillStyle = "rgba("+customPlayerSettings.volumeControl.background.fill.color.r+","+customPlayerSettings.volumeControl.background.fill.color.g+","+customPlayerSettings.volumeControl.background.fill.color.b+","+customPlayerSettings.volumeControl.background.fill.color.opacity+")",context.fill(),
	context.closePath(), context.beginPath(), _ = Math.round(h + volume * (p - h)), T = Math.round(E - volume * (E - m)), context.moveTo(h, E), context.lineTo(_, E), context.lineTo(_, T), context.fillStyle = "rgba("+customPlayerSettings.volumeControl.currentVolume.fill.color.r+","+customPlayerSettings.volumeControl.currentVolume.fill.color.g+","+customPlayerSettings.volumeControl.currentVolume.fill.color.b+","+customPlayerSettings.volumeControl.currentVolume.fill.color.opacity+")", context.fill();
}

var drawPlayPause = function(playerID)
{
	canvas = $("div#"+playerID+" div#controls-"+playerID+" canvas#playpause-controls-"+playerID).get(0);
	if(canvas){
		const context = canvas.getContext('2d');

		context.clearRect(0, 0, canvas.width, canvas.height);
		
		var e = canvas.width,
		t = {
			l20: Math.floor(.2 * e),
			l30: Math.floor(.3 * e),
			l45: Math.floor(.45 * e),
			l50: Math.floor(.5 * e),
			l55: Math.floor(.55 * e),
			l70: Math.floor(.7 * e),
			l75: Math.floor(.75 * e),
			l80: Math.floor(.8 * e)
		};
		
		players[playerID]._core._realPlayer._playing === false ? 
			(context.beginPath(), context.fillStyle = "rgba("+customPlayerSettings.playButton.color.r+","+customPlayerSettings.playButton.color.g+","+customPlayerSettings.playButton.color.b+","+customPlayerSettings.playButton.color.opacity+")", context.moveTo(t.l30, t.l20), context.lineTo(t.l30, t.l80), context.lineTo(t.l75, t.l50), context.fill()) : 
			(context.beginPath(), context.fillStyle = "rgba("+customPlayerSettings.pauseButton.left.color.r+","+customPlayerSettings.pauseButton.left.color.g+","+customPlayerSettings.pauseButton.left.color.b+","+customPlayerSettings.pauseButton.left.color.opacity+")", context.moveTo(t.l30, t.l20), context.lineTo(t.l30, t.l80), context.lineTo(t.l45, t.l80), context.lineTo(t.l45, t.l20), context.fill(),
			context.beginPath(), context.fillStyle = "rgba("+customPlayerSettings.pauseButton.right.color.r+","+customPlayerSettings.pauseButton.right.color.g+","+customPlayerSettings.pauseButton.right.color.b+","+customPlayerSettings.pauseButton.right.color.opacity+")", context.moveTo(t.l55, t.l20), context.lineTo(t.l55, t.l80), context.lineTo(t.l70, t.l80), context.lineTo(t.l70, t.l20), context.fill());
			
	}
}

var drawMuteButton = function(playerID)
{
	canvas = $("div#"+playerID+" div#controls-"+playerID+" canvas#mute-controls-"+playerID).get(0);
	if(canvas){
		var mutestate = $("div#"+playerID).data("mute_state");
		
		const context = canvas.getContext('2d');
		
		context.clearRect(0, 0, canvas.width, canvas.height);
		
		//
		var e = canvas.width,
			t = {
				l175: Math.round(.175 * e),
				l20: Math.round(.2 * e),
				l30: Math.round(.3 * e),
				l37: Math.round(.37 * e),
				l50: Math.round(.5 * e),
				l63: Math.round(.63 * e),
				l825: Math.round(.825 * e)
			};
		
		// Create the horn symbol for mute control
		if(mutestate === MUTE_STATE.MUTED)
		{
			context.beginPath(), context.fillStyle = "rgba("+customPlayerSettings.unmuteButton.horn.fill.color.r+","+customPlayerSettings.unmuteButton.horn.fill.color.g+","+customPlayerSettings.unmuteButton.horn.fill.color.b+","+customPlayerSettings.unmuteButton.horn.fill.color.opacity+")", context.strokeStyle = "rgba("+customPlayerSettings.unmuteButton.horn.stroke.color.r+","+customPlayerSettings.unmuteButton.horn.stroke.color.g+","+customPlayerSettings.unmuteButton.horn.stroke.color.b+","+customPlayerSettings.unmuteButton.horn.stroke.color.opacity+")", context.lineJoin = "round", context.moveTo(t.l20, t.l37), context.lineTo(t.l20, t.l63), context.lineTo(t.l30, t.l63), context.lineTo(t.l50, t.l825), context.lineTo(t.l50, t.l175), context.lineTo(t.l30, t.l37), context.fill();
			context.lineWidth = Math.round(.1 * e), context.lineCap = "round";
			context.strokeStyle = "rgba("+customPlayerSettings.unmuteButton.secondWave.stroke.color.r+","+customPlayerSettings.unmuteButton.secondWave.stroke.color.g+","+customPlayerSettings.unmuteButton.secondWave.stroke.color.b+","+customPlayerSettings.unmuteButton.secondWave.stroke.color.opacity+")", f = h = e / 2, p = .3 * e, E = 1.6 * Math.PI, m = .4 * Math.PI, context.beginPath(), context.arc(f, h, p, E, m, false), context.stroke();
			context.strokeStyle = "rgba("+customPlayerSettings.unmuteButton.firstWave.stroke.color.r+","+customPlayerSettings.unmuteButton.firstWave.stroke.color.g+","+customPlayerSettings.unmuteButton.firstWave.stroke.color.b+","+customPlayerSettings.unmuteButton.firstWave.stroke.color.opacity+")", p = .15 * e, E = 1.7 * Math.PI, m = .3 * Math.PI, context.beginPath(),context.arc(f, h, p, E, m, false), context.stroke();
		}
		else if (mutestate === MUTE_STATE.UNMUTED)
		{
			context.beginPath(), context.fillStyle = "rgba("+customPlayerSettings.muteButton.horn.fill.color.r+","+customPlayerSettings.muteButton.horn.fill.color.g+","+customPlayerSettings.muteButton.horn.fill.color.b+","+customPlayerSettings.muteButton.horn.fill.color.opacity+")", context.strokeStyle = "rgba("+customPlayerSettings.muteButton.horn.stroke.color.r+","+customPlayerSettings.muteButton.horn.stroke.color.g+","+customPlayerSettings.muteButton.horn.stroke.color.b+","+customPlayerSettings.muteButton.horn.stroke.color.opacity+")", context.lineJoin = "round", context.moveTo(t.l20, t.l37), context.lineTo(t.l20, t.l63), context.lineTo(t.l30, t.l63), context.lineTo(t.l50, t.l825), context.lineTo(t.l50, t.l175), context.lineTo(t.l30, t.l37), context.fill();
			context.lineWidth = Math.round(.1 * e), context.lineCap = "round";
			context.strokeStyle = "rgba("+customPlayerSettings.muteButton.secondWave.stroke.color.r+","+customPlayerSettings.muteButton.secondWave.stroke.color.g+","+customPlayerSettings.muteButton.secondWave.stroke.color.b+","+customPlayerSettings.muteButton.secondWave.stroke.color.opacity+")", f = h = e / 2, p = .3 * e, E = 1.6 * Math.PI, m = .4 * Math.PI, context.beginPath(), context.arc(f, h, p, E, m, false), context.stroke();
			context.strokeStyle = "rgba("+customPlayerSettings.muteButton.firstWave.stroke.color.r+","+customPlayerSettings.muteButton.firstWave.stroke.color.g+","+customPlayerSettings.muteButton.firstWave.stroke.color.b+","+customPlayerSettings.muteButton.firstWave.stroke.color.opacity+")", p = .15 * e, E = 1.7 * Math.PI, m = .3 * Math.PI, context.beginPath(),context.arc(f, h, p, E, m, false), context.stroke();
		}
	}
}

function getFullScreenElement()
{
	return document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;
}


function drawEnterFullscreenButton(playerID)
{
	var canvas = $("div#"+playerID+" div#controls-"+playerID+" canvas#fullscreen-controls-"+playerID).get(0);
	if(canvas){
		var controls = $("div#"+playerID+" div#controls-"+playerID).get(0);
		
		const context = canvas.getContext('2d');
		
		context.clearRect(0, 0, canvas.width, canvas.height), canvas.width = canvas.height = controls.clientHeight, canvas.style.right = 0;
		
		var e = canvas.width,
		t = {
			l20: Math.floor(.2 * e) + .5,
			l35: Math.floor(.35 * e) + .5,
			l65: Math.floor(.65 * e) + .5,
			l80: Math.floor(.8 * e) + .5
		};
		
		canvas.style.right = 0;
		
		context.beginPath(), context.lineCap = "round", context.lineWidth = Math.round(.1 * e);
		
		
		context.strokeStyle = "rgba("+customPlayerSettings.enterFullscreenControl.topLeft.color.r+","+customPlayerSettings.enterFullscreenControl.topLeft.color.g+","+customPlayerSettings.enterFullscreenControl.topLeft.color.b+","+customPlayerSettings.enterFullscreenControl.topLeft.color.opacity+")";
		if(customPlayerSettings.enterFullscreenControl.topLeft.style === 1)
		{
			context.beginPath(), context.moveTo(t.l20, t.l35), context.lineTo(t.l20, t.l20), context.lineTo(t.l35, t.l20), context.stroke();
		}
		else if(customPlayerSettings.enterFullscreenControl.topLeft.style === 2)
		{
			context.beginPath(), context.moveTo(t.l20, t.l35), context.lineTo(t.l35, t.l35), context.lineTo(t.l35, t.l20), context.stroke();
		}
		
		context.strokeStyle = "rgba("+customPlayerSettings.enterFullscreenControl.topRight.color.r+","+customPlayerSettings.enterFullscreenControl.topRight.color.g+","+customPlayerSettings.enterFullscreenControl.topRight.color.b+","+customPlayerSettings.enterFullscreenControl.topRight.color.opacity+")";
		if(customPlayerSettings.enterFullscreenControl.topRight.style === 1)
		{
			context.beginPath(), context.moveTo(t.l65, t.l20), context.lineTo(t.l80, t.l20), context.lineTo(t.l80, t.l35), context.stroke();
		}
		else if(customPlayerSettings.enterFullscreenControl.topRight.style === 2)
		{
			context.beginPath(), context.moveTo(t.l65, t.l20), context.lineTo(t.l65, t.l35), context.lineTo(t.l80, t.l35), context.stroke()
		}
		
		context.strokeStyle = "rgba("+customPlayerSettings.enterFullscreenControl.bottomRight.color.r+","+customPlayerSettings.enterFullscreenControl.bottomRight.color.g+","+customPlayerSettings.enterFullscreenControl.bottomRight.color.b+","+customPlayerSettings.enterFullscreenControl.bottomRight.color.opacity+")";
		if(customPlayerSettings.enterFullscreenControl.bottomRight.style === 1)
		{
			context.beginPath(), context.moveTo(t.l80, t.l65), context.lineTo(t.l80, t.l80), context.lineTo(t.l65, t.l80), context.stroke();
		}
		else if(customPlayerSettings.enterFullscreenControl.bottomRight.style === 2)
		{
			context.beginPath(), context.moveTo(t.l80, t.l65), context.lineTo(t.l65, t.l65), context.lineTo(t.l65, t.l80), context.stroke()
		}
		
		context.strokeStyle = "rgba("+customPlayerSettings.enterFullscreenControl.bottomLeft.color.r+","+customPlayerSettings.enterFullscreenControl.bottomLeft.color.g+","+customPlayerSettings.enterFullscreenControl.bottomLeft.color.b+","+customPlayerSettings.enterFullscreenControl.bottomLeft.color.opacity+")";
		if(customPlayerSettings.enterFullscreenControl.bottomLeft.style === 1)
		{
			context.beginPath(), context.moveTo(t.l35, t.l80), context.lineTo(t.l20, t.l80), context.lineTo(t.l20, t.l65), context.stroke();
		}
		else if(customPlayerSettings.enterFullscreenControl.bottomLeft.style === 2)
		{
			context.beginPath(), context.moveTo(t.l35, t.l80), context.lineTo(t.l35, t.l65), context.lineTo(t.l20, t.l65), context.stroke()
		}
	}

	//(context.beginPath(), context.moveTo(t.l20, t.l35), context.lineTo(t.l20, t.l20), context.lineTo(t.l35, t.l20), context.stroke(), context.beginPath(), context.moveTo(t.l65, t.l20), context.lineTo(t.l80, t.l20), context.lineTo(t.l80, t.l35), context.stroke(), context.beginPath(), context.moveTo(t.l80, t.l65), context.lineTo(t.l80, t.l80), context.lineTo(t.l65, t.l80), context.stroke(), context.beginPath(), context.moveTo(t.l35, t.l80), context.lineTo(t.l20, t.l80), context.lineTo(t.l20, t.l65), context.stroke());
}


function drawExitFullscreenButton(playerID)
{
	var canvas = $("div#"+playerID+" div#controls-"+playerID+" canvas#fullscreen-controls-"+playerID).get(0);
	if(canvas){
		var controls = $("div#"+playerID+" div#controls-"+playerID).get(0);
		
		const context = canvas.getContext('2d');
		
		context.clearRect(0, 0, canvas.width, canvas.height), canvas.width = canvas.height = controls.clientHeight, canvas.style.right = 0;
		
		var e = canvas.width,
		t = {
			l20: Math.floor(.2 * e) + .5,
			l35: Math.floor(.35 * e) + .5,
			l65: Math.floor(.65 * e) + .5,
			l80: Math.floor(.8 * e) + .5
		};
		
		canvas.style.right = 0;
		
		context.beginPath(), context.lineCap = "round", context.lineWidth = Math.round(.1 * e);
		
		
		context.strokeStyle = "rgba("+customPlayerSettings.exitFullscreenControl.topLeft.color.r+","+customPlayerSettings.exitFullscreenControl.topLeft.color.g+","+customPlayerSettings.exitFullscreenControl.topLeft.color.b+","+customPlayerSettings.exitFullscreenControl.topLeft.color.opacity+")";
		if(customPlayerSettings.exitFullscreenControl.topLeft.style === 1)
		{
			context.beginPath(), context.moveTo(t.l20, t.l35), context.lineTo(t.l20, t.l20), context.lineTo(t.l35, t.l20), context.stroke();
		}
		else if(customPlayerSettings.exitFullscreenControl.topLeft.style === 2)
		{
			context.beginPath(), context.moveTo(t.l20, t.l35), context.lineTo(t.l35, t.l35), context.lineTo(t.l35, t.l20), context.stroke();
		}
		
		context.strokeStyle = "rgba("+customPlayerSettings.exitFullscreenControl.topRight.color.r+","+customPlayerSettings.exitFullscreenControl.topRight.color.g+","+customPlayerSettings.exitFullscreenControl.topRight.color.b+","+customPlayerSettings.exitFullscreenControl.topRight.color.opacity+")";
		if(customPlayerSettings.exitFullscreenControl.topRight.style === 1)
		{
			context.beginPath(), context.moveTo(t.l65, t.l20), context.lineTo(t.l80, t.l20), context.lineTo(t.l80, t.l35), context.stroke();
		}
		else if(customPlayerSettings.exitFullscreenControl.topRight.style === 2)
		{
			context.beginPath(), context.moveTo(t.l65, t.l20), context.lineTo(t.l65, t.l35), context.lineTo(t.l80, t.l35), context.stroke()
		}
		
		context.strokeStyle = "rgba("+customPlayerSettings.exitFullscreenControl.bottomRight.color.r+","+customPlayerSettings.exitFullscreenControl.bottomRight.color.g+","+customPlayerSettings.exitFullscreenControl.bottomRight.color.b+","+customPlayerSettings.exitFullscreenControl.bottomRight.color.opacity+")";
		if(customPlayerSettings.exitFullscreenControl.bottomRight.style === 1)
		{
			context.beginPath(), context.moveTo(t.l80, t.l65), context.lineTo(t.l80, t.l80), context.lineTo(t.l65, t.l80), context.stroke();
		}
		else if(customPlayerSettings.exitFullscreenControl.bottomRight.style === 2)
		{
			context.beginPath(), context.moveTo(t.l80, t.l65), context.lineTo(t.l65, t.l65), context.lineTo(t.l65, t.l80), context.stroke()
		}
		
		context.strokeStyle = "rgba("+customPlayerSettings.exitFullscreenControl.bottomLeft.color.r+","+customPlayerSettings.exitFullscreenControl.bottomLeft.color.g+","+customPlayerSettings.exitFullscreenControl.bottomLeft.color.b+","+customPlayerSettings.exitFullscreenControl.bottomLeft.color.opacity+")";
		if(customPlayerSettings.exitFullscreenControl.bottomLeft.style === 1)
		{
			context.beginPath(), context.moveTo(t.l35, t.l80), context.lineTo(t.l20, t.l80), context.lineTo(t.l20, t.l65), context.stroke();
		}
		else if(customPlayerSettings.exitFullscreenControl.bottomLeft.style === 2)
		{
			context.beginPath(), context.moveTo(t.l35, t.l80), context.lineTo(t.l35, t.l65), context.lineTo(t.l20, t.l65), context.stroke()
		}
	}
}

var drawTime = function(statsEvent)
{
	canvas = $("div#"+statsEvent.player+" div#controls-"+statsEvent.player+" canvas#time-controls-"+statsEvent.player).get(0);
	
	if(canvas){
	
		const context = canvas.getContext('2d');
		
		context.clearRect(0, 0, canvas.width, canvas.height);
		
		var t = canvas.height;
		canvas.style.left = 1 * canvas.height + "px";
		var n = canvas.width = 3 * canvas.height;
		
		context.textAlign = "left", context.textBaseline = "middle", context.font = "bold " + Math.round(.6 * t) + 'px "Arial"';
		context.fillStyle = "rgba("+customPlayerSettings.time.color.r+","+customPlayerSettings.time.color.g+","+customPlayerSettings.time.color.b+","+customPlayerSettings.time.color.opacity+")";
		
		try {
			context.fillText(getTimeDisplayString(statsEvent.data.stats.currentTime), Math.round(.1 * n), Math.round(.5 * t))
		} catch (e) {}
	
	}
}

var getTimeDisplayString = function(e)
{
	var t = Math.floor(e / 3600),
		n = Math.floor((e - 3600 * t) / 60),
		e = Math.floor(e - 3600 * t - 60 * n),
		i = "";
	return 0 != t && (i = t + ":"), n = n < 10 && "" !== i ? "0" + n : String(n), i += n + ":", i += e < 10 ? "0" + e : String(e)
}