<?php include "admin/functions.php"?>

<?php
//catching the p_id
if (isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}
?>

<p><a href="<?php redirect('post.php?p_id = $the_post_id')?>"> Redirect </a></p>
post.php?p_id = $the_post_id
<br>
<a href="https://www.w3schools.com/tags/att_a_href.asp"> w3schools </a>