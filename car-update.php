<?php
require_once 'config.php';

try {
    // $request = new HttpRequest();

    $locations = [
        "USA",  "Belgium", "Brazil", "UK",
        "Hungary", "Morocco", "Spain",
        "Germany", "Japan", "Netherlands",
        "Canada", "Croatia", "Philippines"
    ];

    $rules = [
        "car_id" => "present|integer|min:1",
        "make" => "present|minlength:2|maxlength:64",
        // "description" => "present|minlength:20|maxlength:2000",
        "model" => "present|in:" . implode(',', $model),
        // "start_date" => "present|minlength:10|maxlength:10",
        // "end_date" => "present|minlength:10|maxlength:10",
        "price" => "present|minlength:4|maxlength:255",
        "engine_size" => "present|email|minlength:7|maxlength:255",
        //2 or 3 digits then a -, then between 5 to 7 more numbers
        // "contact_phone" => "present|match:/\A[0-9]{2,3}[-][0-9]{5,7}\Z/",

    ];

    $request->validate($rules);
    if ($request->is_valid()) {
        $image = null;
        if (FileUpload::exists('profile')) {
            //If a file was uploded for profile,
            //create a FileUpload object
            $file = new FileUpload("profile");
            $filename = $file->get();
            //Create a new image object and save it.
            $image = new Image();
            $image->filename = $filename;

            // you must implement save() function in the Image.php class
            $image->save();
        }
        $car = Car::findById($request->input("car_id"));
        $car->make = $request->input("make");
        // $car->description = $request->input("description");
        $car->model = $request->input("model");
        // $car->start_date = $request->input("start_date");
        // $car->end_date = $request->input("end_date");
        $car->price = $request->input("price");
        $car->engine_size = $request->input("engine_size");
        // $car->contact_phone = $request->input("contact_phone");
        /*If not null, the user must have uploaded an image, so reset the image id to that of the one we've just uploaded.*/
        if ($image !== null) {
            $car->image_id = $image->id;
        }

        // you must implement the save() function in the Festival class
        $car->save();

        $request->session()->set("flash_message", "The car was successfully updated in the database");
        $request->session()->set("flash_message_class", "alert-info");
        /*Forget any data that's already been stored in the session.*/
        $request->session()->forget("flash_data");
        $request->session()->forget("flash_errors");

        $request->redirect("/car-index.php");
    } else {
        $car_id = $request->input("car_id");
        /*Get all session data from the form and store under the key 'flash_data'.*/
        $request->session()->set("flash_data", $request->all());
        /*Do the same for errors.*/
        $request->session()->set("flash_errors", $request->errors());

        $request->redirect("/car-edit.php?car_id=" . $car_id);
    }
} catch (Exception $ex) {
    //redirect to the create page...
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");
    $request->session()->set("flash_data", $request->all());
    $request->session()->set("flash_errors", $request->errors());

    // not yet implemented
    $request->redirect("/car-create.php");
}
