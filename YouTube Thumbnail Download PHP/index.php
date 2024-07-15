<?php
  if(isset($_POST['button'])){
    $imgUrl = $_POST['imgurl'];
    $ch = curl_init($imgUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $downloadImg = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment;filename="thumbnail.jpg"');
    echo $downloadImg;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Download YouTube Video Thumbnail</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
      }
      body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: #2a2a2a;
      }
      ::selection {
        color: #fff;
        background: #2a2a2a;
      }
      form {
        width: 450px;
        background: #fff;
        padding: 30px;
        box-shadow: 10px 10px 13px rgba(0, 0, 0, 0.1);
      }
      form header {
        text-align: center;
        font-size: 28px;
        font-weight: 500;
        margin-top: 10px;
        color: #2a2a2a;
      }
      form .url-input {
        margin: 30px 0;
      }
      .url-input .title {
        font-size: 18px;
        color: #373737;
      }
      .url-input .field {
        margin-top: 5px;
        height: 50px;
        width: 100%;
        position: relative;
      }
      .url-input .field input {
        height: 100%;
        width: 100%;
        border: none;
        outline: none;
        padding: 0 15px;
        font-size: 15px;
        background: #f1f1f7;
        border-bottom: 2px solid #ccc;
        font-family: "Noto Sans", sans-serif;
      }
      .url-input .field input::placeholder {
        color: #b3b3b3;
      }
      .url-input .field .bottom-line {
        position: absolute;
        left: 0;
        bottom: 0;
        height: 2px;
        width: 100%;
        background: #2a2a2a;
        transform: scale(0);
        transition: transform 0.3s ease;
      }
      .url-input .field input:focus ~ .bottom-line,
      .url-input .field input:valid ~ .bottom-line {
        transform: scale(1);
      }
      form .preview-area {
        height: 220px;
        display: flex;
        overflow: hidden;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border: 2px solid #2a2a2a;
        margin-top: 20px;
      }
      .preview-area.active {
        border: none;
      }
      .preview-area .thumbnail {
        width: 100%;
        display: none;
      }
      .preview-area.active .thumbnail {
        display: block;
      }
      .preview-area.active .icon,
      .preview-area.active span {
        display: none;
      }
      .preview-area .icon {
        color: #2a2a2a;
        font-size: 80px;
      }
      .preview-area span {
        color: #2a2a2a;
        margin-top: 25px;
      }
      form .download-btn {
        color: #fff;
        height: 53px;
        width: 100%;
        outline: none;
        border: none;
        font-size: 17px;
        font-weight: 500;
        cursor: pointer;
        margin: 0px;
        background: #2a2a2a;
      }
      form .download-btn:hover {
        background: #2a2a2a;
      }
    </style>
  </head>
  <body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <header>Thumbnail Download</header>
      <div class="preview-area">
        <img class="thumbnail" src="" alt="" />
        <i class="icon fas fa-cloud-download-alt"></i>
        <span>Paste YouTube video url to see preview</span>
      </div>
      <div class="url-input">
        <span class="title">Paste YouTube Video url:</span>
        <div class="field">
          <input
            type="text"
            placeholder="https://www.youtube.com/watch?v=lqwdD2ivIbM"
            required
          />
          <input class="hidden-input" type="hidden" name="imgurl" />
          <span class="bottom-line"></span>
        </div>
      </div>
      <button class="download-btn" type="submit" name="button">
        Download Thumbnail
      </button>
    </form>

    <script>
      const urlField = document.querySelector(".field input"),
        previewArea = document.querySelector(".preview-area"),
        imgTag = previewArea.querySelector(".thumbnail"),
        hiddenInput = document.querySelector(".hidden-input"),
        button = document.querySelector(".download-btn");

      urlField.onkeyup = () => {
        let imgUrl = urlField.value;
        previewArea.classList.add("active");
        button.style.pointerEvents = "auto";
        if (imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1) {
          let vidId = imgUrl.split("v=")[1].substring(0, 11);
          let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
          imgTag.src = ytImgUrl;
        } else if (imgUrl.indexOf("https://youtu.be/") != -1) {
          let vidId = imgUrl.split("be/")[1].substring(0, 11);
          let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
          imgTag.src = ytImgUrl;
        } else if (imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)) {
          imgTag.src = imgUrl;
        } else {
          imgTag.src = "";
          button.style.pointerEvents = "none";
          previewArea.classList.remove("active");
        }
        hiddenInput.value = imgTag.src;
      };
    </script>
  </body>
</html>
