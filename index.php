<h2>Spesifikasi PC menggunakan Algoritma Genetika</h2>
<hr>
<form method="post" action="">

    Budget Rp. <input type='text' name="inputBudget" autofocus>
    &nbsp;
    <input type="submit" name="submit" value="Submit">
    <p></p>
</form>

<?php
require 'tugas-akhir.php';

$maxBudget = "";
if (isset($_POST["submit"])) {
    $maxBudget = $_POST["inputBudget"];

    if ($maxBudget === '') {
        echo '<font color =red>Enter your budget.</font>';
        die;
    }
    
    $algen = new Algen();
    $algen->budget = $maxBudget;
    $algen->crossoverRate = 0.8;
    $algen->popSize = 8;
    $algen->stoppingValue = 100000;
    $algen->maxIter = 250;

    $result = $algen->algen();

    if (empty($result)) {
        echo 'Optimum solution was not found. Try again, or add more budget.';
    } else {
        echo "<table>";
        echo "<tr><td>Your budget</td><td>: <b>Rp. " . number_format($algen->budget) . "</b></td></tr>";
        echo "<tr><td>Optimum amount</td><td>: <b>Rp. " . number_format($result['fitnessValue'])  . "</b></td></tr>";
        echo "</table>";

        echo "<br>List of items: <br>";
        echo "<table style='width:50%'><tr><td>No.</td><td>Component</td><td>Item</td><td>Socket</td><td>Slot Type</td><td>Price (Rp)</td></tr>";
        
        // foreach ($result['items'] as $key => $item) {
        //     echo "<tr><td>" . ($key + 1) . "</td><td>" . $item[0] . "</td><td  style=align:right'>" . number_format($item[1]) . "</td></tr>";
        // }

        foreach ($result['chromosome'] as $genKey => $gen){
            echo "<tr><td>" . ($genKey + 1);
                switch($genKey) {
                    case 0:
                        $component = "processor";
                        echo "</td><td>" . $component .
                        "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['name'] . 
                        "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['socket'] . 
                        "</td><td>" . 
                        "</td><td  style=align:right'>" . number_format((new Catalogue)->catalogue()[$component][$gen]['price']) .
                        "</td></tr>";
                        break;
                    case 1:
                        $component = "motherboard";
                        echo "</td><td>" . $component .
                        "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['name'] . 
                        "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['socket'] . 
                        "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['memorySlotType'] . 
                        "</td><td  style=align:right'>" . number_format((new Catalogue)->catalogue()[$component][$gen]['price']) .
                        "</td></tr>";
                        break;
                    case 2:
                        $component = "memory";
                        echo "</td><td>" . $component .
                        "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['name'] . 
                        "</td><td>" . 
                        "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['memorySlotType'] . 
                        "</td><td  style=align:right'>" . number_format((new Catalogue)->catalogue()[$component][$gen]['price']) .
                        "</td></tr>";
                        break;
                    case 3:
                        $component = "vga";
                        echo "</td><td>" . $component .
                         "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['name'] . 
                        "</td><td>" . 
                        "</td><td>" . 
                        "</td><td  style=align:right'>" . number_format((new Catalogue)->catalogue()[$component][$gen]['price']) .
                        "</td></tr>";
                        break;
                    case 4:
                        $component = "hdd";
                        echo "</td><td>" . $component .
                         "</td><td>" . (new Catalogue)->catalogue()[$component][$gen]['name'] . 
                        "</td><td>" . 
                        "</td><td>" . 
                        "</td><td  style=align:right'>" . number_format((new Catalogue)->catalogue()[$component][$gen]['price']) .
                        "</td></tr>";
                        break;
                }

                

                // echo $gen . "&nbsp;&nbsp;";
                // print_r((new Catalogue)->catalogue()[$component][$gen]);
                // echo '<br>';
            }
        echo "</table>";
    }
}

?>