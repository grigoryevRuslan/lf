<?php

    if (isset($_FILES["fileToUpload"])) {
      $allowedExts = array("gif", "jpeg", "jpg", "png");
      $temp = explode(".", $_FILES["fileToUpload"]["name"]);
      $extension = end($temp);
      if ((($_FILES["fileToUpload"]["type"] == "image/gif")
      || ($_FILES["fileToUpload"]["type"] == "image/jpeg")
      || ($_FILES["fileToUpload"]["type"] == "image/jpg")
      || ($_FILES["fileToUpload"]["type"] == "image/pjpeg")
      || ($_FILES["fileToUpload"]["type"] == "image/x-png")
      || ($_FILES["fileToUpload"]["type"] == "image/png"))
      && ($_FILES["fileToUpload"]["size"] < 1000000)
      && in_array($extension, $allowedExts))
        {
        if ($_FILES["fileToUpload"]["error"] > 0)
          {
          echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br>";
          }
        else 
          {

            $fileName = $temp[0].".".$temp[1];
            $temp[0] = rand(0, 3000); //Set to random number
            $fileName;

          if (file_exists("upload/" . $_FILES["fileToUpload"]["name"]))
            {
                  echo $_FILES["fileToUpload"]["name"] . " already exists. ";
            }
            else
            {
              
                $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "upload/" . $newfilename);
            }
          }
        }
      }
?>