  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Add your CSS here -->
</head>
<body>

<main class="login-form">

  <div class="container">

      <div class="row justify-content-center">

          <div class="col-md-8">

              <div class="card">

                  <div class="card-header">Reset Password</div>

                  <div class="card-body">

                    <!-- Check if there's a message -->
                    <div id="message" style="display: none;" class="alert alert-success" role="alert">
                        <!-- Message will be shown here -->
                    </div>

                    <form action="/forget-password" method="POST">
                        <!-- Add CSRF token if necessary -->
                        @csrf

                          <div class="form-group row">

                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                              <div class="col-md-6">

                                  <input type="email" id="email_address" class="form-control" name="email" required autofocus>

                                  @if ($errors->has('email'))

                                      <span class="text-danger">{{ $errors->first('email') }}</span>

                                  @endif

                              </div>

                          </div>

                          <div class="col-md-6 offset-md-4">

                              <button type="submit" class="btn btn-primary">

                                  Send Password Reset Link

                              </button>

                          </div>
                    </form>

                  </div>

              </div>

          </div>

      </div>

  </div>

</main>

<!-- Add your JS here to handle form submission, display messages, etc. -->

</body>
</html>
