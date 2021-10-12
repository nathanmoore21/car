<?php require_once 'config.php'; ?>
<?php 
$cars = Car::findAll();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cars</title>

    <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <?php require 'include/header.php'; ?>
      <?php require 'include/navbar.php'; ?>
      <main role="main">
        <div>
          <h1>Our Cars</h1>
          <div class="row">
          <?php foreach ($cars as $car) { ?>
            <div class="col mb-4">
              <div class="card" style="width:15rem;">
              <?php
                  // Use the image ID in festival, go to the Image table and get the image file name which includes the file location 
                  $car_image = Image::findById($car->image_id);
                  if ($car_image !== null) {
                  ?>
                    <!-- use the filename/location to display the correct image-->
                    <img src="<?= APP_URL . "/" . $car_image->filename ?>" class="card-img-top" alt="...">
                  <?php
                  }
                  ?>
                <div class="card-body">
                  <!-- <h5 class="card-title"><?= $car->id ?></h5>
                  <p class="card-text"><?= get_words($car->make, 20) ?></p> -->
                  <h5 class="card-title"><?= $car->make ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Model: <?= $car->model ?></li>
                  <li class="list-group-item"> Price: <?= $car->price ?></li>
                  <li class="list-group-item">Engine Size: <?= $car->engine_size ?></li>
                </ul>
              </div>
            </div>
          <?php } ?>
          </div>
        </div>
      </main>
      <?php require 'include/footer.php'; ?>
    </div>
    <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
