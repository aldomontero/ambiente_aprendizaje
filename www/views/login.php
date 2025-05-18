	<div class="span9" style="margin-left: auto; margin-right:auto; margin-top: 70px; margin-bottom: auto;">
      <form action="./admin/index.php" name="registro" id="registro" method="POST">
        <fieldset>
          <legend>Inicio de sesión para usuarios</legend>
          <br><br>
          <div class="clearfix">
            <label for="login_usuario"><strong>Usuario:  </strong></label>
            <div class="input">
              <input type="text" name="login_usuario" id="login_usuario">
            </div>
          </div><!-- /clearfix -->

          <div class="clearfix">
            <label for="password"><strong>Contraseña:  </strong></label>
            <div class="input">
              <input type="password" name="contrasena" id="contrasena">
            </div>
          </div><!-- /clearfix -->
    
          <div class="actions" style="background-color: transparent">
            <input class="btn primary" value="Continuar" type="submit">&nbsp;
            <input class="btn" value="Regresar" type="button" onclick="window.location.href='./'">
          </div>

        </fieldset>
        <input type="hidden" name="MM_insert" value="registro" />
      </form>
    </div>
   