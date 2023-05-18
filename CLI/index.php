<?php
declare(strict_types=1);

// pid, name, price
$values = array();

// add, update, delete, display, search
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
        echo "Product " . $name . " " . $id . " already exists!\n";
        return;
      }
      foreach ($values as $k => $v) {
        if ($v[0] == $name) {
          echo "Product " . $name . " " . $id . " already exists!\n";
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
    echo "Product added successfully\n";
  } else {
    echo "Error. File not found or is void of array.\n";
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
    echo "Error. File not found or is void of array.\n";
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
    echo "Error. File not found or is void of array.\n";
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
      echo "Product ID " . $pid . " not found\n";
      return;
    }
    //   format the output of html
    echo "PID: " . $pid;
    echo "\nName: " . $values[$pid][0];
    echo "\nPrice: " . $values[$pid][1]."\n";
  } else {
    echo "Error. File not found or is void of array.\n";
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
        echo "\nPID: " . $k;
        echo "\nName: " . $name;
        echo "\nPrice: " . $v[1]."\n";
        return;
      }
    }

    echo "\nProduct " . $name . " not found.\n";
    return;
  } else {
    echo "Error. File not found or is void of array.\n";
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

  echo "PID\t\t\t\tNAME\t\t\t\t\t\tPRICE\n";
  foreach ($values as $k => $v) {
    echo $k . "\t\t\t\t";
    foreach ($v as $details) {
      echo $details . "\t\t\t\t\t\t";
    }
    echo "\n";
  }
  echo "\n";
}

function ex()
{
  echo "Hi there! Please read the options below and proceed further\n";
  echo "1. Add a product\n2. Update a product\n3. Delete a product\n4. Display products\n5. Search for a product\n";
  $loop = 'y';
  while ($loop == 'y' || $loop == "Y") {
    $choice = (int) readline("Enter one of the above choices: ");
    switch ($choice) {
      case 1:
        echo "Great choice 1!\n";
        $pid = (int) readline("Enter product ID. Put 0 if dont want to specify: ");
        $name = readline("enter name: ");
        $price = (int) readline("enter price: ");
        add($pid, $name, $price);
        break;

      case 2:
        echo "Great choice 2!\n";
        $pid = (int) readline("enter PID: ");
        global $values;
        if ($file_contents = file_get_contents("products.txt")) {
          // get contents of file as array
          $values = json_decode($file_contents, true);
          // check if present in retrieved array
          if (!isset($values[$pid])) {
            echo "Product ID not found.\n";
            return;
          }
        }
        $name = readline("enter updated name: ");
        $price = (int) readline("enter updated price: ");
        update($pid, $name, $price);
        break;

      case 3:
        echo "Great choice 3!\n";
        $pid = (int) readline("enter the product ID: ");
        deleteF($pid);
        break;

      case 4:
        echo "Great choice 4!\n";
        displayF();
        break;

      case 5:
        echo "Great choice 5!\n";
        $c = readline("Search by name? (y/n) ");
        if ($c == 'y' || $c == 'Y') {
          $name = readline("enter name: ");
          searchByName($name);
        } else {
          $pid = (int) readline("enter product ID: ");
          searchByID($pid);
        }
        break;
      default:
        echo "\nWrong input, please try again!\n";
    }
    $loop = readline("Wanna try again? (y/n): ");
  }
}
ex();
?>