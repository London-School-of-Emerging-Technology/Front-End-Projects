<?php
session_start();
if (!isset($_SESSION['poll_question']) || !isset($_SESSION['poll_options'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['poll_votes'])) {
    $_SESSION['poll_votes'] = array_fill(0, count($_SESSION['poll_options']), 0);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['poll_option'])) {
    $selectedOption = $_POST['poll_option'];
    if ($selectedOption >= 0 && $selectedOption <
count($_SESSION['poll_votes'])) { $_SESSION['poll_votes'][$selectedOption]++; }
header("Location: {$_SERVER['PHP_SELF']}"); exit(); } if
($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear_poll'])) {
unset($_SESSION['poll_question']); unset($_SESSION['poll_options']);
unset($_SESSION['poll_votes']); header("Location: index.php");
exit(); } ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vote Poll</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        font-family: Georgia, "Times New Roman", Times, serif;
      }
      body {
        background: #8cb9bd;
      }
      .content {
        margin: 100px auto;
        width: 430px;
        background: #fefbf6;
        padding: 20px;
        border-radius: 10px;
      }
      h1 {
        text-align: center;
        margin: 30px 0;
        color: #2a2a2a;
        font-size: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #ccc;
      }
      h2 {
        margin: 20px 0;
        color: #2a2a2a;
        font-size: 20px;
        text-transform: capitalize;
      }
      label {
        font-size: 20px;
        color: #2a2a2a;
      }
        input[type="submit"] {
        width: 100%;
        padding: 15px 20px;
        font-size: 18px;
        font-weight: 900;
        background-color: #8cb9bd;
        margin: 10px 0;
        color: #fefbf6;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
        input[type="radio"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;

        border: 2px solid #2a2a2a;
        transition: 0.2s all linear;
        margin-right: 5px;
      }
        input[type="radio"]:checked{
        background-color: #8cb9bd;
      }
    </style>
  </head>
  <body>
    <div class="content">
      <h1>Vote Poll</h1>
      <h2><?php echo $_SESSION['poll_question']; ?></h2>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php foreach ($_SESSION['poll_options'] as $key =>
        $option): ?>
        <div>
          <label>
            <input
              type="radio"
              name="poll_option"
              value="<?php echo $key; ?>"
            />
            <?php echo $option; ?>
            (Votes:
            <?php echo $_SESSION['poll_votes'][$key]; ?>)
          </label>
        </div>
        <?php endforeach; ?>
        <input type="submit" value="Vote" />
      </form>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="clear_poll" value="1" />
        <input type="submit" value="Clear Poll Questions" />
      </form>
    </div>
  </body>
</html>
