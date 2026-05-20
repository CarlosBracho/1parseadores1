(function(exports){
	"use strict";
	
	function RcnMonitor(){
		
		var _s = this;
		_s.bitrategauge = null;
		_s.currentbitrate = null;
		_s.framerategauge = null;
		_s.currentframerate = null;
	
		
		
		this.init = function(playerdiv){
			//build dashboard
			_s.dcontainer = document.createElement('div');
			document.getElementById(playerdiv).appendChild(_s.dcontainer);
			_s.dcontainer.setAttribute('style', 'position:absolute; width:340px; height:300px; background-color:rgba(0, 0, 0, 0.7); right: 0; top: 0;');
			
			//create bitrate gauge
			var bitratediv = document.createElement('div');
			_s.dcontainer.appendChild(bitratediv);
			bitratediv.setAttribute('style', 'margin-top: 20px; margin-left: 20px; float: left;');
			var canvasbitrate = document.createElement('canvas');
			canvasbitrate.setAttribute('style', 'width: 150px; height: 100px;');
			bitratediv.appendChild(canvasbitrate);
			var cbitrateopts = this.getGuageTemplate();
			cbitrateopts.staticZones.push({strokeStyle: "#F03E3E", min: 0, max: 400});
			cbitrateopts.staticZones.push({strokeStyle: "#FFDD00", min: 400, max: 771});
			cbitrateopts.staticZones.push({strokeStyle: "#30B32D", min: 771, max: 1308});
			cbitrateopts.staticZones.push({strokeStyle: "#30B32D", min: 1308, max: 2500});
			cbitrateopts.staticLabels.labels = [400, 771, 1308, 2200];
			_s.bitrategauge = new Gauge(canvasbitrate).setOptions(cbitrateopts); 
			_s.bitrategauge.maxValue = 2500; 
			_s.bitrategauge.setMinValue(0);  
			_s.bitrategauge.animationSpeed = 27; 
			//add bitrate value label
			_s.bitratevaldiv = document.createElement('div');
			_s.bitratevaldiv.setAttribute('style', this.getLabelStyle());
			bitratediv.appendChild(_s.bitratevaldiv);
			
			//create framerate gauge
			var frameratediv = document.createElement('div');
			_s.dcontainer.appendChild(frameratediv);
			frameratediv.setAttribute('style', 'margin-top: 20px; float: left;');
			var canvasframerate = document.createElement('canvas');
			canvasframerate.setAttribute('style', 'width: 150px; height: 100px;');
			frameratediv.appendChild(canvasframerate);
			var cframerateopts = this.getGuageTemplate();
			cframerateopts.staticZones.push({strokeStyle: "#F03E3E", min: 0, max: 5});
			cframerateopts.staticZones.push({strokeStyle: "#FFDD00", min: 5, max: 10});
			cframerateopts.staticZones.push({strokeStyle: "#30B32D", min: 10, max: 60});
			cframerateopts.staticLabels.labels =[5, 10, 30]
			_s.framerategauge = new Gauge(canvasframerate).setOptions(cframerateopts); 
			_s.framerategauge.maxValue = 60; 
			_s.framerategauge.setMinValue(0);  
			_s.framerategauge.animationSpeed = 27; 
			//add bitrate value label
			_s.frameratevaldiv = document.createElement('div');
			_s.frameratevaldiv.setAttribute('style', this.getLabelStyle());
			frameratediv.appendChild(_s.frameratevaldiv);
			
			this.buildTableStats();
			
			//hide for initial
			this.toggleDisplay();
			
		}.bind(this);
		
		this.buildTableStats = function(){
			var tablerow = null;
			var tablecell = null;
			var tablestats = document.createElement('table');
			tablestats.setAttribute('width', '95%');
			tablestats.setAttribute('style', 'margin: 5px 20px 5px 5px; clear: both;');
			_s.dcontainer.appendChild(tablestats);
			
			//insert bitrate info
			tablerow = document.createElement('tr');
			tablerow.setAttribute('style', this.getRowStyleLight());
			tablestats.appendChild(tablerow);
			tablecell = document.createElement('td');
			tablecell.setAttribute('style', this.getCellStyleLabel());
			tablerow.appendChild(tablecell);
			tablecell.innerHTML = 'Min/Max/Avg Bitrate';
			_s.bitrateinfo = document.createElement('td');
			_s.bitrateinfo.setAttribute('style', this.getCellStyleValue());
			tablerow.appendChild(_s.bitrateinfo);
			this.setbitrateinfo(0, 0, 0);
			
			//insert framerate info
			tablerow = document.createElement('tr');
			tablerow.setAttribute('style', this.getRowStyleDark());
			tablestats.appendChild(tablerow);
			tablecell = document.createElement('td');
			tablecell.setAttribute('style', this.getCellStyleLabel());
			tablerow.appendChild(tablecell);
			tablecell.innerHTML = 'Min/Max/Avg Framerate';
			_s.framerateinfo = document.createElement('td');
			_s.framerateinfo.setAttribute('style', this.getCellStyleValue());
			tablerow.appendChild(_s.framerateinfo);
			this.setframerateinfo(0, 0, 0);
			
			//insert buffer
			tablerow = document.createElement('tr');
			tablerow.setAttribute('style', this.getRowStyleLight());
			tablestats.appendChild(tablerow);
			tablecell = document.createElement('td');
			tablecell.setAttribute('style', this.getCellStyleLabel());
			tablerow.appendChild(tablecell);
			tablecell.innerHTML = 'Current Buffer Delay';
			_s.buffercurrent = document.createElement('td');
			_s.buffercurrent.setAttribute('style', this.getCellStyleValue());
			tablerow.appendChild(_s.buffercurrent);
			this.setbuffercurrent(0);
			
			//insert buffer info
			tablerow = document.createElement('tr');
			tablerow.setAttribute('style', this.getRowStyleDark());
			tablestats.appendChild(tablerow);
			tablecell = document.createElement('td');
			tablecell.setAttribute('style', this.getCellStyleLabel());
			tablerow.appendChild(tablecell);
			tablecell.innerHTML =  'Min/Max/Avg Buffer Delay';
			_s.bufferinfo = document.createElement('td');
			_s.bufferinfo.setAttribute('style', this.getCellStyleValue());
			tablerow.appendChild(_s.bufferinfo);
			this.setbufferinfo(0, 0, 0);
			
			//insert corruptedframes row
			tablerow = document.createElement('tr');
			tablerow.setAttribute('style', this.getRowStyleLight());
			tablestats.appendChild(tablerow);
			tablecell = document.createElement('td');
			tablecell.setAttribute('style', this.getCellStyleLabel());
			tablerow.appendChild(tablecell);
			tablecell.innerHTML = 'Corrupted Video Frames';
			_s.corruptedframes = document.createElement('td');
			_s.corruptedframes.setAttribute('style', this.getCellStyleValue());
			tablerow.appendChild(_s.corruptedframes);
			this.setCorruptedFrames(0);
			
			//insert dropped frames row
			tablerow = document.createElement('tr');
			tablerow.setAttribute('style', this.getRowStyleDark());
			tablestats.appendChild(tablerow);
			tablecell = document.createElement('td');
			tablecell.setAttribute('style', this.getCellStyleLabel());
			tablerow.appendChild(tablecell);
			tablecell.innerHTML = 'Dropped Video Frames';
			_s.droppedframes = document.createElement('td');
			_s.droppedframes.setAttribute('style', this.getCellStyleValue());
			tablerow.appendChild(_s.droppedframes);
			this.setDroppedframes(0);
			
			
			
		}.bind(this);
		
		this.setbufferinfo = function(min, max, avg){
			min = min.toFixed(2);
			max = max.toFixed(2);
			avg = avg.toFixed(2);
			_s.bufferinfo.innerHTML = min + ' / ' + max + ' / ' +avg + ' sec';
		}
		
		this.setframerateinfo = function(min, max, avg){
			min = Math.ceil(min);
			max = Math.ceil(max);
			avg = Math.ceil(avg);
			_s.framerateinfo.innerHTML = min + ' / ' + max + ' / ' +avg;
		}
		
		this.setbitrateinfo = function(min, max, avg){
			min = Math.ceil(min/1000);
			max = Math.ceil(max/1000);
			avg = Math.ceil(avg/1000);
			_s.bitrateinfo.innerHTML = min + ' / ' + max + ' / ' +avg;
		}
		
		this.setcurrentbitrate = function(val){
			 _s.currentbitrate = val/1000; //kbps
			_s.bitratevaldiv.innerHTML = 'Bitrate: ' + Math.ceil(_s.currentbitrate) + ' kbps';
		}
		
		this.setCurrentFramerate = function(val) {
			_s.frameratevaldiv.innerHTML = 'Framerate: '+ val + ' fps';
		}
		
		this.setCorruptedFrames = function(val){
			_s.corruptedframes.innerHTML = val;
		}
		
		this.setDroppedframes = function(val) {
			_s.droppedframes.innerHTML = val;
		}
		
		this.setbuffercurrent = function(val) {
			_s.buffercurrent.innerHTML = val.toFixed(2) + ' sec';
		}
		
		this.getRowStyleLight = function() {
			return 'background-color: #2B333B;';
		}
		
		this.getRowStyleDark = function() {
			return 'background-color: #111111;';
		}
		
		this.getCellStyleLabel = function() {
			
			return 'color: #f1f1f1; font-family: arial,sans-serif; font-size: 0.80em; padding: 4px; width: 55%';
		}
		
		this.getCellStyleValue = function() {
			
			return 'color: #f1f1f1; font-family: arial,sans-serif; font-size: 0.80em; padding: 4px; width: 60%; text-align: right;';
		}
		
		this.getLabelStyle = function() {
			return 'color: #00FF66; font-family: arial; font-size: 12px; text-align: center;';
		}
		
		this.stopMonitor = function(){
			
		}.bind(this);
		
		this.getGuageTemplate = function(){
			var opts = {
				angle: -0.2, // The span of the gauge arc
				lineWidth: 0.29, // The line thickness
				radiusScale: 0.74, // Relative radius
				pointer: {
					length: 0.6, // // Relative to gauge radius
					strokeWidth: 0.033, // The thickness
					color: '#F1F1F1' // Fill color
				},
				limitMax: true,     // If false, max value increases automatically if value > maxValue
				limitMin: true,     // If true, the min value of the gauge will be fixed
				colorStart: '#6FADCF',   // Colors
				colorStop: '#8FC0DA',    
				strokeColor: '#E0E0E0',  
				generateGradient: true,
				highDpiSupport: true,     // High resolution support
				staticLabels: {
				  font: "10px sans-serif",  // Specifies font
				  labels: [],  // Print labels at these values
				  color: "#ffffff",  // Optional: Label text color
				  fractionDigits: 0  // Optional: Numerical precision. 0=round off.
				},
				staticZones: []
			};
			
			return opts;
		}
		
		this.updatestats =  function(stats){
			if(_s.bitrategauge != null){				
				_s.bitrategauge.set(_s.currentbitrate); // set actual value
				_s.framerategauge.set(stats.framerate.current);
				this.setcurrentbitrate(stats.bitrate.current);
				this.setCurrentFramerate(stats.framerate.current);
				this.setbuffercurrent(stats.buffer.delay.current);
				this.setbufferinfo(stats.buffer.delay.min, stats.buffer.delay.max, stats.buffer.delay.avg);
				this.setCorruptedFrames(stats.quality.corruptedVideoFrames);
				this.setbitrateinfo(stats.bitrate.min, stats.bitrate.max, stats.bitrate.avg);
				this.setframerateinfo(stats.framerate.min, stats.framerate.max, stats.framerate.avg);
				
			}
		}.bind(this);
		
		this.toggleDisplay =  function(divId){
			//_s.dcontainer = document.getElementById(divId);	
			if (_s.dcontainer.style.display === "none") {
				_s.dcontainer.style.display = "block";
			} else {
				_s.dcontainer.style.display = "none";
			}
		}.bind(this);
		
		this.initRcnInterface = function(evt){

			 _s.nplayer = evt.player;	//player id
			 var divId = 'rcn_controls_' +  _s.nplayer;
			
			 if(document.getElementById(divId) == undefined){
				 //init dashboard
				 this.init(_s.nplayer);
				 
				 //register listener
				 this.registerListeners();
				 
				 //create RCN custom interface
				
				 _s.rcnctrl = document.createElement('div');
				 
				 document.getElementById( _s.nplayer).appendChild(_s.rcnctrl);
				 _s.rcnctrl.setAttribute('id', divId);
				 _s.rcnctrl.setAttribute('style', 'position: absolute; width: 5.5%; height: 20%; background: #FFF; top: 50%; margin-top: -10%; opacity: 0.6; border-radius: 0px 10px 10px 0px; box-shadow: 2px 2px 6px;');
				 
				 //append device monitor UI
				 var divmonitor = document.createElement('div');
				 _s.rcnctrl.appendChild(divmonitor);
				 divmonitor.setAttribute('style', 'width: 80%; height: 35%; background: url("//stream.robertsstream.com/img/monitor3.png"); background-size: contain; background-repeat: no-repeat; margin-top: 20%; margin-left: 10%; cursor: pointer;');
				 //divmonitor.setAttribute('class', 'monitorit');
				 
				 //append device troubleshooting UI
				 var divfix = document.createElement('div');
				 _s.rcnctrl.appendChild(divfix);
				 divfix.setAttribute('style', 'width: 80%; height: 35%; background: url("//stream.robertsstream.com/img/troubleshoot3.png"); background-size: contain; background-repeat: no-repeat; margin-left: 10%; margin-top: 15%;  cursor: pointer;');
				 //divfix.setAttribute('class', 'fixit');
				 
				 //attach events
				 divmonitor.onclick = function(evt){
					//alert('monitor clicked');
					_s.toggleDisplay(divId);
				 };
				 
				 divfix.onclick = function(evt){
					alert('fix clicked'); 
				 };
				 
				 //hide initialy
				 _s.rcnctrl.style.display = "none";
			 }
			 
			 
		}.bind(this);
		
		this.registerListeners = function(){
			 document.getElementById(_s.nplayer).onmouseover = function(){
				 _s.toggleDisplayRcnCtrl();
			 };
		}.bind(this);
		
		this.toggleDisplayRcnCtrl = function(){
			if ( _s.rcnctrl.style.display === "none") {
				 _s.rcnctrl.style.display = "block";
				window.clearTimeout(_s.hidercnctrl);
				_s.hidercnctrl = setTimeout(function(){
					 _s.rcnctrl.style.display = "none";
				},5400);	
			} else {
				window.clearTimeout(_s.hidercnctrl);
				_s.hidercnctrl = setTimeout(function(){
					 _s.rcnctrl.style.display = "none";
				},5400);						
			}
		}.bind(this);	
	}
	
	
	
	exports.RcnMonitor = RcnMonitor;
}(window));