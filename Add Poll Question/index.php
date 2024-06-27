<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new_question']) && !empty($_POST['option1']) && !empty($_POST['option2']) && !empty($_POST['option3']) && !empty($_POST['option4'])) {
        $_SESSION['poll_question'] = htmlspecialchars($_POST['new_question']);
        $_SESSION['poll_options'] = array(
            htmlspecialchars($_POST['option1']),
            htmlspecialchars($_POST['option2']),
            htmlspecialchars($_POST['option3']),
            htmlspecialchars($_POST['option4'])
        );
        header("Location: vote.php");
        exit();
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Poll Question</title>
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
      label {
        font-size: 20px;
        color: #2a2a2a;
      }
      input {
        padding: 10px 20px;
        margin: 8px 0;
        width: 90%;
        border: none;
        background-color: #eef3f8;
        border: 2px solid transparent;
        font-size: 18px;
        text-transform: capitalize;
      }
      input:focus {
        border: 2px solid #ccc;
        outline: none;
      }
      .button {
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .btn {
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
    </style>
  </head>
  <body>
    <div class="content">
      <h1>Add Poll Question</h1>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="new_question">Enter new poll question:</label><br />
        <input
          type="text"
          id="new_question"
          name="new_question"
          required
        /><br />
        <label for="option1">Option 1:</label><br />
        <input type="text" id="option1" name="option1" required /><br />
        <label for="option2">Option 2:</label><br />
        <input type="text" id="option2" name="option2" required /><br />
        <label for="option3">Option 3:</label><br />
        <input type="text" id="option3" name="option3" required /><br />
        <label for="option4">Option 4:</label><br />
        <input type="text" id="option4" name="option4" required /><br />
        <div class="button">
          <input type="submit" class="btn" value="Add Question" />
        </div>
      </form>
    </div>
    <?php if (isset($error)): ?>
    <p style="color: red"><?php echo $error; ?></p>
    <?php endif; ?>
  </body>
</html>
