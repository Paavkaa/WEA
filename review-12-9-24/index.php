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
    <title>Create Point</title>
</head>
<body>
<h1>Create Point</h1>
<form method="post" action="actions.php">
    <input type="hidden" name="action" value="create">
    <label for="x">X:</label>
    <input id="x" name="x" type="number" required>
    <label for="y">Y:</label>
    <input id="y" name="y" type="number" required>
    <button type="submit">Create</button>
</form>

<h1>Points</h1>

<h2>Select calculation</h2>
<form id="calculationForm" method="post" action="actions.php" onsubmit="return validateCalculation()" style="margin-bottom: 2rem">
    <input type="hidden" name="action" id="formAction" value="">
    <label>
        <input type="radio" name="calculate" value="distance" checked onclick="updateSelection()"> Distance from (0, 0)
    </label>
    <label>
        <input type="radio" name="calculate" value="triangle" onclick="updateSelection()"> Triangle
    </label>
    <div id="pointsContainer">
        <?php foreach ($points as $point): ?>
            <div>
                <label>
                    <input type="checkbox" name="points[]" value="<?= htmlspecialchars($point['id']) ?>" data-x="<?= htmlspecialchars($point['x']) ?>" data-y="<?= htmlspecialchars($point['y']) ?>" onclick="validateSelection()">
                    Point (<?= htmlspecialchars($point['x']) ?>, <?= htmlspecialchars($point['y']) ?>)
                </label>
                <form method="post" action="actions.php" style="display:inline;">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($point['id']) ?>">
                    <input type="number" name="x" value="<?= htmlspecialchars($point['x']) ?>" required>
                    <input type="number" name="y" value="<?= htmlspecialchars($point['y']) ?>" required>
                    <button type="submit">Edit</button>
                </form>
                <form method="post" action="actions.php" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($point['id']) ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this point?');">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    <button id="distanceButton" type="button" style="display: none" onclick="calculateDistance()">Calculate Distance</button>
    <button id="triangleButton" type="submit" style="display: none">Create Triangle</button>
</form>

<h1>Triangles</h1>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        validateSelection(); // Initialize button state
    });

    function updateSelection() {
        validateSelection();
    }

    function validateSelection() {
        const calculateType = document.querySelector('input[name="calculate"]:checked').value;
        const selectedPoints = document.querySelectorAll('input[name="points[]"]:checked').length;
        const distanceButton = document.getElementById('distanceButton');
        const triangleButton = document.getElementById('triangleButton');

        distanceButton.style.display = (calculateType === 'distance') ? 'inline' : 'none';
        distanceButton.disabled = (calculateType === 'distance' && selectedPoints !== 1);

        triangleButton.style.display = (calculateType === 'triangle') ? 'inline' : 'none';
        triangleButton.disabled = (calculateType === 'triangle' && selectedPoints !== 3);
    }

    function calculateDistance() {
        const selectedPoints = document.querySelectorAll('input[name="points[]"]:checked');

        if (selectedPoints.length === 1) {
            const x = parseFloat(selectedPoints[0].dataset.x);
            const y = parseFloat(selectedPoints[0].dataset.y);
            const distance = Math.sqrt(x * x + y * y);
            alert(`Distance from (0, 0) to (${x}, ${y}) is ${distance.toFixed(2)}`);
        }
    }

    function submitTriangle() {
        document.getElementById('formAction').value = 'createTriangle';
        console.log('submitting');
        return true;
    }
</script>

</body>
</html>