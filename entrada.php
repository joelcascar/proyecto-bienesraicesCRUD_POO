<?php
require 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Terraza en el techo de tu casa</h1>

    <picture>
        <source srcset="build/img/blog1.webp" type="image/webp">
        <source srcset="build/img/blog1.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/blog1.jpg" alt="Imagen de la propiedad">
    </picture>

    <p class="informacion-meta">Escrito el: <span>15/06/2026</span> por: <span>Admin</span></p>

    <div class="resumen-propiedad">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos iste odit aliquid, nihil ratione minima quaerat reprehenderit atque. Iure, vitae soluta sit minus iusto reprehenderit atque ipsam saepe voluptatem est culpa quas dicta reiciendis excepturi cupiditate maxime inventore quaerat ullam aut eligendi hic. Illo, atque nesciunt beatae tempore pariatur accusamus!</p>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolores recusandae officiis, iste in, consequatur illum ex soluta ipsa et nemo sed quasi nobis, perspiciatis accusantium veniam quidem natus harum molestias. Blanditiis delectus distinctio sapiente suscipit nesciunt voluptates deleniti sed consequatur. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit voluptatem nihil labore fugiat cupiditate eaque, asperiores placeat ea quod modi itaque aspernatur ipsam quis doloribus recusandae illum? Delectus odio alias voluptas fugit molestias ipsa quod?. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quaerat, laborum? Sed, dignissimos dicta quia repellat doloribus quos veritatis adipisci placeat labore consequatur fugit quidem excepturi perferendis, quisquam, molestias praesentium ullam obcaecati neque. Facere debitis rerum, aspernatur autem vero iste laborum placeat maiores earum voluptatibus consequatur.</p>
    </div>
</main>

<?php incluirTemplate('footer') ?>