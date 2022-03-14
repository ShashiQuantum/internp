<!DOCTYPE html>
<html>
<head>
<title>Screen recording</title>


</head>
<body>
<button onclick="startRec()">Start RECORDING</button>
<button id="stoprecording">STOP RECORDING</button>

<video id="preview-screen" controls height="600" width="800" style="float: left; margin-top: 20px; display:none">
</video> <!-- Recorded video will be appear here -->


<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://cdn.WebRTC-Experiment.com/getScreenId.js"></script>

<script>
function captureScreen(cb) {
getScreenId(function (error, sourceId, screen_constraints) 
{
navigator.mediaDevices.getUserMedia(screen_constraints).then(cb).catch(function(error) {
console.error('getScreenId error', error);
alert('Failed to capture your screen. Please check browser console logs for further information.');
});
}, true);
}

function captureAudio(cb) 
{
navigator.mediaDevices.getUserMedia({audio: true, video: false}).then(cb);
}
function keepStreamActive(stream) {
var video = document.createElement('video');
video.muted = true;
setSrcObject(stream, video);
video.style.display = 'none';
(document.body || document.documentElement).appendChild(video);
}

var recorder = '';
var screenRec = '';
var micRec = '';

function startRec ()
{
captureScreen(function(screen) {
keepStreamActive(screen);

captureAudio(function(mic) 
{
keepStreamActive(mic);

screen.width = window.screen.width;
screen.height = window.screen.height;
screen.fullcanvas = true;

recorder = RecordRTC([screen, mic], {
type: 'video',
mimeType: 'video/webm',
});

screenRec = screen;
micRec = mic;

//Start recording
recorder.startRecording();

});

addStreamStopListener(screen, function() 
{
	btnStopRecording.click();
});
});
}

var btnStopRecording = document.getElementById('stoprecording');

btnStopRecording.onclick = function()
{

document.getElementById('preview-screen').style.display = 'block';

recorder.stopRecording(function() 
{
var blob = recorder.getBlob();

document.querySelector('#preview-screen').src = URL.createObjectURL(blob);
document.querySelector('#preview-screen').muted = false;

//alert(URL.createObjectURL(blob));

 // you can upload Blob to server
    uploadBlob(blob);

screenRec.getTracks().concat(micRec.getTracks()).forEach(function(track) 
{
	track.stop();
});
});


};

function addStreamStopListener(stream, callback) 
{
var streamEndedEvent = 'ended';
if ('oninactive' in stream) 
{
	streamEndedEvent = 'inactive';
}
stream.addEventListener(streamEndedEvent, function() 
{
callback();
callback = function() {};
}, false);
stream.getAudioTracks().forEach(function(track) 
{
	track.addEventListener(streamEndedEvent, function() 
	{
	callback();
	callback = function() {};
	}, false);
});
stream.getVideoTracks().forEach(function(track) 
{
track.addEventListener(streamEndedEvent, function() 
{
callback();
callback = function() {};
}, false);
});
}
</script>
</body>
</html>