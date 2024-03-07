

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style1.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
     <header> <!--HEADER-->

     </header> <!-- END HEADER-->

     <main>
        <div class="flex items-center justify-center min-h-screen bg-white">
            <div class="w-96 p-6 bg-white rounded-xl shadow-lg">
                <h1 class="text-3xl Poppins font-bold text-center">Login</h1>
                <form action="login1.php" id="loginForm" method="post">
                    <div class="mt-6">
                        <label for="email" class="block text-gray-600">Email</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mt-6">
                        <label for="password" class="block text-gray-600">Password</label>
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full p-2 text-white bg-black rounded-md">Login</button>
                    </div>
                    <div id="message"></div>
                    <div>
                        <p class="mt-4 text-center">Don't have an account? <a href="register.php" class="text-blue-500">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
     </main>
     <script>
        $("#loginForm").on("submit", function(event) {
    event.preventDefault();

    $.ajax({
        url: 'login1.php',
        type: 'post',
        data: {
            email: $("#email").val(),
            password: $("#password").val()
        },
        success: function(response) {
            if(response.trim() == "admin_success") {
                window.location.href = "dashboard.php";
            } else if (response.trim() == "success") {
                window.location.href = "user.php";
            } else {
                $("#message").html(response);
            }
        }
    });
});

    </script>
</body>
</html>