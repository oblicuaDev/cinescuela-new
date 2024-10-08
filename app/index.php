<?php 
    $bodyClass = "login";
    include 'includes/head.php';
?>
    <main>
        <form action="<?=$_GET['lang']?>/s/login/" method="POST" autocomplete="off" id="login" class="active">
            <img src="images/logo.png" alt="logo">
            <div class="formcontent">
                <h2><?=$sdk->find_array($json,13, $lang)?></h2>
                <p><?=$sdk->find_array($json,120, $lang)?></p>
                <span>
                    <label for="username"><?=$sdk->find_array($json,14, $lang)?></label>
                    <input autocomplete="off" type="text" placeholder="tucorreo@correo.com" name="username" id="username">
                    <span class="error-message"></span>
                </span>
                <span>
                    <label for="password"><?=$sdk->find_array($json,15, $lang)?></label>
                    <input autocomplete="off" type="password" name="password" id="password">
                    <span class="error-message"></span>
                    <button class="show" type="button"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.27145 5.39645C3.46336 4.20453 5.33371 3 8 3C10.6663 3 12.5366 4.20453 13.7286 5.39645C14.3231 5.99096 14.7518 6.58461 15.0325 7.03047C15.1731 7.25379 15.2773 7.44117 15.3472 7.57464C15.3822 7.64141 15.4086 7.69479 15.4268 7.73255C15.4359 7.75144 15.4429 7.76643 15.4479 7.77725L15.4539 7.79032L15.4558 7.79445L15.4564 7.7959L15.4567 7.79646C15.4568 7.79671 15.4569 7.79693 15 8C15.4569 8.20307 15.4568 8.20329 15.4567 8.20354L15.4564 8.2041L15.4558 8.20555L15.4539 8.20968L15.4479 8.22275C15.4429 8.23357 15.4359 8.24856 15.4268 8.26745C15.4086 8.30521 15.3822 8.35859 15.3472 8.42536C15.2773 8.55883 15.1731 8.74621 15.0325 8.96953C14.7518 9.41539 14.3231 10.009 13.7286 10.6036C12.5366 11.7955 10.6663 13 8 13C5.33371 13 3.46336 11.7955 2.27145 10.6036C1.67693 10.009 1.24824 9.41539 0.967509 8.96953C0.826899 8.74621 0.722698 8.55883 0.652787 8.42536C0.617813 8.35859 0.591364 8.30521 0.573181 8.26745C0.564087 8.24856 0.557055 8.23357 0.552053 8.22275L0.546066 8.20968L0.544205 8.20555L0.543556 8.2041L0.543302 8.20354C0.543194 8.20329 0.543094 8.20307 1 8C0.543094 7.79693 0.543194 7.79671 0.543302 7.79646L0.543556 7.7959L0.544205 7.79445L0.546066 7.79032L0.552053 7.77725C0.557055 7.76643 0.564087 7.75144 0.573181 7.73255C0.591364 7.69479 0.617813 7.64141 0.652787 7.57464C0.722698 7.44117 0.826899 7.25379 0.967509 7.03047C1.24824 6.58461 1.67693 5.99096 2.27145 5.39645ZM1 8L0.543094 7.79693C0.485635 7.92621 0.485635 8.07379 0.543094 8.20307L1 8ZM1.55906 8C1.61788 8.11018 1.70235 8.25981 1.81374 8.43672C2.06426 8.83461 2.44807 9.36596 2.97855 9.89645C4.03664 10.9545 5.66629 12 8 12C10.3337 12 11.9634 10.9545 13.0214 9.89645C13.5519 9.36596 13.9357 8.83461 14.1863 8.43672C14.2976 8.25981 14.3821 8.11018 14.4409 8C14.3821 7.88982 14.2976 7.74019 14.1863 7.56328C13.9357 7.16539 13.5519 6.63404 13.0214 6.10355C11.9634 5.04547 10.3337 4 8 4C5.66629 4 4.03664 5.04547 2.97855 6.10355C2.44807 6.63404 2.06426 7.16539 1.81374 7.56328C1.70235 7.74019 1.61788 7.88982 1.55906 8ZM15 8L15.4569 8.20307C15.5144 8.07379 15.5144 7.92621 15.4569 7.79693L15 8Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8 6C6.89543 6 6 6.89543 6 8C6 9.10457 6.89543 10 8 10C9.10457 10 10 9.10457 10 8C10 6.89543 9.10457 6 8 6ZM5 8C5 6.34315 6.34315 5 8 5C9.65685 5 11 6.34315 11 8C11 9.65685 9.65685 11 8 11C6.34315 11 5 9.65685 5 8Z"
                                fill="currentColor" />
                        </svg></button>
                        
                </span>
                <span class="error-message error-user"></span>
                <!-- <button type="button" onclick="toggleForms()"><?=$sdk->find_array($json,22, $lang)?></button> -->
                <button type="submit" class="btn btn-primary"><?=$sdk->find_array($json,13, $lang)?></button>
                <!-- <small>Sácale el jugo al cine</small> -->
            </div>
            <a href="/es/contacto">¿Necesitas ayuda para iniciar sesión?</a>
        </form>
        <!-- <form action="<?=$_GET['lang']?>/s/forgot_bridge/" method="POST" autocomplete="off" id="forgotForm">
            <img src="images/logo.png" alt="logo">
            <div class="formcontent">
                <h2><?=$sdk->find_array($json,24, $lang)?></h2>
                <span>
                    <label for="username"><?=$sdk->find_array($json,14, $lang)?></label>
                    <input autocomplete="off" type="text" placeholder="Ejemplo" name="username" id="username">
                    <span class="error-message"></span>
                </span>
                <span class="error-message error-user"></span>
                <button type="button" onclick="toggleForms()"><?=$sdk->find_array($json,32, $lang)?></button>
                <button type="submit" class="btn btn-primary"><?=$sdk->find_array($json,24, $lang)?></button>
            </div>
        </form> -->
    </main>
<?php include 'includes/footer.php'; ?>