<?php
require_once 'ConnectToDB.php';
require_once 'Point.php';
require_once 'Triangle.php';

$pointHandler = new Point();
$triangleHandler = new Triangle();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            if (isset($_POST['x'], $_POST['y']) && is_numeric($_POST['x']) && is_numeric($_POST['y'])) {
                $x = $_POST['x'];
                $y = $_POST['y'];
                $pointHandler->create($x, $y);
            } else {
                echo "Invalid input. Please enter numeric values.";
            }
            break;

        case 'edit':
            if (isset($_POST['id'], $_POST['x'], $_POST['y']) && is_numeric($_POST['id']) && is_numeric($_POST['x']) && is_numeric($_POST['y'])) {
                $id = $_POST['id'];
                $x = $_POST['x'];
                $y = $_POST['y'];
                $pointHandler->edit($x, $y, $id);

                // Revalidate triangles containing this point
                $triangles = $triangleHandler->getAll();
                foreach ($triangles as $triangle) {
                    if (in_array($id, [$triangle['a'], $triangle['b'], $triangle['c']])) {
                        $triangleHandler->deleteTriangle($triangle['id']);
                    }
                }
            } else {
                echo "Invalid input. Please enter numeric values.";
            }
            break;

        case 'delete':
            if (isset($_POST['id']) && is_numeric($_POST['id'])) {
                $id = $_POST['id'];
                $pointHandler->delete($id);

                // Delete triangles containing this point
                $triangles = $triangleHandler->getAll();
                foreach ($triangles as $triangle) {
                    if (in_array($id, [$triangle['a'], $triangle['b'], $triangle['c']])) {
                        $triangleHandler->deleteTriangle($triangle['id']);
                    }
                }
            } else {
                echo "Invalid input. Please enter numeric values.";
            }
            break;

        case 'createTriangle':
            if (isset($_POST['points']) && count($_POST['points']) === 3) {
                $points = $_POST['points'];
                $triangleHandler->createTriangle($points[0], $points[1], $points[2]);
            } else {
                echo "Please select exactly three points to form a triangle.";
            }
            break;

        default:
            echo "Invalid action.";
            break;
    }

    // Redirect back to the main page
    header('Location: index.php');
    exit;
}
?>