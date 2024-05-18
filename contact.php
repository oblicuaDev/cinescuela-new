<?php 
    $bodyClass = "contact";
    include 'includes/head.php';
    include 'includes/header.php';
?>
<main>
    <form action="">
        <h2>Agenda un Demostración para tu Institución Educativa</h2>
        <span>
            <input type="text" placeholder="Nombre" name="" id="">
        </span>
        <span>
            <input type="text" placeholder="Nombre institución" name="" id="">
        </span>
        <span>
            <input type="text" placeholder="Correo electrónico" name="" id="">
        </span>
        <span>
            <input type="text" placeholder="Ciudad" name="" id="">
        </span>
        <label class="cyberpunk-checkbox-label">
            <input type="checkbox" class="cyberpunk-checkbox" />
            <small>
            He leído y acepto las políticas del sitio web , autorizo el tratamiento de mis datos personales y el envío de información de interés, publicidad y promociones.
            </small>
          </label>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</main>
<?php include 'includes/footer.php'; ?>