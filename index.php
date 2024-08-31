<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorting Algorithms</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 wow-heading">Choose Sorting Algorithm</h1>
        <div class="text-center mb-4">
            <h4>Unsorted Array:</h4>
            <p><?php echo implode(', ', [10, 50, 0, 30, 60, 80, 88, 66, 0, 11, 444, 88, 26, 35, 74, 15, 290]); ?></p>
        </div>
        <form method="POST" action="index.php" class="text-center">
            <select name="algorithm" class="form-control form-control-lg mb-3">
                <option value="quick">Quick Sort</option>
                <option value="merge">Merge Sort</option>
                <option value="bubble">Bubble Sort</option>
                <option value="insertion">Insertion Sort</option>
                <option value="selection">Selection Sort</option>
            </select>
            <button type="submit" class="btn btn-primary btn-lg wow-button">Sort Array</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $array = [10, 50, 0, 30, 60, 80, 88, 66, 0, 11, 444, 88, 26, 35, 74, 15, 290];
            $algorithm = $_POST['algorithm'];

            function quickSort(&$arr, $low, $high) {
                if ($low < $high) {
                    $pi = partition($arr, $low, $high);
                    quickSort($arr, $low, $pi - 1);
                    quickSort($arr, $pi + 1, $high);
                }
            }

            function partition(&$arr, $low, $high) {
                $pivot = $arr[$high];
                $i = ($low - 1);

                for ($j = $low; $j <= $high - 1; $j++) {
                    if ($arr[$j] < $pivot) {
                        $i++;
                        $temp = $arr[$i];
                        $arr[$i] = $arr[$j];
                        $arr[$j] = $temp;
                    }
                }
                $temp = $arr[$i + 1];
                $arr[$i + 1] = $arr[$high];
                $arr[$high] = $temp;
                return ($i + 1);
            }

            function mergeSort(&$arr) {
                if (count($arr) > 1) {
                    $mid = floor(count($arr) / 2);
                    $left = array_slice($arr, 0, $mid);
                    $right = array_slice($arr, $mid);

                    mergeSort($left);
                    mergeSort($right);

                    $i = $j = $k = 0;

                    while ($i < count($left) && $j < count($right)) {
                        if ($left[$i] < $right[$j]) {
                            $arr[$k] = $left[$i];
                            $i++;
                        } else {
                            $arr[$k] = $right[$j];
                            $j++;
                        }
                        $k++;
                    }

                    while ($i < count($left)) {
                        $arr[$k] = $left[$i];
                        $i++;
                        $k++;
                    }

                    while ($j < count($right)) {
                        $arr[$k] = $right[$j];
                        $j++;
                        $k++;
                    }
                }
            }

            function bubbleSort(&$arr) {
                $n = count($arr);
                for ($i = 0; $i < $n - 1; $i++) {
                    for ($j = 0; $j < $n - $i - 1; $j++) {
                        if ($arr[$j] > $arr[$j + 1]) {
                            $temp = $arr[$j];
                            $arr[$j] = $arr[$j + 1];
                            $arr[$j + 1] = $temp;
                        }
                    }
                }
            }

            function insertionSort(&$arr) {
                $n = count($arr);
                for ($i = 1; $i < $n; $i++) {
                    $key = $arr[$i];
                    $j = $i - 1;

                    while ($j >= 0 && $arr[$j] > $key) {
                        $arr[$j + 1] = $arr[$j];
                        $j--;
                    }
                    $arr[$j + 1] = $key;
                }
            }

            function selectionSort(&$arr) {
                $n = count($arr);
                for ($i = 0; $i < $n - 1; $i++) {
                    $minIndex = $i;
                    for ($j = $i + 1; $j < $n; $j++) {
                        if ($arr[$j] < $arr[$minIndex]) {
                            $minIndex = $j;
                        }
                    }
                    $temp = $arr[$minIndex];
                    $arr[$minIndex] = $arr[$i];
                    $arr[$i] = $temp;
                }
            }

            switch ($algorithm) {
                case 'quick':
                    $startTime = microtime(true);
                    quickSort($array, 0, count($array) - 1);
                    $endTime = microtime(true);
                    $timeComplexity = "O(n log n)";
                    $spaceComplexity = "O(log n)";
                    $isStable = "Not Stable";
                    $isInPlace = "In-Place";
                    break;

                case 'merge':
                    $startTime = microtime(true);
                    mergeSort($array);
                    $endTime = microtime(true);
                    $timeComplexity = "O(n log n)";
                    $spaceComplexity = "O(n)";
                    $isStable = "Stable";
                    $isInPlace = "Not In-Place";
                    break;

                case 'bubble':
                    $startTime = microtime(true);
                    bubbleSort($array);
                    $endTime = microtime(true);
                    $timeComplexity = "O(n^2)";
                    $spaceComplexity = "O(1)";
                    $isStable = "Stable";
                    $isInPlace = "In-Place";
                    break;

                case 'insertion':
                    $startTime = microtime(true);
                    insertionSort($array);
                    $endTime = microtime(true);
                    $timeComplexity = "O(n^2)";
                    $spaceComplexity = "O(1)";
                    $isStable = "Stable";
                    $isInPlace = "In-Place";
                    break;

                case 'selection':
                    $startTime = microtime(true);
                    selectionSort($array);
                    $endTime = microtime(true);
                    $timeComplexity = "O(n^2)";
                    $spaceComplexity = "O(1)";
                    $isStable = "Not Stable";
                    $isInPlace = "In-Place";
                    break;
            }

            $executionTime = $endTime - $startTime;

            echo "<div class='mt-5 text-center'>";
            echo "<h4>Sorted Array: " . implode(', ', $array) . "</h4>";
            echo "<p>Time Complexity: $timeComplexity</p>";
            echo "<p>Space Complexity: $spaceComplexity</p>";
            echo "<p>Stable: $isStable</p>";
            echo "<p>In-Place: $isInPlace</p>";
            echo "<p>Execution Time: " . number_format($executionTime, 10) . " seconds</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
