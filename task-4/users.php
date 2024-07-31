<?php
$database = 'database.json';
if (file_exists($database)) {
    $data = json_decode(file_get_contents($database), true);
} else {
    $data = [];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registered Users</title>
</head>
<body>
    <h1>Registered Users</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
        </tr>
        <?php foreach ($data as $user) { ?>
            <tr>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><img src="images/<?php echo $user['image']; ?>" width="50" height="50"></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
