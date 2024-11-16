<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BetApp Admin Login</title>
    <link rel="stylesheet" href="./public/css/tailwind.css">
</head>
<body class="bg-background text-foreground flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-primary rounded-lg shadow-lg p-8">
            <div class="text-3xl font-bold text-center mb-6">BetApp Admin</div>
            <form action="admin-dashboard.html" method="GET">
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground focus:outline-none focus:ring-2 focus:ring-success">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-3 py-2 bg-secondary border border-accent rounded-md text-foreground focus:outline-none focus:ring-2 focus:ring-success">
                </div>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                               class="h-4 w-4 text-success focus:ring-success border-accent rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-400">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-success hover:text-success-600">
                            Forgot your password?
                        </a>
                    </div>
                </div>
                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-success hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>