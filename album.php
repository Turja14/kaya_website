<?php
include 'userfunction.php'; // for getAll()

include 'header.php';
include 'connection.php';
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
          <?php
          $images = getAll("album_images");

          if (mysqli_num_rows($images) > 0) {
              // Initialize 3 columns
              $column1 = [];
              $column2 = [];
              $column3 = [];

              $i = 0;
              foreach ($images as $item) {
                  if ($item['status'] == 0) {
                      $imgTag = '<img src="upload/' . htmlspecialchars($item['image_path']) . '">';
                      if ($i % 3 == 0) {
                          $column1[] = $imgTag;
                      } elseif ($i % 3 == 1) {
                          $column2[] = $imgTag;
                      } else {
                          $column3[] = $imgTag;
                      }
                      $i++;
                  }
              }

              // Print columns
              echo '<div class="alb">';
              echo implode('', $column1);
              echo '</div>';

              echo '<div class="alb">';
              echo implode('', $column2);
              echo '</div>';

              echo '<div class="alb">';
              echo implode('', $column3);
              echo '</div>';
          } else {
              echo '<p style="text-align:center; font-size: 1.5rem; color: gray;">No album images found.</p>';
          }
          ?>
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
  </div>
  <script src="overall.js"></script>
</body>
</html>
