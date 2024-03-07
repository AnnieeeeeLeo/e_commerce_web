<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <header> <!--HEADER-->

    </header> <!-- END HEADER-->
    <main>
        <div class="flex items-center justify-center min-h-screen bg-orange-100">
            <div class="w-96 p-6 bg-white rounded-xl shadow-lg">
                <h1 class="text-3xl font-semibold text-center">Register</h1>
                <form action="register1.php" method="post">
                    <div class="mt-6">
                        <label for="name" class="block text-gray-600">First Name</label>
                        <input type="text" name="fname" id="fname" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mt-6">
                        <label for="name" class="block text-gray-600">Last Name</label>
                        <input type="text" name="lname" id="lname" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mt-6">
                        <label for="email" class="block text-gray-600">Email</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mt-6">
                        <label for="password" class="block text-gray-600">Password</label>
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full p-3 text-white bg-blue-500 rounded-md">Register</button>
                    </div>
                    <div>
                        <p class="mt-4 text-center">Already have an account? <a href="login.php" class="text-blue-500">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>