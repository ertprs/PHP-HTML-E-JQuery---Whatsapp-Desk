<!DOCTYPE html>
<html lang="en">
    
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>        
        <title>Painel De Controle</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="img/favicon.png" type="image/x-icon" />

        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->

<style>
body {
  font-size: 12px;
  padding: 0px;
  margin: 0px;
  height: 100%;
  min-height: 100%;
  /*background: #000000;*/
  background-repeat: no-repeat;
  background-size: 100% 100%;
  background-image:url(img/login.jpg);
  font-family: 'Open Sans', sans-serif;
}
</style>
        
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
                
        <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>

        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/demo.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>        

    </head>
<script>
      document.onkeypress = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
          return false;
        }
      }
      document.onmousedown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
          return false;
        }
      }
      document.onkeydown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
          return false;
        }
      }
 </script>

<body oncontextmenu="return false">
        
        <div class="page-container">
            
            <div style="margin-top:15%;">

                <div class="block-login">
                    <?php /*
                    <div class="block-login-logo">
                        <a class="logo">WhatsCompany</a>
                    </div>
					*/ ?>
                    <div class="block-login-content">
                        <h1>Área Administrativa</h1>
                        <div align="center" style="padding:10px;">
						<?php
                        	if(isset($_GET['mensagem']))
                        	{
                        		echo "<font color='#FF0000' class='caixa' size='3'>".$_GET['mensagem']."</font>";
                        	}
                        ?>
                        </div>
                        <form id="signinForm" method="post" action="sistema">
                            
                        <div class="form-group">                        
                            <input type="text" name="email_adm" autocomplete="off" autofocus class="form-control" placeholder="Usuário" value="" required/>
                        </div>
                        <div class="form-group">                        
                            <input type="password" name="pass_adm" autocomplete="off" class="form-control" placeholder="Senha" value="" required/>
                        </div>

                        <button class="btn btn-primary btn-block" type="submit">ACESSAR</button>                                        
                        
                        </form>
                        <div class="sp"></div>


                        <div class="sp"></div>
                        <div class="pull-left">
                            <a href="esqueci_senha">Esqueci minha senha</a>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
        
        <script type="text/javascript">
        $("#signinForm").validate({
		rules: {
			login: "required",
			pass_admword: "required"
		},
		messages: {
			firstname: "Informe seu usuário",
			lastname: "Informe sua senha"			
		}
	});            
        </script>
        
    </body>

</html>