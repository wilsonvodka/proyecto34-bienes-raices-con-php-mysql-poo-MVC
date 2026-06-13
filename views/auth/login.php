
<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesión</h1>
    <?php foreach($errores as $error):?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ; ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
            <legend>Email y password</legend>


            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Tu email">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Tu password">
        </fieldset>
        <input type="submit" value="Iniciar sesión" class="boton boton-verde">
    </form>

</main>