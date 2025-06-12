<!-- Static navbar -->
      <nav class="navbar navbar-default" role="navigation" style='margin-top: 10px;'>
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $v_url; ?>/home.php" style='padding-top: 15px;'><?php echo $v_tit; ?></a>
			
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

				<li><a href="<?php echo $v_url; ?>/inicio/">Início</a></li>
				<li><a href="<?php echo $v_url; ?>/cadastro.php">Cadastro de Pessoas</a></li>
				<li><a href="<?php echo $v_url; ?>/eventos/">Eventos</a></li>
			
			</ul>
            <ul class="nav navbar-nav navbar-right">
              
              <li><a href="<?php echo $v_url; ?>/sair/">Sair</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>