<?php
// the class Car defines the structure of what every car object will look like. ie. each festival will have an id, title, description etc...
// NOTE : For handiness I have the very same spelling as the database attributes
class Car {
  public $id;
  public $make;
  public $model;
  public $price;
  public $engine_size;
  public $image;

  public function __construct() {
    $this->id = null;
  }

  public function save() {
    throw new Exception("Not yet implemented");
  }

  public function delete() {
    throw new Exception("Not yet implemented");
  }

  public static function findAll() {
    $cars = array();

    try {
      // call DB() in DB.php to create a new database object - $db
      $db = new DB();
      $db->open();
      // $conn has a connection to the database
      $conn = $db->get_connection();
      

      // $select_sql is a variable containing the correct SQL that we want to pass to the database
      $select_sql = "SELECT * FROM Car";
      $select_stmt = $conn->prepare($select_sql);
      // $the SQL is sent to the database to be executed, and true or false is returned 
      $select_status = $select_stmt->execute();

      // if there's an error display something sensible to the screen. 
      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }
      // if we get here the select worked correctly, so now time to process the festivals that were retrieved
      

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        while ($row !== FALSE) {
          // Create $festival object, then put the id, title, description, location etc into $festival
          $car = new Car();
          $car->id = $row['id'];
          $car->make = $row['make'];
          $car->model = $row['model'];
          $car->price = $row['price'];
          $car->engine_size = $row['engine_size'];
          // $car->image = $row['image'];

          // $festival now has all it's attributes assigned, so put it into the array $festivals[] 
          $cars[] = $car;
          
          // get the next festival from the list and return to the top of the loop
          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        }
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    // return the array of $festivals to the calling code - index.php (about line 6)
    return $cars;
  }

  public static function findById($id) {
    throw new Exception("Not yet implemented");
  }
}
?>
