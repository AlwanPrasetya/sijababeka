<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Display Files with Time</title>
</head>

<body>

    <div class="container">
        <h2>Upload and Display Files with Time</h2>
        <!-- Form untuk memasukkan teks dan menentukan waktu kirim -->
        <form action="process.php" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br>

            <label for="textData">Text:</label><br>
            <textarea id="textData" name="textData" rows="4" cols="50"></textarea><br>

            <label for="timeToSend">Time to Send:</label><br>
            <input type="datetime-local" id="timeToSend" name="timeToSend"><br><br>

            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
    <style>
        .card {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
        }
    </style>
    </head>

    <body>

        <div class="container">
            <h2>Metadata Displayed as Cards</h2>
            <div class="cards-container">
                <?php
                // Baca isi metadata.txt
                $metadata = file_get_contents("files/metadata.txt");

                // Pisahkan setiap entri
                $entries = explode("\n\n", $metadata);

                // Looping melalui setiap entri
                foreach ($entries as $entry) {
                    // Pisahkan data menjadi nama, email, waktu kirim, dan teks
                    $data = explode("\n", $entry);

                    // Tampilkan data dalam bentuk card
                    echo "<div class='card'>";
                    echo "<p><strong>Name:</strong> " . substr($data[0], 6) . "</p>";
                    echo "<p><strong>Email:</strong> " . substr($data[1], 7) . "</p>";
                    echo "<p><strong>Time to Send:</strong> " . date("F j, Y, g:i a", substr($data[2], 15)) . "</p>";
                    echo "<p><strong>Text:</strong> " . substr($data[3], 6) . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </body>

</html>