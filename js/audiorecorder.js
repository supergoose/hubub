/***** AUDIO RECORDING ******/

window.AudioContext = window.AudioContext || window.webkitAudioContext;

var audioContext = new AudioContext();
var audioInput = null,
    realAudioInput = null,
    inputPoint = null,
    audioRecorder = null,
    uploadDirectory = "hubub/uploads/sounds/",
    soundUploadComplete = null;

function initAudioRecorder()
{
	if (!navigator.getUserMedia)
		navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

	if (!navigator.cancelAnimationFrame)
		navigator.cancelAnimationFrame = navigator.webkitCancelAnimationFrame || navigator.mozCancelAnimationFrame;

	if (!navigator.requestAnimationFrame)
		navigator.requestAnimationFrame = navigator.webkitRequestAnimationFrame || navigator.mozRequestAnimationFrame;

	navigator.getUserMedia(
	{
	"audio": {
	    "mandatory": {
	        "googEchoCancellation": "false",
	        "googAutoGainControl": "false",
	        "googNoiseSuppression": "false",
	        "googHighpassFilter": "false"
	    },
	    "optional": []
	},
	}, gotStream, function(e) {
		alert('Error getting audio');
		console.log(e);
	});

}

function gotStream(stream) {
    inputPoint = audioContext.createGain();

    // Create an AudioNode from the stream.
    realAudioInput = audioContext.createMediaStreamSource(stream);
    audioInput = realAudioInput;
    audioInput.connect(inputPoint);

    analyserNode = audioContext.createAnalyser();
    analyserNode.fftSize = 2048;
    inputPoint.connect( analyserNode );

    audioRecorder = new Recorder( inputPoint );

    zeroGain = audioContext.createGain();
    zeroGain.gain.value = 0.0;
    inputPoint.connect( zeroGain );
    zeroGain.connect( audioContext.destination );

}

function beginAudioRecording()
{
	// start recording
    if (!audioRecorder)
    {
    	console.log("No audioRecorder found");
    	return;
    }

    console.log("starting recorder");
    audioRecorder.clear();
    audioRecorder.record();

    window.setTimeout(stopAudioRecording, 1000); //will record for only 10 seconds
}

function stopAudioRecording()
{
	audioRecorder.stop();
	audioRecorder.getBuffers( gotBuffers );
  	console.log("recorder stopped");
}

//Called when the audio stops recording or when the user calls requestData()
function saveAudioRecording()
{
	audioRecorder.exportWAV( doneEncoding );
}

function gotBuffers( buffers ) {

    // the ONLY time gotBuffers is called is right after a new recording is completed - 
    // so here's where we should set up the download.
    saveAudioRecording();
}

function doneEncoding( blob ) {

    uploadSoundBlob(blob);
    
}

function uploadSoundBlob(blob)
{

	console.log(blob);
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "file_upload_sound.php", true);

	xhttp.onreadystatechange = function() 
  	{
  		if (xhttp.readyState == 4 && xhttp.status == 200) {
  			var answer = xhttp.responseText;
  			console.log(answer);

            if(soundUploadComplete != null)
            {
                soundUploadComplete(answer);
            }
    	}
	}

	var formData = new FormData();
	formData.append("sound", blob);

	xhttp.send(formData);
	
}