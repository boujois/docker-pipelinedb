<html>
<head>
  <title>PipelineDB Information</title>
  <link rel="stylesheet" type="text/css" href="css/markdown.css"/>
  <link rel="stylesheet" type="text/css" href="css/tables.css"/>
</head>
<body class="markdown-body">
  <?php
  $markdown=file_get_contents("md/info.md");
  echo $parsedown->text($markdown);
  ?>
</body>
</html>
