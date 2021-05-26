<!-- Footer Section Starts -->

<div class="footer">
    <div class="wrapper">
        <p class="footer-text" id="footerText"></p>
    </div>
</div>
<!-- Footer Section Ends  -->

<script>
    var year = new Date().getFullYear();

    document.getElementById("footerText").innerHTML =
        year + " All Rights Reserved, PTUK Restaurant. Developed By: " +
        '<a href="#">Fares H. Abuali</a>';
</script>

<style>
    .footer-text {
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
</style>
</body>

</html>