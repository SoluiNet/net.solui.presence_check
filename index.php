<?php
  $json_str = file_get_contents("config.json");

  $config = json_decode($json_str);
?>
<html>
  <head>
    <title>SoluiNet - Presence Tracker</title>
    <script src="https://kit.fontawesome.com/55eea1664e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
.status-badge {
  padding: 25px;
  border: 5px white solid;
}

.green {
  background-color: darkgreen;
  color: white;
}

.red {
  background-color: red;
  color: white;
}

.btn-primary {
  background-color: #303030;
  border-color: #303030;
}

.btn-primary:focus {
  background-color: #303030;
  border-color: #808080;
}

em {
  font-family: monospace;
}

.technical-details {
  background-color: black;
  color: white;
}
    </style>
  </head>
  <body>
    <div class="row">
<?php
  $i = 1;

  foreach($config->endpoints as &$endpoint){
    $output = '';
    $result = 1;

    exec("ping -c 2 " . $endpoint->ip, $output, $result);
?>
      <div class="col-md-6 status-badge <?=($result == 0 ? 'green' : 'red')?>">
        <h1><?=$endpoint->name?></h1>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSmartphone<?=$i?>" aria-expanded="false" aria-controls="collapseSmartphone<?=$i?>">More Details</button>
        <div class="collapse technical-details" id="collapseSmartphone<?=$i?>">
          <em>
<?php foreach($output as &$line) { printf('%s<br />', $line); } ?>
          </em>
        </div>
      </div>
<?php
    $i++;
  }
?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  </body>
</html>
