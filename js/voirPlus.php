<script>/* <![CDATA[ */
/*
|-----------------------------------------------------------------------
|  jQuery Multiple Toggle Script by Matt - www.skyminds.net
|-----------------------------------------------------------------------
|
| Affiche et cache le contenu de blocs multiples.
|
*/
jQuery(document).ready(function() {
    $(".more").hide();
    jQuery('.button-read-more').click(function () {
        $(this).closest('.less').addClass('active');
        $(this).closest(".less").prev().stop(true).slideDown("1000");
    });
    jQuery('.button-read-less').click(function () {
        $(this).closest('.less').removeClass('active');
        $(this).closest(".less").prev().stop(true).slideUp("1000");
    });
});
/* ]]> */ </script>
