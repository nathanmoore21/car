<?php require_once 'config.php';

try {

  // The $rules array has 3 rules, festival_id must be present, must be an integer and have a minimum value of 1.  
  // note festival _id was passed in from festival_index.php when you chose a festival by clicking a radio button. 
  $rules = [
    'car_id' => 'present|integer|min:1'
  ];
  // $request->validate() is a function in HttpRequest(). You pass in the 3 rules above and it does it's magic. 
  $request->validate($rules);
  if (!$request->is_valid()) {
    throw new Exception("Illegal request");
  }

  // get the festival _id out of the request (remember it was passed in from festival_index.php)
  $car_id = $request->input('car_id');
 
  //Retrieve the festival object from the database by calling findById($festival_id) in the Festival.php class
  $car = Car::findById($car_id);
  if ($car === null) {
    throw new Exception("Illegal request parameter");
  }
} catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");

  // some exception/error occured so re-direct to the home page
  $request->redirect("/home.php");
}

?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>View Customer</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
  <div class="container-fluid p-0">
    <?php require 'include/navbar.php'; ?>
    <main role="main">
      <div>
        <div class="row d-flex justify-content-center">
          <h1 class="t-peta engie-head pt-5 pb-5">View Cars</h1>
        </div>

        <div class="row justify-content-center pt-4">
          <div class="col-lg-10">
            <form method="get">
              <!--This is how we pass the ID-->
              <input type="hidden" name="car_id" value="<?= $car->id ?>" />

              <!--Disabled so the user can't intereact. This form is for viewing only.-->
              <div class="form-group">
                <label class="labelHidden" for="ticketPrice">Title</label>
                <input placeholder="Title" type="text" id="title" class="form-control" value="<?= $car->title ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="date">Description</label>
                <textarea name="description" rows="3" id="description" class="form-control" disabled><?= $car->description ?></textarea>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="location">Location</label>
                <select class="form-control" name="location" id="location" disabled>
                  <!-- triple === means if it is equal. So is location is equal to "USA" display USA, if location is equal to "Belgium" display ...you get the idea..-->
                  <option value="USA" <?= (($car->location === "USA") ? "selected" : "") ?>>USA</option>
                  <option value="Belgium" <?= (($car->location === "Belgium") ? "selected" : "") ?>>Belgium</option>>
                  <option value="Brazil" <?= (($car->location === "Brazil") ? "selected" : "") ?>>Brazil</option>
                  <option value="UK" <?= (($car->location === "UK") ? "selected" : "") ?>>UK</option>
                  <option value="Germany" <?= (($car->location === "Germany") ? "selected" : "") ?>>Germany</option>
                  <option value="Japan" <?= (($car->location === "Japan") ? "selected" : "") ?>>Japan</option>
                  <option value="Netherlands" <?= (($car->location === "Netherlands") ? "selected" : "") ?>>Netherlands</option>
                  <option value="Hungary" <?= (($car->location === "Hungary") ? "selected" : "") ?>>Hungary</option>
                  <option value="Morocco" <?= (($car->location === "Morocco") ? "selected" : "") ?>>Morocco</option>
                  <option value="Spain" <?= (($car->location === "Spain") ? "selected" : "") ?>>Spain</option>
                  <option value="Canada" <?= (($car->location === "Canada") ? "selected" : "") ?>>Canada</option>
                  <option value="Croatia" <?= (($car->location === "Croatia") ? "selected" : "") ?>>Croatia</option>
                  <option value="Philippines" <?= (($car->location === "Philippines") ? "selected" : "") ?>>Philippines</option>
                </select>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueCapacity">Start Date</label>
                <input placeholder="Start Date" type="date" class="form-control" id="startDate" value="<?= $festival->start_date ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueCapacity">End Date</label>
                <input placeholder="End Date" type="date" class="form-control" id="endDate" value="<?= $festival->end_date ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Name</label>
                <input placeholder="Contact Name" type="text" id="contactName" class="form-control" value="<?= $festival->contact_name ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Email</label>
                <input placeholder="Contact Email" type="email" id="contactEmail" class="form-control" value="<?= $festival->contact_email ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Phone</label>
                <input placeholder="Contact Phone" type="text" id="contactPhone" class="form-control" value="<?= $festival->contact_phone ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Image</label>
                <?php
                try {
                  $image = Image::findById($car->image_id);
                } catch (Exception $e) {
                }
                if ($image !== null) {
                ?>
                  <img src="<?= APP_URL . "/" . $image->filename ?>" width="205px" alt="image" class="mt-2 mb-2" />
                <?php
                }
                ?>
              </div>

              <div class="form-group">
                <a class="btn btn-default" href="<?= APP_URL ?>/home.php">Cancel</a>
                <button class="btn btn-warning" formaction="<?= APP_URL ?>/car-edit.php">Edit</button>
                <button class="btn btn-danger btn-car-delete" formaction="<?= APP_URL ?>/car-delete.php">Delete</button>
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