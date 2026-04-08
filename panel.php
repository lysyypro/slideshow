<?php
$conn = new mysqli("localhost", "root", "", "slideshow");

if (isset($_POST['dodaj'])) {
    $nazwa = $_POST['nazwa'];
    $typ = $_FILES['zdjecie']['type'];
    $dane = file_get_contents($_FILES['zdjecie']['tmp_name']);
    $dane = $conn->real_escape_string($dane);
    $conn->query("INSERT INTO zdjecia (nazwa, dane, typ) VALUES ('$nazwa', '$dane', '$typ')");
}

if (isset($_POST['usun'])) {
    $id = (int) $_POST['id'];
    $conn->query("DELETE FROM zdjecia WHERE id = $id");
}

if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $nazwa = $_POST['nazwa'];
    $conn->query("UPDATE zdjecia SET nazwa='$nazwa' WHERE id = $id");
}

$result = $conn->query("SELECT id, nazwa FROM zdjecia ORDER BY id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel</title>
<style>
body { 
    font-family: Arial; 
    padding: 20px; }
table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-top: 20px; }
th, td { 
    border: 1px solid #ccc; 
    padding: 10px; 
    text-align: left; }
th { 
    background: #333; 
    color: white; }
input[type="text"] { 
    padding: 5px; 
    width: 100%; }
button { 
    padding: 5px 10px; 
    cursor: pointer; }
.dodaj { background: #eee; 
    padding: 20px; 
    margin-bottom: 20px; 
    border-radius: 5px; }
.dodaj h2 { 
    margin-bottom: 10px; }
.btn-usun { 
    background: red; 
    color: white; 
    border: none; }
.btn-update { 
    background: blue; 
    color: white; 
    border: none; }
a { 
    display: inline-block; 
    margin-bottom: 20px; 
    color: black; }
</style>
</head>
<body>

<a href="slideshow.php">← Wróć do slideshow</a>

<div class="dodaj">
<h2>Dodaj zdjęcie</h2>
<form method="POST" enctype="multipart/form-data">
  <label>Nazwa:</label>
  <input type="text" name="nazwa" required><br><br>
  <label>Zdjęcie:</label>
  <input type="file" name="zdjecie" accept="image/*" required><br><br>
  <button type="submit" name="dodaj">Dodaj</button>
</form>
</div>

<table>
<tr>
  <th>Kolejność</th>
  <th>Nazwa</th>
  <th>Podgląd</th>
  <th>Usuń</th>
  <th>Update</th>
</tr>

<?php 
$i=1;
while ($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?php echo ($i++)?></td>
  <td>
    <form method="POST">
      <input type="hidden" name="id" value="<?= $row['id'] ?>">
      <input type="text" name="nazwa" value="<?= $row['nazwa'] ?>">
  </td>
  <td>
      <img src="obraz.php?id=<?= $row['id'] ?>" style="width:80px; height:50px; object-fit:cover;">
  </td>
  <td>
      <button type="submit" name="usun" class="btn-usun">Usuń</button>
  </td>
  <td>
      <button type="submit" name="update" class="btn-update">Update</button>
    </form>
  </td>
</tr>
<?php } ?>
</table>

</body>
</html>