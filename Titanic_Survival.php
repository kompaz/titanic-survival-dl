<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titanic Survival Model Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('RMS_Titanic_3.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            width: 400px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="number"],
        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .result-box {
            margin-left: 150px; /* 100px left margin added here */
            padding: 15px;
            border: 1px solid #ddd;
            background-color: rgba(249, 249, 249, 0.9);
            border-radius: 4px;
            text-align: center;
        }
        .Survived {
            background-color: #28a745; /* Yeşil */
        }
        .Not-Survived {
            background-color: #dc3545; /* Kırmızı */
        }
        
    </style>
</head>
<body>

<?php

    // Check if form is submitted using POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $url = 'http://127.0.0.1:5000/'; // Corrected URL
        
        // Collecting form data and storing it in an array
        $data = array(
            'Pclass' => $_POST['Pclass'],
            'Sex' => $_POST['Sex'],
            'Age' => floatval($_POST['Age']),
            'SibSp' => $_POST['SibSp'],
            'Parch' => $_POST['Parch'],
            'Fare' => $_POST['Fare'],
            'Embarked' => $_POST['Embarked']
        );
       
        // Encoding data array to JSON format
        $data_json = json_encode($data);
        
        // Setting options for the POST request
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => $data_json,
            ),
            
        );
        // Creating context for POST request
        $context  = stream_context_create($options);

        // Sending POST request and receiving response
        $result = file_get_contents($url, false, $context);

        // Decoding JSON response
        $response = json_decode($result, true);

        // Checking if response is valid and setting status message
        if (is_array($response) && isset($response['prediction'][0][0])) {
            $prediction = $response['prediction'][0][0];
            $status = $prediction >= 0.50 ? "Survived" : "Not Survived";
            $statusClass = $prediction >= 0.50 ? "Survived" : "Not-Survived";
        } else {
            $status = "Prediction data not found";
            $statusClass = "error";
        }
    }
    ?>
    
    <form method="post">
        <div class="form-group">
            <label for="Pclass">Passenger Class</label>
            <select id="Pclass" name="Pclass">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Sex">Gender</label>
            <select id="Sex" name="Sex">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Age">Age</label>
            <input type="number" id="Age" name="Age" step="0.5" min="1" required> 
        </div>
        <div class="form-group">
            <label for="SibSp">Siblings/Spouses</label>
            <input type="number" id="SibSp" name="SibSp" min="0" required>
        </div>
        <div class="form-group">
            <label for="Parch">Parents/Children</label>
            <input type="number" id="Parch" name="Parch" min="0" required>
        </div>
        <div class="form-group">
            <label for="Fare">Ticket Fare</label>
            <input type="number" id="Fare" name="Fare" step="0.0001" min="0" required>
        </div>
        <div class="form-group">
        <label for="Embarked">Embarkation Port <br>(Q: Queensstown, C: Cherbourg, S: Southampton)</label>
            <select id="Embarked" name="Embarked">
                <option value="S">S</option>
                <option value="Q">Q</option>
                <option value="C">C</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit">
        </div>
    </form>
    
    <?php if(isset($status)): ?>
    <div class="result-box <?php echo $statusClass; ?>">
        <h2>The Person Could: <?php echo $statusClass; ?></h2>
    </div>
    <?php endif; ?>
</body>
</html>
