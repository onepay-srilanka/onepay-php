<!DOCTYPE html>

<html lang="en">

<head>
  onepay php implepemtation
</head>

<body>

  <div class="container">

    <div class="jumbotron align_jumbo ">

      <h2 class="display-4">Payments</h2>

      <hr class="my-4">

      <form method="POST" action="payment.php">

        <p class="form-group">

          <input type="text" class="form-control" id="ID" placeholder="Student ID" required name="stuid">

        </p>

        <p class="form-group">

          <input type="text" class="form-control" id="name" placeholder="Student Name" required name="firstname">

        </p>

        <p class="form-group">

          <input type="text" class="form-control" id="name" placeholder="Student Name" required name="lastname">

        </p>

        <p class="form-group">

          <input type="email" class="form-control" id="email" placeholder="Student email" name="email" required>

        </p>


        <p class="form-group">

          <input type="tel" class="form-control" id="wh" placeholder="Whatsapp No (ex: +947xxxxxx)" name="tele" pattern="^(?:7|0|(?:\+94))[0-9]{9,10}$" required>

        </p>

        <p class="form-group">

          <input type="text" step="0.01" class="form-control" name="pay" placeholder="Payment" min="0.00" max="10000.00" required>

        </p>

        <p class="form-group">

          <button type="submit" class="btn btn-primary">Pay</button>

        </p>

      </form>

    </div>

  </div>

</body>

</html>