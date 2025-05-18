	<div class="span9" style="margin-left: auto; margin-right:auto; margin-top: 70px; margin-bottom: auto;">
      <form action="../admin/index.php" name="registro" id="registro" method="POST">
        <fieldset>
          <legend>Error en el Inicio de sesión</legend>
			<br> <br>
          <div class="clearfix">
          <p style="color:red; font-size: 12pt"><strong>Error al iniciar sesión </strong></p>
           <strong>El usuario o contraseña fueron válidados y no corresponde a ningún usuario registrado, por favor verfique sus datos y reintente.</strong>

          </div><!-- /clearfix -->
    
          <div class="actions" style="background-color: transparent">
            <input class="btn primary" value="Reintentar" onclick="window.location.href='./?page=login'" type="button">&nbsp;
            <input class="btn" value="Regresar" type="button" onclick="window.location.href='./'">
          </div>

        </fieldset>
        <input type="hidden" name="MM_insert" value="registro" />
      </form>
    </div>

  