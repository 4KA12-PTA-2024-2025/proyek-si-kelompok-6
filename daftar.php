<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Warung Boboko</title>
  <link rel="stylesheet" href="css\style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
</head>

<body>
  <!--Header-->
  <header class="products">
    <a href="index.php" class="logo" style="text-decoration:none;">
      <img src="img\logo.png" alt="">
      <h2 style="font-weight: bold;">Warung Boboko</h2>
    </a>
  </header>

  <!--Halaman Daftar-->
  <div class="container-login" style="margin-top: 150px; margin-left: 150px">
    <h2 style="font-weight: bold">Sign Up/Daftar</h2>
    <form style="border: 3px solid #54595a77; width: 40%; padding: 15px 20px; border-radius: 10px; box-shadow: 2px 2px 10px 4px rgb(14 55 54 / 10%)" action="register.php" method="post" autocomplete="off">
      <div class="mb-3" style="width: 100%">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required />
      </div>
      <div class="mb-3" style="width: 100%">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required />
      </div>
      <div class="mb-3" style="width: 100%">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
      </div>
      <div class="mb-3" style="width: 100%">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
      </div>
      <button id="submit" type="submit" name="register" style="width: 20%; border: 3px solid #607274; border-radius: 5px; padding: 7px 10px; background-color: #607274; color: #fff; font-weight: bold; text-decoration: none">
        Daftar
      </button>
    </form>
    <p style="margin-top: 20px; margin-left: 150px">Sudah punya akun? <a href="login.php">Masuk disini</a></p>
  </div>
  <div style="width: 40%; float: right; margin-left: 100px; margin-top: -550px">
    <img class="login" src="img/signup.png" width="100px" style="margin-top: 20px;" />
  </div>

</body>

</html>