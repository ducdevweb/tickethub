
<?php
$i = [2, 2, 5, 4, 85, 4];
sort($i);
echo "Sắp xếp tăng dần: " . implode(", ", $i) . "\n";
$unique = array_unique($i);
echo "Mảng không trùng lặp: " . implode(", ", $unique) . "\n";
?>
