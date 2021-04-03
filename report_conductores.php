<?php

$and=$_REQUEST["and"];
$genero;
$edad;
$empresa;
$where ='';


if($and == 1){
  if(isset($_REQUEST['gen_con'])){
    $genero = $_REQUEST['gen_con'];
    if ($genero == 0 || $genero ==1 ){
      $where="WHERE c.gen_con = '$genero'";
    }
  }

  if(isset($_REQUEST['edad_con'])){
    $edad = $_REQUEST['edad_con'];
    if ($edad != "" ){
      if($where == ""){
          $where="WHERE c.edad_con = '$edad'";
      }

      else {
        $where = "$where AND c.edad_con = '$edad'";
      }

    }
  }
  if(isset($_REQUEST['nom_emp'])){
    $empresas = $_REQUEST['nom_emp'];
    if ($empresas != "1" ){
      if($where == ""){
          $where="WHERE e.nom_emp = '$empresas'";
      }

      else {
        $where = "$where AND e.nom_emp = '$empresas'";
      }

    }
  }

}

else {
  if(isset($_REQUEST['gen_con'])){
    $genero = $_REQUEST['gen_con'];
    if ($genero == 0 || $genero ==1 ){
      $where="WHERE c.gen_con = '$genero'";
    }
  }

  if(isset($_REQUEST['edad_con'])){
    $edad = $_REQUEST['edad_con'];
    if ($edad != "" ){
      if($where == ""){
          $where="WHERE c.edad_con = '$edad'";
      }

      else {
        $where = "$where OR c.edad_con = '$edad'";
      }

    }
  }
  if(isset($_REQUEST['nom_emp'])){
    $empresas = $_REQUEST['nom_emp'];
    if ($empresas != "1" ){
      if($where == ""){
          $where="WHERE e.nom_emp = '$empresas'";
      }

      else {
        $where = "$where OR e.nom_emp = '$empresas'";
      }

    }
  }
}



  $host = "localhost";
  $dbname = "tim";
  $username = "root";
  $password = "";

  $cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);



  $sql = "SELECT cod_cond,nom_cond,tel_cond,gen_con,edad_con,nom_emp FROM conductores as c JOIN empresas e ON c.nit_emp = e.nit_emp $where";

  $q = $cnx->prepare($sql);

  $result = $q->execute();

  $conductores = $q->fetchAll();

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
  <form action="/ConsultasTIM/report_conductores.php" method="get">
  <div class="form-group">
    <label for="genero">Genero</label>
    <select class="form-control" name="gen_con" placeholder="Seleccione">>
      <option value="2">TODOS</option>
      <option value="0">Femenino</option>
      <option value="1">Masculino</option>
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
    <label for="nit_emp">Empresa donde Labora </label>
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
    <label for="Edad">Edad</label>
    <input type="text" class="form-control" name="edad_con" placeholder="Ingrese Edad">
  </div>

    <button type="submit" class="btn btn-primary" id="and" name="and" value="1">AND</button>
      <button type="submit" class="btn btn-primary" id="and" name="and" value="0">OR</button>
</form>

  <div class="container">
  <h2>Reportes conductores</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Genero</th>
        <th>Edad</th>
        <th>Empresa</th>
      </tr>
    </thead>
    <tbody>
      <?php
        for ($i=0; $i < count($conductores); $i++) {
      ?>
      <tr>
        <td><?php echo $conductores[$i]["cod_cond"] ?></td>
        <td><?php echo $conductores[$i]["nom_cond"] ?></td>
        <td><?php echo $conductores[$i]["tel_cond"] ?></td>
        <td><?php
              $genero =  $conductores[$i]["gen_con"];
                  if ($genero == "0") {
                    echo "Femenino";
                  }
                  else {
                    echo "Masculino";
                  }

            ?></td>
        <td><?php echo $conductores[$i]["edad_con"] ?></td>
        <td><?php echo $conductores[$i]["nom_emp"] ?></td>
      </tr>


      <?php
        }
       ?>

    </tbody>
  </table>
</div>
</body>
</html>
