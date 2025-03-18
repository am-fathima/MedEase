<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedEase - Choose a Cardiac Specialist</title>
    <link rel="stylesheet" href="speacialist.css">  
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MedEase</h1>
        </div>
        <div class="content">
            <h2>Choose a Cardiac Specialist</h2>
            <table>
                <tbody>
                    <!-- Dynamic list of doctors -->
                    <?php
                    // Sample array of doctors for demonstration
                    $doctors = [
                        ['id' => 1, 'name' => 'Dr. John Doe', 'specialization' => 'Cardiologist'],
                        ['id' => 2, 'name' => 'Dr. Jane Smith', 'specialization' => 'Cardiologist'],
                        ['id' => 3, 'name' => 'Dr. Robert Brown', 'specialization' => 'Cardiologist'],
                        ['id' => 4, 'name' => 'Dr. Silva', 'specialization' => 'Cardiologist'],
                        ['id' => 5, 'name' => 'Dr. Perera', 'specialization' => 'Cardiologist'],
                    ];

                    foreach ($doctors as $doctor) {
                        echo "
                        <tr>
                            <td><span class='icon'></span>{$doctor['name']}</td>
                            <td>{$doctor['specialization']}</td>
                            <td>
                                <form action='doctor_profile.php' method='GET'>
                                    <input type='hidden' name='doctor_id' value='{$doctor['id']}'>
                                    <button class='book-btn'>Book Now</button>
                                </form>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="back-btn-section">
                <button class="back-btn"><a href="categories.html">Go Back</a></button>
            </div>
        </div>
    </div>
</body>
</html>
