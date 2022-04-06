<!DOCTYPE html>
<html>
  <head>
    <style>
      body {
        background: black;
        color:#CCCCCC;
      }
      #c2 {
        background-image: url(foo.png);
        background-repeat: no-repeat;
      }
      div {
        float: left;
        border :1px solid #444444;
        padding:10px;
        margin: 10px;
        background:#3B3B3B;
      }
    </style>
    <script type="text/javascript" src="/assets/camera/camera.js"></script>
  </head>

  <body>
<video id="video" width="320" height="240" autoplay></video>
<canvas id="canvas" width="960" height="720"></canvas>
<button type="button" id="webcamBtn">캡쳐하기</button>
  </body>
</html>