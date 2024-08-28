<?php 
    $bodyClass = "kit";
    include 'includes/head.php';
    include 'includes/header.php';
    $herramientas = $_SESSION['logged']['perfil_de_usuario'][0]->acf_fields->kit_de_herramientas;
    $kits = $sdk->query('cinescuela-kits',$herramientas);
?>
<main class="container">
    <?php for ($i=0; $i < count($kits['response']); $i++) { 
        $kit = $kits['response'][$i];
    ?>
    <section>
        <article>
            <h2>
                <?= $kit->title->rendered ?>
            </h2>
            <?php 
            $video_links = [
                $kit->acf->video_youtube_1, 
                $kit->acf->video_youtube_2, 
                $kit->acf->video_youtube_3, 
                $kit->acf->video_youtube_4, 
                $kit->acf->video_youtube_5
            ];

            $download_links = [
                $kit->acf->descargable_1->url,
                $kit->acf->descargable_2->url,
                $kit->acf->descargable_3->url,
                $kit->acf->descargable_4->url,
                $kit->acf->descargable_5->url
            ];

            ?>
            <ul>
                <?php 
             // Validar y mostrar los enlaces de video
             foreach ($video_links as $index => $video) {
                if (!empty($video)) {
        ?>
                <li><a target="_blank" href="<?=$video?>"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.5 8.75C2.5 8.40482 2.77982 8.125 3.125 8.125H16.875C17.2202 8.125 17.5 8.40482 17.5 8.75V15.625C17.5 15.9565 17.3683 16.2745 17.1339 16.5089C16.8995 16.7433 16.5815 16.875 16.25 16.875H3.75C3.41848 16.875 3.10054 16.7433 2.86612 16.5089C2.6317 16.2745 2.5 15.9565 2.5 15.625V8.75ZM3.75 9.375V15.625H16.25V9.375H3.75Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.8267 1.73325C14.9841 1.6893 15.1487 1.67685 15.311 1.69662C15.4751 1.71662 15.6335 1.76916 15.777 1.85117C15.9205 1.93317 16.0462 2.04299 16.1468 2.1742C16.2468 2.30476 16.3199 2.45389 16.3618 2.61293C16.362 2.6137 16.3622 2.61448 16.3625 2.61525L17.0098 5.02539C17.0529 5.18551 17.0305 5.35616 16.9476 5.49978C16.8648 5.6434 16.7283 5.74823 16.5682 5.79118L3.28692 9.35368C2.95361 9.44309 2.61091 9.24543 2.52139 8.91215L1.87267 6.49703C1.83025 6.33801 1.81966 6.17217 1.8415 6.00903C1.86333 5.8459 1.91717 5.68869 1.99992 5.54641C2.08267 5.40414 2.1927 5.27961 2.32371 5.17997C2.4542 5.08072 2.60294 5.00811 2.76145 4.96627C2.76206 4.96611 2.76268 4.96595 2.7633 4.96578L14.8267 1.73325ZM15.1552 2.93931L15.154 2.93966L3.08364 6.17403L3.08044 6.17488L3.56652 7.98449L15.6405 4.74584L15.1552 2.93931Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.62283 3.31252C9.79546 3.01362 10.1777 2.91125 10.4766 3.08389L14.3048 5.29482C14.6037 5.46746 14.706 5.84972 14.5334 6.14862C14.3608 6.44753 13.9785 6.54989 13.6796 6.37726L9.85146 4.16632C9.55256 3.99369 9.45019 3.61143 9.62283 3.31252Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.19341 4.77298C4.36631 4.47423 4.74866 4.3722 5.04742 4.5451L8.86773 6.75604C9.16648 6.92894 9.26851 7.31129 9.09561 7.61004C8.92271 7.90879 8.54036 8.01082 8.24161 7.83792L4.4213 5.62698C4.12254 5.45408 4.02052 5.07173 4.19341 4.77298Z"
                                fill="currentColor" />
                        </svg><span>Video YouTube <?=$index + 1?></span></a></li>
                <?php 
                }
            }
        ?>
            </ul>
            <ul>
                <?php 
             // Validar y mostrar los enlaces de video
             foreach ($download_links as $index => $link) {
                if (!empty($link)) {
        ?>
                <li><a target="_blank" href="<?=$link?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48px" height="48px">    <path d="M0 0h24v24H0z" fill="none"/>    <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></svg><span>Descargable <?=$index + 1?></span></a></li>
                <?php 
                }
            }
        ?>
            </ul>
        </article>
    </section>

    <?php } ?>
</main>
<?php include 'includes/footer.php'; ?>