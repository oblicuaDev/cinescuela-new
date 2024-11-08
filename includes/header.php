<header>
    <div class="container">
        <div class="left">
            <a href="" class="logo">
                <img src="images/logo.png" alt="logo">
            </a>
            <button class="c-hamburger c-hamburger--htx"><span>toggle menu</span></button>
            <nav class="sub-menu open">
                <a href=""><span>Inicio</span></a>
                <a href="<?=$lang?>/peliculas"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.62624 1.875H16.25C16.5952 1.875 16.875 2.15482 16.875 2.5V15C16.875 15.3452 16.5952 15.625 16.25 15.625H5.62502L5.6224 15.625C5.45839 15.6243 5.29588 15.6561 5.14423 15.7185C4.99258 15.781 4.8548 15.8728 4.73883 15.9888C4.62286 16.1048 4.53101 16.2426 4.46856 16.3942C4.40759 16.5423 4.37584 16.7007 4.37502 16.8608V16.875C4.37502 17.2197 4.09599 17.4993 3.75133 17.5C3.40666 17.5007 3.12647 17.2223 3.12502 16.8776C3.12499 16.8711 3.12499 16.8646 3.12502 16.8581V4.37622M4.37502 14.7066C4.46932 14.6524 4.56728 14.6043 4.6683 14.5627C4.97208 14.4376 5.29759 14.3738 5.6261 14.375C5.62661 14.375 5.62713 14.375 5.62764 14.375L5.62502 15V14.375H5.6261H15.625V15H16.25V14.375H15.625V3.125H16.25V2.5H15.625V3.125H5.6224C5.45839 3.12431 5.29588 3.1561 5.14423 3.21855C4.99258 3.28099 4.8548 3.37284 4.73883 3.48881C4.62286 3.60478 4.53101 3.74256 4.46856 3.89421C4.40612 4.04586 4.37432 4.20838 4.37501 4.37238L4.37502 4.375L4.37502 14.7066Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 16.25C4.09518 16.25 4.375 16.5298 4.375 16.875H15C15.3452 16.875 15.625 17.1548 15.625 17.5C15.625 17.8452 15.3452 18.125 15 18.125H3.75C3.40482 18.125 3.125 17.8452 3.125 17.5V16.875C3.125 16.5298 3.40482 16.25 3.75 16.25Z" fill="currentColor"/></svg><span>Nuestro Catálogo</span></a>
                <a href="<?=$lang?>/ciclos"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.5 3.75C2.5 3.05964 3.05964 2.5 3.75 2.5H6.25C6.94036 2.5 7.5 3.05964 7.5 3.75V16.25C7.5 16.9404 6.94036 17.5 6.25 17.5H3.75C3.05964 17.5 2.5 16.9404 2.5 16.25V3.75ZM6.25 3.75H3.75V16.25H6.25V3.75Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.5 6.25C2.5 5.90482 2.77982 5.625 3.125 5.625H6.875C7.22018 5.625 7.5 5.90482 7.5 6.25C7.5 6.59518 7.22018 6.875 6.875 6.875H3.125C2.77982 6.875 2.5 6.59518 2.5 6.25Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 3.75C6.25 3.05964 6.80964 2.5 7.5 2.5H10C10.6904 2.5 11.25 3.05964 11.25 3.75V16.25C11.25 16.9404 10.6904 17.5 10 17.5H7.5C6.80964 17.5 6.25 16.9404 6.25 16.25V3.75ZM10 3.75H7.5V16.25H10V3.75Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 13.75C6.25 13.4048 6.52982 13.125 6.875 13.125H10.625C10.9702 13.125 11.25 13.4048 11.25 13.75C11.25 14.0952 10.9702 14.375 10.625 14.375H6.875C6.52982 14.375 6.25 14.0952 6.25 13.75Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.2386 4.50156C10.0591 3.83192 10.4564 3.14356 11.1261 2.96406L13.5511 2.31406C14.2207 2.13457 14.9091 2.53192 15.0886 3.20156L18.3386 15.3266C18.5181 15.9962 18.1207 16.6846 17.4511 16.8641L15.0261 17.5141C14.3564 17.6936 13.6681 17.2962 13.4886 16.6266L10.2386 4.50156ZM13.8761 3.52656L11.4511 4.17656L14.7011 16.3016L17.1261 15.6516L13.8761 3.52656Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.6036 12.861C17.6934 13.1943 17.496 13.5373 17.1627 13.6271L13.5377 14.6036C13.2044 14.6934 12.8615 14.496 12.7717 14.1627C12.6819 13.8294 12.8793 13.4865 13.2126 13.3967L16.8376 12.4201C17.1709 12.3303 17.5139 12.5277 17.6036 12.861Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M15.6665 5.62004C15.7556 5.95352 15.5575 6.2961 15.224 6.38522L11.599 7.35397C11.2655 7.44308 10.923 7.24499 10.8338 6.91152C10.7447 6.57804 10.9428 6.23546 11.2763 6.14634L14.9013 5.17759C15.2348 5.08848 15.5773 5.28657 15.6665 5.62004Z" fill="currentColor"/></svg><span>Ciclos</span></a>
                <a href="<?=$lang?>/acompanamientos-pedagogicos"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.70588 1.94853C9.88971 1.85049 10.1103 1.85049 10.2941 1.94853L19.6691 6.94853C19.8728 7.05715 20 7.26918 20 7.5C20 7.73082 19.8728 7.94285 19.6691 8.05147L10.2941 13.0515C10.1103 13.1495 9.88971 13.1495 9.70588 13.0515L0.330882 8.05147C0.127218 7.94285 0 7.73082 0 7.5C0 7.26918 0.127218 7.05715 0.330882 6.94853L9.70588 1.94853ZM1.95312 7.5L10 11.7917L18.0469 7.5L10 3.20833L1.95312 7.5Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M9.44865 7.20601C9.61109 6.90144 9.98967 6.78622 10.2942 6.94865L14.9817 9.44865C15.1854 9.55727 15.3126 9.7693 15.3126 10.0001V18.7501C15.3126 19.0953 15.0328 19.3751 14.6876 19.3751C14.3424 19.3751 14.0626 19.0953 14.0626 18.7501V10.3751L9.70601 8.05159C9.40144 7.88916 9.28622 7.51057 9.44865 7.20601Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.81251 8.03906C3.15768 8.03906 3.43751 8.31888 3.43751 8.66406V12.9218L3.43888 12.9236L3.43884 12.9237C3.90235 13.5463 5.9575 15.9375 10 15.9375C14.0425 15.9375 16.0977 13.5463 16.5612 12.9237L16.5625 12.9219V8.66406C16.5625 8.31888 16.8423 8.03906 17.1875 8.03906C17.5327 8.03906 17.8125 8.31888 17.8125 8.66406V12.9297L17.8125 12.9323C17.8114 13.1998 17.7234 13.4596 17.5619 13.6727C16.9752 14.4598 14.593 17.1875 10 17.1875C5.40698 17.1875 3.02482 14.4598 2.43812 13.6727C2.27661 13.4596 2.18864 13.1998 2.18751 12.9323L2.1875 12.9297H2.18751V8.66406C2.18751 8.31888 2.46733 8.03906 2.81251 8.03906Z" fill="currentColor"/></svg><span>Acompañamientos pedagógicos</span></a>
                <a href="<?=$lang?>/actualidad-educacion"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 3.125C6.20304 3.125 3.125 6.20304 3.125 10C3.125 13.797 6.20304 16.875 10 16.875C13.797 16.875 16.875 13.797 16.875 10C16.875 6.20304 13.797 3.125 10 3.125ZM1.875 10C1.875 5.51269 5.51269 1.875 10 1.875C14.4873 1.875 18.125 5.51269 18.125 10C18.125 14.4873 14.4873 18.125 10 18.125C5.51269 18.125 1.875 14.4873 1.875 10Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 7.5C2.30469 7.15482 2.58451 6.875 2.92969 6.875H17.0703C17.4155 6.875 17.6953 7.15482 17.6953 7.5C17.6953 7.84518 17.4155 8.125 17.0703 8.125H2.92969C2.58451 8.125 2.30469 7.84518 2.30469 7.5Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M2.30469 12.5C2.30469 12.1548 2.58451 11.875 2.92969 11.875H17.0703C17.4155 11.875 17.6953 12.1548 17.6953 12.5C17.6953 12.8452 17.4155 13.125 17.0703 13.125H2.92969C2.58451 13.125 2.30469 12.8452 2.30469 12.5Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.36482 5.08638C7.83991 6.31204 7.5 8.04884 7.5 10C7.5 11.9512 7.83991 13.688 8.36482 14.9136C8.62775 15.5276 8.92479 15.9845 9.22279 16.2788C9.51811 16.5704 9.78004 16.6719 10 16.6719C10.22 16.6719 10.4819 16.5704 10.7772 16.2788C11.0752 15.9845 11.3722 15.5276 11.6352 14.9136C12.1601 13.688 12.5 11.9512 12.5 10C12.5 8.04884 12.1601 6.31204 11.6352 5.08638C11.3722 4.47243 11.0752 4.01555 10.7772 3.72123C10.4819 3.42957 10.22 3.32812 10 3.32812C9.78004 3.32812 9.51811 3.42957 9.22279 3.72123C8.92479 4.01555 8.62775 4.47243 8.36482 5.08638ZM8.34443 2.83186C8.79684 2.38505 9.35702 2.07812 10 2.07812C10.643 2.07812 11.2032 2.38505 11.6556 2.83186C12.1053 3.27604 12.4817 3.88775 12.7842 4.59428C13.3904 6.00957 13.75 7.92121 13.75 10C13.75 12.0788 13.3904 13.9904 12.7842 15.4057C12.4817 16.1122 12.1053 16.724 11.6556 17.1681C11.2032 17.615 10.643 17.9219 10 17.9219C9.35702 17.9219 8.79684 17.615 8.34443 17.1681C7.89469 16.724 7.51834 16.1122 7.21576 15.4057C6.60964 13.9904 6.25 12.0788 6.25 10C6.25 7.92121 6.60964 6.00957 7.21576 4.59428C7.51834 3.88775 7.89469 3.27604 8.34443 2.83186Z" fill="currentColor"/></svg><span>Actualidad y Educación</span></a>
                <a href="<?=$lang?>/obtener-cinescuela" class="btn btn-primary mobile">Obtener Cinescuela</a>
                <?php if(isset($_SESSION['logged']['cod_us'])){ ?>
                    <a href="app/<?=$lang?>/inicio" class="btn btn-secondary mobile">Ir a la aplicación</a>
                    <?php }else{ ?>
                        <a href="app/" onClick="ga('send', 'event', 'Menú header', 'click','<?=$_SESSION['logged']['usu_us']?>')" class="btn btn-secondary mobile">Iniciar sesión</a>
                <?php } ?>
            </nav>
            
        </div>
        <div class="right">
            <div class="search-comp">
                <form action="<?=$lang?>/buscar" method="GET" id="search">
                    <svg width="34" height="37" viewBox="0 0 34 37" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#filter0_d_167_980)"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 5C10.2533 5 6 9.25329 6 14.5C6 19.7467 10.2533 24 15.5 24C20.7467 24 25 19.7467 25 14.5C25 9.25329 20.7467 5 15.5 5ZM4 14.5C4 8.14873 9.14873 3 15.5 3C21.8513 3 27 8.14873 27 14.5C27 20.8513 21.8513 26 15.5 26C9.14873 26 4 20.8513 4 14.5Z" fill="#111111"/><path fill-rule="evenodd" clip-rule="evenodd" d="M22.2179 21.2179C22.6085 20.8274 23.2416 20.8274 23.6322 21.2179L29.7072 27.2929C30.0977 27.6835 30.0977 28.3166 29.7072 28.7072C29.3166 29.0977 28.6835 29.0977 28.2929 28.7072L22.2179 22.6322C21.8274 22.2416 21.8274 21.6085 22.2179 21.2179Z" fill="#111111"/></g><defs><filter id="filter0_d_167_980" x="-3" y="0" width="40" height="40" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4"/><feGaussianBlur stdDeviation="2"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_167_980"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_167_980" result="shape"/></filter></defs></svg>
                    <span>
                        <input type="text" name="search-input" id="search-input" value="">
                    </span>
                </form>
                <button type="button" id="openSearch"><svg width="97" height="97" viewBox="0 0 97 97" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M40 0C17.956 0 0 17.956 0 40C0 62.044 17.956 80 40 80C49.586 80 58.3895 76.5959 65.2891 70.9453L89.1718 94.8281C90.1751 95.873 91.6649 96.294 93.0667 95.9286C94.4684 95.5631 95.5631 94.4684 95.9286 93.0667C96.294 91.6649 95.873 90.1751 94.8281 89.1718L70.9453 65.2891C76.5959 58.3895 80 49.586 80 40C80 17.956 62.044 0 40 0ZM40 8C57.7205 8 72 22.2795 72 40C72 57.7205 57.7205 72 40 72C22.2795 72 8 57.7205 8 40C8 22.2795 22.2795 8 40 8Z"
                            fill="currentColor" />
                    </svg></button>
            </div>
            <a href="<?=$lang?>/obtener-cinescuela" class="btn btn-primary">Obtener Cinescuela</a>
            <?php if(isset($_SESSION['logged']['cod_us'])){ ?>
                <a href="app/<?=$lang?>/inicio" class="btn btn-secondary">Ir a la aplicación</a>
                <?php }else{ ?>
                    <a href="app/" class="btn btn-secondary">Iniciar sesión</a>
            <?php } ?>
        
        </div>
</header>