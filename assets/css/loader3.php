<?php
header("Content-Type: text/css");

include('../../connection/dbconfig.php');

$query = "SELECT * FROM system LIMIT 1";
$statement = $conn->prepare($query);
$statement->execute();
$site = $statement->fetch(PDO::FETCH_OBJ);

$hexColor = $site->site_color;
$hexColor2 = $site->site_color2;
$opacity = 0.85; // Set your desired opacity value

// Convert hex to rgba
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$rgbaColor = "rgba($r, $g, $b, $opacity)";

list($r, $g, $b) = sscanf($hexColor2, "#%02x%02x%02x");
$rgbaColor2 = "rgba($r, $g, $b, $opacity)";

?>


.loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: <?php echo $rgbaColor; ?>;
    transition: opacity 2.55s, visibility 2.55s;
    z-index: 1;
  }
  
  .loader--hidden {
    opacity: 0;
    visibility: hidden;
  }
  
  .loader::after {
    content: "";
    width: 75px;
    height: 75px;
    border: 10px solid #dddddd;
    border-top-color: <?php echo $hexColor; ?>;
    border-radius: 50%;
    animation: loading 1.75s ease infinite;
  }
  
  
  
  .loader1 {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: black;
      transition: opacity 0.75s, visibility 0.75s;
      z-index: 1;
    }
    
    .loader1--hidden {
      opacity: 0;
      visibility: hidden;
    }
    
    .loader1::after {
      content: "";
      width: 75px;
      height: 75px;
      border: 6px solid <?php echo $hexColor; ?>;
      border-top-color: black;
      border-radius: 50%;
      animation: loading 0.75s ease infinite;
    }
    
  
  @keyframes loading {
    from {
      transform: rotate(0turn);
    }
    to {
      transform: rotate(1turn);
    }
  }
  