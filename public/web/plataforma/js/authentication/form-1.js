var togglePassword = document.getElementById("toggle-password");

if (togglePassword) {
    togglePassword.addEventListener('click', function () {
        var x = document.getElementById("Senha");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    });
}
