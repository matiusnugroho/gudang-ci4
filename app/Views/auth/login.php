<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Aplikasi Gudang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow rounded-4">
          <div class="card-body p-4">
            <h3 class="text-center mb-4">Login</h3>

            <!-- flash message -->
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('auth/login') ?>">
              <div class="mb-3">
                <label for="username" class="form-label">Username / Email</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>

              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
        <p class="text-center mt-3 text-muted" style="font-size: 0.9rem;">© 2025 Aplikasi Gudang</p>
      </div>
    </div>
  </div>

</body>
</html>
