<?php
$host = "localhost";
$dbname = "tim";
$username = "root";
$password = "";

$cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$sql = "SELECT placa,est_veh,nom_emp,nom_prop FROM vehiculos as v JOIN empresas as e ON v.nit_emp = e.nit_emp JOIN propietarios as p ON v.cod_prop = p.cod_prop";

$q = $cnx->prepare($sql);

$result = $q->execute();

$vehiculos = $q->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>TIM</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <form action="/report_vehiculos.php" method="get">
  <div class="form-group">
    <label for="$estado">Estado</label>
    <select class="form-control" name="est_veh" placeholder="Seleccione">>
      <option value="2">TODOS</option>
      <option value="0">Inactivo</option>
      <option value="1">Activo</option>
    </select>
    </div>

    <?php
    $host = "localhost";
    $dbname = "tim";
    $username = "root";
    $password = "";

    $cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);



      $emp = "SELECT nit_emp, nom_emp FROM empresas";

      $q = $cnx->prepare($emp);

      $result = $q->execute();

      $empresas = $q->fetchAll();

      ?>

      <div class="form-group">
        <label for="nit_emp">Empresa</label>
        <select class="form-control" name="nom_emp" placeholder="Seleccione">>
          <option value ="1">Seleccionar</option>
          <?php
          for ($i=0; $i <count($empresas) ; $i++) {
          ?>
          <option value="<?php echo $empresas[$i]["nom_emp"]?>">
            <?php echo $empresas[$i]["nom_emp"] ?>
          </option>
          <?php
          }
           ?>
         </select>
      </div>

      <div class="form-group">
        <label for="Nombre">Propietario</label>
        <input type="text" class="form-control" name="nom_prop" placeholder="Ingrese Nombre">
      </div>

        <button type="submit" class="btn btn-primary" id="and" name="and" value="1">AND</button>
          <button type="submit" class="btn btn-primary" id="and" name="and" value="0">OR</button>
    </form>


  <div class="container">
  <h2>Reportes Vehiculos</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Placa</th>
        <th>Nombre empresa</th>
        <th>Nombre propietarios</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      <?php
        for ($i=0; $i < count($vehiculos); $i++) {
      ?>
      <tr>
        <td><?php echo $vehiculos[$i]["placa"] ?></td>
        <td><?php echo $vehiculos[$i]["nom_emp"] ?></td>
        <td><?php echo $vehiculos[$i]["nom_prop"] ?></td>
        <td><?php
              $estado =  $vehiculos[$i]["est_veh"];
                  if ($estado== "0") {
                    echo "Inactivo";
                  }
                  else {
                    echo "Activo";
                  }

            ?></td>
      </tr>


      <?php
        }
       ?>

    </tbody>
  </table>
</div>
</body>
</html>
