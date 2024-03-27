<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
            rel="stylesheet">
        <link href="/assets/css/custom.css" rel="stylesheet">
        <link rel="icon" sizes="32x32" href="./assets/img/logos1.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body> 
        <div class="login-header">
            <img src="./assets/img/logos.png" class="m-4" alt="logo">
        </div>
        <div class="login-container">
            <div class="container flex-fill p-4 ">
                <div class="row justify-content-center">
                    
                    <div class="login-content">
                        <div class="d-flex flex-column align-items-center mb-4 my-4">
                            <h2 class="login-header-title">Welcome back!</h2>
                            <h6 class="login-header-sub">Enter your details to sign in.</h6>
                        </div>
                        <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                        <?php endif; ?>
                        <form action="process-login.php" method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                            <path d="M2.95644 5.16832H18.5268V16.1973C18.5268 16.3694 18.4585 16.5344 18.3368 16.6561C18.2151 16.7778 18.0501 16.8461 17.878 16.8461H3.6052C3.43314 16.8461 3.26812 16.7778 3.14646 16.6561C3.02479 16.5344 2.95644 16.3694 2.95644 16.1973V5.16832Z" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.5268 5.16832L10.7416 12.3047L2.95644 5.16832" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                                <input type="email" class="form-control" id="email" placeholder="E-mail"
                                    name="email" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                            <path d="M2.95644 5.16832H18.5268V16.1973C18.5268 16.3694 18.4585 16.5344 18.3368 16.6561C18.2151 16.7778 18.0501 16.8461 17.878 16.8461H3.6052C3.43314 16.8461 3.26812 16.7778 3.14646 16.6561C3.02479 16.5344 2.95644 16.3694 2.95644 16.1973V5.16832Z" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.5268 5.16832L10.7416 12.3047L2.95644 5.16832" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                            <path d="M17.2293 8.12472H4.25394C3.89564 8.12472 3.60518 8.41518 3.60518 8.77348V17.8562C3.60518 18.2145 3.89564 18.505 4.25394 18.505H17.2293C17.5876 18.505 17.878 18.2145 17.878 17.8562V8.77348C17.878 8.41518 17.5876 8.12472 17.2293 8.12472Z" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7.82214 8.12472V5.20527C7.82214 4.43099 8.12973 3.68842 8.67723 3.14091C9.22473 2.59341 9.9673 2.28583 10.7416 2.28583C11.5159 2.28583 12.2584 2.59341 12.8059 3.14091C13.3535 3.68842 13.661 4.43099 13.661 5.20527V8.12472" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password"
                                    id="password" name="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                            <path d="M17.2293 8.12472H4.25394C3.89564 8.12472 3.60518 8.41518 3.60518 8.77348V17.8562C3.60518 18.2145 3.89564 18.505 4.25394 18.505H17.2293C17.5876 18.505 17.878 18.2145 17.878 17.8562V8.77348C17.878 8.41518 17.5876 8.12472 17.2293 8.12472Z" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7.82214 8.12472V5.20527C7.82214 4.43099 8.12973 3.68842 8.67723 3.14091C9.22473 2.59341 9.9673 2.28583 10.7416 2.28583C11.5159 2.28583 12.2584 2.59341 12.8059 3.14091C13.3535 3.68842 13.661 4.43099 13.661 5.20527V8.12472" stroke="#8C8A97" stroke-width="1.38403" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end forgot-div mb-4 my-4">
                                <a href="forgot.php">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn bg-default-color w-100 mb-4 my-4 p-3 active-div">Sign in</button>
                        </form>
                        <div class="d-flex justify-content-center or-div mb-4 my-4"><hr><span class="or-span">or</span><hr></div>
                        <div class="d-flex justify-content-center create-acc-div mb-4 my-4"><span>Don’t have an account?</span><a href="register.php">Create account!</a></div>
                        <small class="d-flex justify-content-center mb-4 my-4 privacy-span"><a href=/privacy.php target=_blank>Privacy Policy</a><span>and</span><a href=/terms.php target=_blank>Terms and Conditions</a></small>   
                    </div>
                     
                </div>
            </div>
        </div>
    </body>
</html>