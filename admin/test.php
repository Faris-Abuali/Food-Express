<script>
    function func() {
        console.log("sss");
        var x = JSON.parse(document.getElementById('img').innerHTML);
        console.log(x);
    }
</script>

<?php
$image_name = "Fares";
$json = json_encode($image_name);
echo "<div id='img' style='display: none;'>" . $json . "</div>";

echo '<script>', 'func()', '</script>';
?>