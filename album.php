<?php
session_start();
include 'header.php';
?>
  <link rel="icon" href="favicon.ico" type="image/x-icon">

<title>ALBUM</title>

<body>
  <div class="box">
    <div class="conte">
      <div class="alb_conte">
        <div class="heading">
            <h1 style="color: black;">ALBUM</h1>
        </div>
        <div class="alb_box">
            <div class="alb">
            <img src="album/a1.jpg">
            <img src="album/a2.jpg">
            <img src="album/a3.jpg">
            </div>
            <div class="alb">
            <img src="album/a4.jpg">
            <img src="album/a5.jpg">
            <img src="album/a6.jpg">
            </div>
            <div class="alb">
            <img src="album/a7.jpg">
            <img src="album/a8.jpg">
            <img src="album/a9.jpg">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      include 'footer.php';
    ?>
  </div>
  <script src="overall.js"></script>
</body>
</html>