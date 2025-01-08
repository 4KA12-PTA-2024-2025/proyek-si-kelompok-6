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

  <!--Halaman Login-->
  <div class="container-login" style="margin-top: 200px; margin-left: 150px">
    <h2 style="font-weight: bold">Login/Masuk</h2>
    <form style="border: 3px solid #54595a77; width: 40%; padding: 15px 20px; border-radius: 10px; box-shadow: 2px 2px 10px 4px rgb(14 55 54 / 10%)" action="masuk.php" method="post">
      <div class="mb-3" style="width: 100%">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" required />
      </div>
      <div class="mb-3" style="width: 100%">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required />
      </div>
      <button id="submit" name="sbm" type="submit" style="width: 20%; border: 3px solid #607274; border-radius: 5px; padding: 7px 10px; background-color: #607274; color: #fff; font-weight: bold; text-decoration: none">Masuk</button>
    </form>
    <p style="margin-top: 20px; margin-left: 150px">Belum punya akun? <a href="daftar.php">Daftar disini</a></p>
  </div>
  <div style="width: 45%; float: right; margin-left: 180px; margin-top: -500px">
    <img class="login" src="img\login.png" width="500px" style="margin-top: 20px" />
  </div>

  <script>
  </script>
</body>

</html>