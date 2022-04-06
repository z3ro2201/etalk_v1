if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
  navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
    var video = document.getElementById('video');
    video.srcObject = stream;
    video.play();
  });
}

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');
document.getElementById("webcamBtn").addEventListener("click",function() {
  context.drawImage(video,0,0,960,720);
});