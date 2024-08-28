<?php 
    $bodyClass = "contact";
    include 'includes/head.php';
    include 'includes/header.php';
?>
<main>
    <form action="<?=$_GET['lang']?>/s/set_lead/" method="POST" autocomplete="off" id="contact" class="active">
        <h2>Agenda un Demostración para tu Institución Educativa</h2>
        <span>
            <input type="text" placeholder="Nombre" name="name" id="name">
             <span class="error-message"></span>
        </span>
        <span>
            <input type="text" placeholder="Nombre institución" name="institucion" id="institucion">
             <span class="error-message"></span>
        </span>
        <span>
            <input type="text" placeholder="Correo electrónico" name="email" id="email">
             <span class="error-message"></span>
        </span>
        <span>
            <input type="text" placeholder="Ciudad" name="city" id="city">
             <span class="error-message"></span>
        </span>
        <label class="cyberpunk-checkbox-label" for="politics">
            <input type="checkbox" class="cyberpunk-checkbox" name="politics" id="politics" />
            <small>
            He leído y acepto las políticas del sitio web , autorizo el tratamiento de mis datos personales y el envío de información de interés, publicidad y promociones.
            </small>
          </label>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <div class="thanks">
        <h2>¡Gracias por contactarnos!</h2>
        <p>Nos comunicaremos contigo pronto.</p>
    </div>
</main>
<?php include 'includes/footer.php'; ?>