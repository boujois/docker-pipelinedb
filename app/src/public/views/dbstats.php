<html>
<head>
    <title>DB Stats</title>
    <link rel="stylesheet" type="text/css" href="css/tables.css"/>
</head>

<body>
  <h3>Continuous Views</h3>
  <table border=1>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Active</th>
        <th>Query</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $pdo=$this->get('db');
      $result = $pdo->query("SELECT * from pipelinedb.views;");
      while ($row = $result->fetch()){
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["active"]."</td>";
        echo "<td><pre>".$row["query"]."</pre></td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
