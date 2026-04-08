<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<style>
.slider {
position: relative;
width: 500px;
  }
.images {
width: 100%;
height: 100vh;
object-fit: cover;
}
.arrow {
position: absolute;
top: 50%;
transform: translateY(-50%);
font-size: 40px;
color: gray;
padding: 5px 15px;
cursor: pointer;
user-select: none;
background: none;
border: none;
  }
.arrow:focus-visible {
outline: 3px solid #005fcc;
border-radius: 4px;
}
a{
  position:fixed; 
  bottom:20px; 
  right:20px; 
  background:black; 
  color:white; 
  padding:10px 20px; 
  border-radius:5px;
}
.left { 
  left: 0; 
}
.right { 
  right: 0; }
</style>
</head>
<body>
<div aria-live="polite" id="slideInfo" style="position:absolute;width:1px;height:1px;overflow:hidden;"></div>
<div class="slider">
<?php
$conn = new mysqli("localhost", "root", "", "slideshow");
$result = $conn->query("SELECT id FROM zdjecia ORDER BY id");
while ($row = $result->fetch_assoc()) { ?>
    <img class="images" alt="<?php $row['nazwa']?>" src="obraz.php?id=<?= $row['id'] ?>">
<?php } ?>
<button class="arrow left" onclick="prev()" aria-label="Poprzednie zdjęcie">&#10094;</button>
<button class="arrow right" onclick="next()" aria-label="Następne zdjęcie">&#10095;</button>
<a href="panel.php">Panel zarządzania</a>
</div>
<script>
var id = 0;
show(id);
function show(n) {
var x = document.getElementsByClassName("images");
for (var i = 0; i < x.length; i++) {
x[i].style.display = "none";
  }
x[n].style.display = "block";
document.getElementById("slideInfo").textContent = "Zdjęcie " + (n + 1) + " z " + x.length;
}
function next() {
var x = document.getElementsByClassName("images");
id++;
if (id >= x.length) { id = 0; }
show(id);
}
function prev() {
var x = document.getElementsByClassName("images");
id--;
if (id < 0) { id = x.length - 1; }
show(id);
}
document.addEventListener("keydown", function(e) {
if (e.key === "ArrowRight") { e.preventDefault(); next(); }
if (e.key === "ArrowLeft")  { e.preventDefault(); prev(); }
});
</script>
</body>
</html>