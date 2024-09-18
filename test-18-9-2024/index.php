<?php
require_once 'ConnectToDB.php';
require_once 'Point.php';

$points = (new Point())->getAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test 18. 9. 2024</title>
</head>
<body>
<h1>Points</h1>
<form id="calculationForm" onsubmit="return false;" style="margin-bottom: 2rem">
    <div id="pointsContainer">
        <?php foreach ($points as $point): ?>
            <div>
                <label>
                    <input type="checkbox" name="points[]" value="<?= htmlspecialchars($point['id']) ?>" data-x="<?= htmlspecialchars($point['x']) ?>" data-y="<?= htmlspecialchars($point['y']) ?>" onclick="validateSelection()">
                    {<?= htmlspecialchars($point['x']) ?>, <?= htmlspecialchars($point['y']) ?>}
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <button id="distanceButton" style="margin-top: 2rem" type="button" onclick="calculateDistance()" disabled>Calculate Distance</button>
</form>

<script>
    function validateSelection() {
        const selectedPoints = document.querySelectorAll('input[name="points[]"]:checked');
        const distanceButton = document.getElementById('distanceButton');
        distanceButton.disabled = selectedPoints.length !== 1 && selectedPoints.length !== 2;
    }

    function calculateDistance() {
        const selectedPoints = document.querySelectorAll('input[name="points[]"]:checked');

        if (selectedPoints.length === 1) {
            const x = parseFloat(selectedPoints[0].dataset.x);
            const y = parseFloat(selectedPoints[0].dataset.y);
            const distance = Math.sqrt(x * x + y * y);
            alert(`Distance from (0, 0) to (${x}, ${y}) is ${distance.toFixed(2)}`);
        } else if (selectedPoints.length === 2) {
            const x1 = parseFloat(selectedPoints[0].dataset.x);
            const y1 = parseFloat(selectedPoints[0].dataset.y);
            const x2 = parseFloat(selectedPoints[1].dataset.x);
            const y2 = parseFloat(selectedPoints[1].dataset.y);
            const distance = Math.sqrt((x2 - x1) ** 2 + (y2 - y1) ** 2);
            alert(`Distance between (${x1}, ${y1}) and (${x2}, ${y2}) is ${distance.toFixed(2)}`);
        }
    }

    document.addEventListener('DOMContentLoaded', validateSelection);
</script>

</body>
</html>