<?php
include_once './include/db.inc.php';


$url = $_POST['url'];
$userId = $_POST['userId'];
$file_name = basename($url);
$path = 'capturedFile/' . $userId;
if (!file_exists($path)) {
  mkdir($path, 0777, true);
}
if (file_put_contents($path . '/' . $file_name, file_get_contents($url))) {
  try {
    $selectSql = "select * from user where user_ready_id = '" . $userId . "'";
    $checkresult = mysqli_query($conn, $selectSql);
    $existingUser = mysqli_num_rows($checkresult);
    $sql = "";

    if ($existingUser == 0) {
      $sql = "insert into user (user_ready_id,user_glb_file_url,internal_glb_path) values ('" . $userId . "','" . $url . "','" . $path . "/" . $file_name . "')";
    } else {
      $sql = "update user set user_glb_file_url = '" . $url . "',internal_glb_path = '" . $path . "/" . $file_name . "'  where user_ready_id = '" . $userId . "'";
    }
    $result = mysqli_query($conn, $sql);
  } catch (Exception $e) {
    // echo 'Message: ' .$e->getMessage();
  }
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customising Recipient & Background for your Avatar | GalaxyGift</title>
  <link rel="shortcut icon" href="img/favicon.ico" sizes="40x40">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
</head>

<body>
  <link rel="stylesheet" href="./loader/loader.css" />
  <link rel="stylesheet" href="./bootstrap-4.6.1-dist/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <style type="text/css">
    body {
      font-family: Poppins;
      background-image: url(backgroundImages/bg-noise.png), url(backgroundImages/bg-top-nav.svg);
      background-repeat: repeat, no-repeat;
      background-color: rgb(50, 51, 62);
      color: rgb(196, 197, 204);
      width: 100%;
      -webkit-font-smoothing: antialiased;
    }

    ::-webkit-scrollbar {
      width: 0.4em;
      height: 0.4em;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px #ddd;
      border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #00e8da;
      border-radius: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #09a59b;
    }

    .images {
      display: flex;
      align-items: center;
      background-repeat: no-repeat;
      background-size: auto;
      overflow: hidden;
      overflow-x: auto;
      height: 5em;
    }

    .h4 {
      color: #fff;
      font-size: 28px
    }

    h4 {
      color: #1d1d1d
    }

    .md-form {
      margin-bottom: 20px;
    }

    @media (min-width:654px) {
      .images {
        height: 15em;
      }

      .note {
        display: inline-block;
        position: absolute;
        white-space: nowrap;
        left: 100%;
        transform: translateX(-100%);
      }
    }

    .images img {
      padding-left: 0.4em;
      padding-right: 0.4em;
      max-width: 100%;
      max-height: 100%;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px;
      margin: 3px;
    }

    .activeImg {
      border: 5px solid rgb(177, 218, 245) !important;
      padding: 0 !important;
      /* width: 150px; */
    }

    .note {
      font-size: 60%;
      font-style: Italic;
      text-align: end;

    }

    input,
    textarea {
      outline: none !important;
      border: 1px solid #aaa;
      border-radius: 2px !important;
      font-size: 13px !important;
    }

    label {
      font-size: 14px;
      margin-bottom: 5px;
    }

    .btn {
      padding: 8px 30px;
      background: #0064b3;
      color: #fff;
      font-size: 14px !important;
      transition: .3s ease;
      margin-top: 10px !important;
    }

    .btn:hover {
      background: #1d1d1d;
      color: #fff;
    }

    .row {
      justify-content: center;
      display: flex;
      align-items: center;
    }
  </style>
  <div class="container-fluid">
    <div class="row mt-5 pt-5">
      <form class="col-lg-7 col-md-9" action="saveBackground.php" method="post">
        <div class="mx-3 pb-4">
          <div class="h4">Recipient</div>
        </div>
        <div class="row mx-3">
          <div class="col-md-6 md-form">
            <label for="recipient-to">To</label>
            <input type="text" name="to" id="recipient-to" class="form-control validate" />
          </div>
          <div class="col-md-6 md-form">
            <label for="recipient-from">From</label>
            <input type="text" name="from" id="recipient-from" class="form-control validate" />
          </div>
          <div class="col-md-12 md-form">
            <label for="recipient-note">Note</label>
            <textarea type="" name="notes" placeholder="Add a Note for your Recipient" id="recipient-note" rows="5" class="form-control validate"></textarea>
          </div>
          <div class="col-md-12">
            <div class="col-md-12 p-0">
              <div class="h6 p-relative">
                Choose a Avatar's Background
                <div class="small note">*Double click to preview background</div>
              </div>
            </div>
            <input type="hidden" name="background" id="backgroundHidden" required />
            <div id="bgImages" class="images py-2"></div>
          </div>
        </div>
        <div class="d-flex justify-content-center pt-2">
          <button type="submit" class="btn">Proceed Avatar</button>
          <input type="hidden" name="userId" id="user_id" value="<?php echo $userId; ?>" />
        </div>
      </form>
    </div>
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title mx-auto" id="myModalLabel">
              Image preview
            </h4>
          </div>
          <div class="modal-body">
            <img src="" class="w-100" id="imagepreview" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="./jQuery3.6.js"></script>
  <script type="text/javascript" src="./bootstrap-4.6.1-dist/js/popper.min.js"></script>
  <script type="text/javascript" src="./bootstrap-4.6.1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    var folder = "backgroundImages/";
    var touchtime = 0;
    $(document).on("click", ".bg-images", function() {
      $(".bg-images").removeClass("activeImg");
      $(this).addClass("activeImg");
      $("#backgroundHidden").val($(this).attr("src"))
    });
    $(document).on("click", ".bg-images", function() {
      if (touchtime == 0) {
        // set first click
        touchtime = new Date().getTime();
      } else {
        // compare first click to this click and see if they occurred within double click threshold
        if (new Date().getTime() - touchtime < 600) {
          // double click occurred
          $("#imagepreview").attr("src", $(this).attr("src")); // here asign the image to the modal when the user click the enlarge link
          $("#imagemodal").modal("show"); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function

          touchtime = 0;
        } else {
          // not a double click so set as a new first click
          touchtime = new Date().getTime();
        }
      }
    });

    function loadBgImage() {
      $.ajax({
        url: folder,
        success: function(data) {
          $(data)
            .find("a")
            .attr("href", function(i, val) {
              if (val.match(/\.(jpe?g|webp|gif)$/)) {
                $("#bgImages").append(
                  "<img class='bg-images' src='" + folder + val + "'>"
                );
              }
            });
        },
      });
    }
    loadBgImage();
  </script>
</body>

</html>