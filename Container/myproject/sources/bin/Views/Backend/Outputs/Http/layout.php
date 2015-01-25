<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Comivi Simple PHP Framework">
    <meta name="author" content="Comivi">
    <link rel="icon" href="/favicon.ico">

    <title><?php ( !isset( $title ) ? "Comivi SPF - Version ?" : "Comivi SPF | " . $title . " - Version ?" ) ?></title>
    <link href="/plugins/bootstrap-v3.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/backend.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <?php if( !isset( $is_exception ) || !$is_exception )
    {
      ?>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">MY PROJECT</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Users</a></li>
            </div>
          </div>
        </nav>

        <!-- Begin page content -->
        <div class="container">
          <div class="page-header">
            <?= $content ?>
          </div>
        </div>

        <footer class="footer">
          <div class="container">
            <br/>
            <?php echo date('Y') ; ?> © <a href="http://www.seres.fr/">SERES SA</a><br/>
          </div>
        </footer>
      <?php
    }
    else
    {
      ?>
        <div class="container">
          <div class="page-header">
            <h1>Oops, something wrong happened..!</h1>
          </div>
          <p class="lead">Here is the error : <br/><code><?= $exeption_output ?></code></p>
          <p>Report the incident : </p>
          <p>Return to <a href="../sticky-footer"> previous page </a></p>
        </div>
      <?php
    }

    ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/plugins/bootstrap-v3.3.1/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/plugins/bootstrap-v3.3.1/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>