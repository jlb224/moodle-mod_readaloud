<?php
/**
 * PoodLL Audio Recording SDK
 *
* @author Justin Hunt (@link http://www.poodll.com)
* @copyright 2013 onwards Justin Hunt http://www.poodll.com
* @license JustinsPlainEnglishLicense ( http://www.poodll.com/justinsplainenglishlicense.txt )
 */
 
//Get our poodll resource handling lib
require_once('poodllfilelib.php');
//get our browser detection library
require_once('browser.php');
?>
<html>
<head>
<script type="text/javascript">
//<![CDATA[
//this function shows how the recorders can be configured to return info to a callback function
function poodllcallback(args){
	console.log ("poodllcallback:" + args[0] + ":" + args[1] + ":" + args[2] + ":" + args[3] + ":" + args[4] + ":" + args[5] + ":" + args[6]);

		
	switch(args[1]){
		case 'statuschanged':
							break;
		case 'filesubmitted':
				//audio filename
				var audlabel=document.createTextNode("filename: " + args[2]);
				
				//audio element
				var aud=document.createElement('audio');
				aud.controls="controls";
				
				//audio source
				var dasrc = document.createElement('source');
				dasrc.type= 'audio/mpeg';
				dasrc.src="out/" + args[2];
				dasrc.setAttribute("preload","auto");
				
				//set audio src
				aud.appendChild(dasrc);
				aud.load();	

				//put it all on the page
				var players = document.getElementById('players');
				players.appendChild(audlabel);
				players.appendChild(document.createElement('br'));
				players.appendChild(aud);
				players.appendChild(document.createElement('br'));
				
				//to disablerecorder after exporting
				if(lz.embed[args[0]] != null){
					lz.embed[args[0]].callMethod('poodllapi.mp3_disable()');
				}
				
				
				break;
		case 'uploadstarted':
							break;
		case 'actionerror':
							break;
		case 'timeouterror':
							break;
		case 'nosound':
							break;
	
	
	
	}

}
//this function shows how to call the MP3 recorder's API to export the recording to the server
function doexport(recorderid){
	if(lz.embed[recorderid] != null){
		lz.embed[recorderid].callMethod('poodllapi.mp3_export()');
	}else{
		deferredexport(recorderid);
	}
}
//this function shows how to call the MP3 recorder's API to stop the recording or playback
function dodisable(recorderid){
	if(lz.embed[recorderid] != null){
		lz.embed[recorderid].callMethod('poodllapi.mp3_disable()');
	}
}
//this function shows how to call the MP3 recorder's API to stop the recording or playback
function doproperties(recorderid){
	if(lz.embed[recorderid] != null){
		console.log ("haverecorded:" + lz.embed[recorderid].getCanvasAttribute('haverecorded'));
		console.log ("recorderstatus:" +lz.embed[recorderid].getCanvasAttribute('recorderstatus'));
		console.log ("haveuploaded:" +lz.embed[recorderid].getCanvasAttribute('haveuploaded'));
		console.log ("gotsound:" +lz.embed[recorderid].getCanvasAttribute('gotsound'));
		console.log ("displaytime:" +lz.embed[recorderid].getCanvasAttribute('displaytime'));
	}
}
//]]>
</script>
<script type="text/javascript" src="embed-compressed.js"></script>
<script type="text/javascript" src="mobileupload.js"></script>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>PoodLL Audio Recording Sample Project</h1>
<br/>
<br/>
<h4>To use this example, set $autosubmit to false in poodllfilelib.php(function fetchMP3Recorder) . The audio file will then only be submitted when the html "export" button is pressed.</h4>
Record your voice, or upload a video/audio file. It will be received, optionally converted, and an HTML5 audio player displayed on the page beneath the recorder. For PC users this demonstration will work best with browsers,that reliably play back MP3 files in HTML5(Chrome or Safari). However all browsers should record successfully.
<br/>
<br/>
<?php 
//recorder 1
echo fetchRecorder("","poodllcallback" ,"p1","p2","p3","p4","therecorderid","false","noskin");
//recorder 2
//echo fetchRecorder("","poodllcallback" ,"p1","p2","p3","p4","thesecondrecorderid");
?>
<button name="export" id="id_export" onclick="doexport('therecorderid');">export</button>
<button name="properties" id="id_properties" onclick="doproperties('therecorderid');">properties</button>
<div id="players" />
</body>
</html>