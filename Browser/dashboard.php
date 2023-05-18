<?php
$values = array();
function add(int $id, string $name, float $price)
{
    global $values;
    $i = 0;
    // check if file exists
    if ($file_contents = file_get_contents("products.txt")) {
        // get contents of file as array
        $values = json_decode($file_contents, true);

        if (count($values) != 0) {
            if (isset($values[$id])) {
                echo "Product " . $name . " " . $id . " already exists!<br>";
                return;
            }
            foreach ($values as $k => $v) {
                if ($v[0] == $name) {
                    echo "Product " . $name . " " . $id . " already exists!<br>";
                    return;
                }
                $i = $k;
            }
            if ($id == 0)
                $id = $i + 1;
        }
        if ($id == 0)
            $id = 1;
        $values[$id] = array($name, $price);
        // save to file
        file_put_contents("products.txt", json_encode($values));
        echo "Product added successfully<br>";
    } else {
        echo "Error. File not found.\n";
    }
    return;

}
function update(int $pid, string $name, float $price)
{
    global $values;
    if ($file_contents = file_get_contents("products.txt")) {
        // get contents of file as array
        $values = json_decode($file_contents, true);
        // check if present in retrieved array
        if (!isset($values[$pid])) {
            echo "Product ID not found.\n";
            return;
        }
        $values[$pid][0] = $name;
        $values[$pid][1] = $price;
        //   save to local
        file_put_contents("products.txt", json_encode($values));
        echo "Updated successfully.\n";
    } else {
        echo "Error. File not found.\n";
    }
    return;
}
function deleteF(int $pid)
{
    global $values;
    if ($file_contents = file_get_contents("products.txt")) {
        // get contents of file as array
        $values = json_decode($file_contents, true);
        if (!isset($values[$pid])) {
            echo "Product ID not found.\n";
            return;
        }
        unset($values[$pid]);
        // save to local
        file_put_contents("products.txt", json_encode($values));
        echo "Deleted successfully\n";
    } else {
        echo "Error. File not found.\n";
    }
    return;
}
function searchById(int $pid)
{
    global $values;
    if ($file_contents = file_get_contents("products.txt")) {
        // get contents of file as array
        $values = json_decode($file_contents, true);
        if (!isset($values[$pid])) {
            echo "Product ID " . $pid . " not found";
            return;
        }
        echo "<p>PID: . $pid.</p>";
                echo "<p>Name: . {$values[$pid][0]}</p>";
                echo "<p>Price: . {$values[$pid][1]}</p><br />";
                return;
    } else {
        echo "Error. File not found.\n";
    }
    return;
}
function searchByName(string $name)
{
    global $values;
    if ($file_contents = file_get_contents("products.txt")) {
        // get contents of file as array
        $values = json_decode($file_contents, true);
        foreach ($values as $k => $v) {
            if ($v[0] == $name) {
                echo "<p>PID: . $k.</p>";
                echo "<p>Name: . $name</p>";
                echo "<p>Price: . $v[1]</p><br />";
                return;
            }
        }

        echo "\nProduct " . $name . " not found.\n";
        return;
    } else {
        echo "Error. File not found.\n";
    }
    return;

}
function read()
{
    $file_contents = file_get_contents("products.txt");

}
function displayF()
{
    global $values;
    if ($file_contents = file_get_contents("products.txt")) {
        // get contents of file as array
        $values = json_decode($file_contents, true);
        echo "<table>";
        echo "<tr><th>PID</th><th>NAME</th><th>PRICE</th></tr>";
        foreach ($values as $k => $v) {
            echo "<tr>";
            echo "<td>" . $k . "</td>";
            foreach ($v as $details) {
                echo "<td>" . $details . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else
        echo "<p>File not found!</p>";
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $choice = $_POST["choice"];
    switch ($choice) {
        case 1:
            $pid = (int) $_POST["pid"];
            $name = $_POST["name"];
            $price = (int) $_POST["price"];
            add($pid, $name, $price);
            break;
        case 2:
            $pid = (int) $_POST["pid"];
            $name = $_POST["name"];
            $price = (int) $_POST["price"];
            update($pid, $name, $price);
            break;
        case 3:
            $pid = (int) $_POST["pid"];
            deleteF($pid);
            break;
        case 4:
            $name = $_POST["name"];
            searchByName($name);
            break;
        case 5:
            $pid = $_POST["pid"];
            searchById($pid);
            break;
        case 6:
            exit();
    }
} ?>
<!DOCTYPE html>
<html>

<head>
    <title>Product App</title>

</head>

<body>
    <h1>Product App</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> <label for="choice">Choose an option:</label>
        <select name="choice" id="choice">
            <option value="1">Add a product</option>
            <option value="2">Update a product</option>
            <option value="3">Delete a product</option>
            <option value="4">Search a product by Name</option>
            <option value="5">Search a product by ID</option>
            <option value="6">Exit</option>
        </select> <br>
        <div id="productFields"> <label for="pid">Product ID:</label> <input type="number" id="pid" name="pid"><br>
            <label for="name">Name:</label> <input type="text" id="name" name="name"><br> <label
                for="price">Price:</label> <input type="number" id="price" name="price"><br>
        </div> <input type="submit" value="Submit">
    </form>
    <h2>Product List</h2>
    <?php displayF(); ?>
</body>

</html>