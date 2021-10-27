<?php require_once 'config.php';

try {
  $rules = [
    'car_id' => 'present|integer|min:1'
  ];
  $request->validate($rules);
  if (!$request->is_valid()) {
    throw new Exception("Illegal request");
  }
  $car_id = $request->input('car_id');
  /*Retrieving a customer object*/
  $car = Car::findById($car_id);
  if ($car === null) {
    throw new Exception("Illegal request parameter");
  }
} catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");

  $request->redirect("/car-index.php");
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Car</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/form.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
  <div class="container-fluid p-0">
    <?php require 'include/navbar.php'; ?>
    <main role="main">
      <div>
        <div class="row d-flex justify-content-center">
          <h1 class="t-peta engie-head pt-5 pb-5">Edit Car</h1>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <?php require "include/flash.php"; ?>
          </div>
        </div>

        <div class="row justify-content-center pt-4">
          <div class="col-lg-10">
            <form method="post" action="<?= APP_URL ?>/car-update.php" enctype="multipart/form-data">

              <!--This is how we pass the ID-->
              <input type="hidden" name="car_id" value="<?= $car->id ?>" />


              <div class="form-group">
                <label class="labelHidden" for="ticketPrice">id</label>
                <input placeholder="id" name="id" type="text" id="id" class="form-control" value="<?= old('id', $car->id) ?>" />
                <span class="error"><?= error("id") ?></span>
              </div>

              <!--textarea does not have a 'value' attribute, so in this case we have to put our php for filling in the old form data INSIDE the textarea tag.-->
              <div class="form-group">
                <label class="labelHidden" for="date">Make</label>
                <textarea placeholder="Make" name="make" rows="3" id="make" class="form-control"><?= old('make', $car->make) ?></textarea>
                <span class="error"><?= error("make") ?></span>
              </div>

              <div class="form-group">
                <label class="t-deci" for="model">Select your model</label>
                <select class="form-control" name="model" id="model">
                  <!--Check to see if the data in our form value was this location.-->
                  <option value="USA" <?= chosen("model", "USA", $car->model) ? "selected" : "" ?>>USA</option>
                  <option value="Belgium" <?= chosen("model", "Belgium", $car->model) ? "selected" : "" ?>>Belgium</option>
                  <option value="Brazil" <?= chosen("model", "Brazil", $car->model) ? "selected" : "" ?>>Brazil</option>
                  <!-- <option value="UK" <?= chosen("model", "UK", $car->model) ? "selected" : "" ?>>UK</option>
                  <option value="Germany" <?= chosen("model", "Germany", $car->model) ? "selected" : "" ?>>Germany</option>
                  <option value="Japan" <?= chosen("model", "Japan", $car->model) ? "selected" : "" ?>>Japan</option>
                  <option value="Netherlands" <?= chosen("model", "Netherlands", $car->model) ? "selected" : "" ?>>Netherlands</option>
                  <option value="Hungary" <?= chosen("model", "Hungary", $car->model) ? "selected" : "" ?>>Hungary</option>
                  <option value="Morocco" <?= chosen("model", "Morocco", $car->model) ? "selected" : "" ?>>Morocco</option>
                  <option value="Spain" <?= chosen("model", "Spain", $car->model) ? "selected" : "" ?>>Spain</option>
                  <option value="Canada" <?= chosen("model", "Canada", $car->model) ? "selected" : "" ?>>Canada</option>
                  <option value="Croatia" <?= chosen("model", "Croatia", $car->model) ? "selected" : "" ?>>Croatia</option>
                  <option value="Philippines" <?= chosen("model", "Philippines", $car->model) ? "selected" : "" ?>>Philippines</option> -->
                </select>
                <span class="error"><?= error("model") ?></span>
              </div>

              <!-- <div class="form-group">
                <label class="labelHidden" for="startDate">Start Date</label>
                <input placeholder="Start Date" type="date" name="start_date" class="dateInput form-control" id="startDate" value="<?= old("start_date", $car->start_date) ?>" />
                <span class="error"><?= error("start_date") ?></span>
              </div> -->

              <!-- <div class="form-group">
                <label class="labelHidden" for="endDate">End Date</label>
                <input placeholder="End Date" type="date" name="end_date" class="dateInput form-control" id="endDate" value="<?= old("end_date", $car->end_date) ?>" />
                <span class="error"><?= error("end_date") ?></span>
              </div> -->

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Price</label>
                <input placeholder="Price" type="text" name="price" id="price" class="form-control" value="<?= old("price", $car->price) ?>" />
                <span class="error"><?= error("price") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Engine Size</label>
                <input placeholder="Contact Email" type="engine_size" name="engine_size" id="engineSize" class="form-control" value="<?= old("engine_size", $car->engine_size) ?>" />
                <span class="error"><?= error("engine_size") ?></span>
              </div>

              <!-- <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Phone</label>
                <input placeholder="Contact Phone" type="text" name="contact_phone" id="contactPhone" class="form-control" value="<?= old("contact_phone", $car->contact_phone) ?>" />
                <span class="error"><?= error("contact_phone") ?></span>
              </div> -->


              <div class="form-group">
                <label>Car image:</label>
                <?php
                $image = Image::findById($car->image_id);
                if ($image != null) {
                ?>
                  <img src="<?= APP_URL . "/" . $image->filename ?>" width="150px" />
                <?php
                }
                ?>
                <input type="file" name="profile" id="profile" />
                <span class="error"><?= error("profile") ?></span>
              </div>

              <div class="form-group">
                <a class="btn btn-default" href="<?= APP_URL ?>/car-index.php">Cancel</a>
                <button type="submit" class="btn btn-primary">Store</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <?php require 'include/footer.php'; ?>
  </div>
  <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/car.js"></script>

  <script src="https://kit.fontawesome.com/fca6ae4c3f.js" crossorigin="anonymous"></script>

</body>

</html>