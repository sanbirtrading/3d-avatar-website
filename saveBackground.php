<?php
include_once './include/db.inc.php';

$from = $_POST['from'];
$to = $_POST['to'];
$notes = $_POST['notes'];
$background = $_POST['background'];
$userId = $_POST['userId'];
$glbFilepath = "";

try {
  $selectSql = "select * from user where user_ready_id = '" . $userId . "'";
  $checkresult = mysqli_query($conn, $selectSql);
  $existingUser = mysqli_num_rows($checkresult);
  $sql = "";

  if ($existingUser > 0) {
    $sql = "update user set " .
      "user_background = '" . $background .
      "',notes = '" . $notes .
      "',recipient_from = '" . $from .
      "',recipient_to = '" . $to .
      "'  where user_ready_id = '" . $userId . "'";

    $result = mysqli_query($conn, $sql);
    // $names=[];
    $colorDb="#fff";
    $checkresult = mysqli_query($conn, $selectSql);
    while ($row = mysqli_fetch_array($checkresult)) {
      $glbFilepath = $row['internal_glb_path'];
      $colorDb = $row['color'];
      // echo($row['name']+"         row name");
    }
  } else {
    echo ("User not found");
  }
} catch (Exception $e) {
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
<title>Download Your 3D Avatar for your Recipient | GalaxyGift</title>
<link rel="shortcut icon" href="img/favicon.ico" sizes="40x40">
<link rel="icon" type="image/jpg" href="img/logo.jpg">
<!-- <link rel="stylesheet" href="./loader/loader.css" /> -->
<link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <style>
    body{
    background-image: url(backgroundImages/bg-noise.png), url(backgroundImages/bg-top-nav.svg);
    background-repeat: repeat, no-repeat;
    background-color: rgb(50, 51, 62);
    color: rgb(196, 197, 204);
    width: 100%;
    overflow-y: scroll;
    -webkit-font-smoothing: antialiased;
    }
    .container{
      justify-content: center !important;
      align-items: center !important;
      padding: 120px 0;
    }
    .aligntodraw{
      width:450px;
      margin: 12px auto;
      font-family: Poppins; 
    }
    #drawable {
      width: 530px;
      height: 630px;
      margin: auto;
      display: block;
      touch-action: none;
    }
    canvas {
    width: 100%;
    height: 100vh;
    }
    .btn{
      padding: 8px 40px;
      display: block;
      margin: auto;
      background: #deeaf6;
      border-radius: 10px;
      color: #111;
      font-weight: 600;
      border: 2px solid #0064b3 !important;
      font-size: 14px !important;
      transition: .3s ease;
      margin-top: 10px !important;
      font-family: Poppins;
    }
    .btn:hover{
      background: #0064b3;
      border: 2px solid #0064b3 !important;
      color: #fff;
    }
    input{
      outline: none !important;
      border: 1px solid #aaa;
      border-radius: 2px !important;
      font-size: 13px !important;
    }
  </style>
</head>

<body id="allcontent">
  
    <div class="container">
      <div class="row" style="justify-content: center; align-items:center;">
        <div class="col-lg-7 col-sm-12">
        <div class="" id="drawable"></div>
        <div class="aligntodraw text-break">
          <?php echo($notes);?>
        </div>
        <div class="aligntodraw button-wrapper">
          <input type="text" class="form-control form-control-sm my-2 d-none" id="fileName" value="3D-Full-Body-Avatar" />
          <button class="btn" onclick="downloadImage()">Download Avatar</button>
        </div>
        </div>
      </div>
  </div>

  <script type="text/javascript" src="./jQuery3.6.js"></script>
  <script src="three.min.js"></script>
  <script src="GLTFLoader.js"></script>
  <script src="OrbitControls.js"></script>
  <script src="text-texture.js"></script>
  <script src="text-sprite.js"></script>
  <script>
    let scene, camera, renderer, controls, light, model;
    function downloadImage() {
      var fileName = $("#fileName").val();
      var link = document.createElement('a');
      if (fileName && fileName.trim().length > 0)
        link.download = fileName + '.png';
      else
        link.download = 'filename.png';
      renderer.render(scene, camera);
      renderer.domElement.toDataURL().replace("image/png", "image/octet-stream");
      link.href = renderer.domElement.toDataURL().replace("image/png", "image/octet-stream");
      link.click();
    }
    const targetElement = document.getElementById('drawable')

    function init() {
      scene = new THREE.Scene();
      let textLoader = new THREE.TextureLoader();
      textLoader.load(
        "./<?php echo ($background); ?>",
        function (texture) {
          scene.background = texture;
        }
      );

      camera = new THREE.PerspectiveCamera(
        14,
        targetElement.offsetWidth / targetElement.offsetHeight,
        1,
        5000
      );
      camera.position.set(0, .4, 5);

      // scene.add(new THREE.AxesHelper(500));

      light = new THREE.PointLight(0xffa95c, 4);
      light.position.set(-50, 50, 50);
      light.castShadow = true;
      light.shadow.bias = -0.0001;
      light.shadow.mapSize.width = 1024 * 4;
      light.shadow.mapSize.height = 1024 * 4;
      scene.add(light);

      // light2 = new THREE.PointLight(0xffa95c, 4);
      // light2.position.set(0, 0, -50);
      // scene.add(light2);

      light3 = new THREE.PointLight(0x2458c7, 4);
      light3.position.set(-150, 0, 0);
      scene.add(light3);

      hemiLight = new THREE.HemisphereLight(0xffeeb1, 0x080820, 4);
      scene.add(hemiLight);

      renderer = new THREE.WebGLRenderer({antialias:true});
      renderer.toneMapping = THREE.ReinhardToneMapping;
      renderer.toneMappingExposure = 1.6;
      renderer.setSize(targetElement.offsetWidth, targetElement.offsetHeight);
      renderer.shadowMap.enabled = true;
      $("#drawable").append(renderer.domElement);
      const loader = new THREE.GLTFLoader();

      loader.load(
        "./<?php echo ($glbFilepath); ?>",
        function (gltf) {
          let fontSize =1.25;
          let x = .5;
          let y = 3.5;
          // console.log("comming");
          gltf.scene.traverse(function (child) {
            if (child.isMesh) {
              child.castShadow = true;
              child.receiveShadow = true;
              child.geometry.center(); // center here
            }
          });
          // scale here
          scene.add(gltf.scene);
          let sprite = new THREE.TextSprite({
            text: "<?php echo($to);?>",
            // fontFamily: 'Arial, Helvetica, sans-serif',
            fontSize: fontSize,
            color: "<?php echo($colorDb);?>",
          });
          
          sprite.center.set(x, y);
          scene.add(sprite);

          animate();
        },
        function (loading) {},
        function (error) {
          console.error(error);
        }
      );

    }

    function animate() {

      renderer.render(scene, camera);
      light.position.set(
        camera.position.x + 10,
        camera.position.y + 10,
        camera.position.z + 10
      );
      requestAnimationFrame(animate);
    }
    init();
    
  </script>
</body>

</html>