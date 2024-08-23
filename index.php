<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<div class="container">
<h3><marquee text bgcolor="red">FOR EMERGENCY, CALL 999 / 112 </marquee></h3>
    <h1>iWatch Ug</h1>
    
    <form action="login.php" method="POST">
        <input type="text" name="phone_number" placeholder="Phone number" required pattern="(\+256|07)\d{8,9}" maxlength="13" title="Phone number must start with +256 or 07 and not exceed 13 characters">
        <button type="submit">Login</button>
    </form>
    
    <button onclick="toggleRegisterForm()">Register</button>
    
    <div id="registerForm" style="display: none;">
        <form action="register.php" method="POST">
            <input type="text" name="phone_number" placeholder="Phone number" required pattern="(\+256|07)\d{8,9}" maxlength="13" title="Phone number must start with +256 or 07 and not exceed 13 characters">
            <button type="submit">Register</button>
        </form>
    </div>
</div>

<script>
function toggleRegisterForm() {
    var registerForm = document.getElementById("registerForm");
    if (registerForm.style.display === "none") {
        registerForm.style.display = "block";
    } else {
        registerForm.style.display = "none";
    }
}
</script>

</body>
</html>
