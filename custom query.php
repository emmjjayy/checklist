<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Query</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: white; 
            font-family: sans-serif; 
        }

        .container {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start; 
            margin-top: 50px; 
            padding: 20px; 
        }

        .query-container {
            display: flex;
            flex-direction: column; 
            margin-right: 20px; 
        }

        #query {
            width: 250px;
            height: 400px; 
            resize: none;
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            font-family: inherit; 
            margin-bottom: 10px; 
        }

        #query:focus {
            outline-color: #c98860; 
        }

        .backButton, .queryButton {
            padding: 10px 20px; 
            background-color: #c98860; 
            color: #fff; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin-bottom: 10px; 
            font-family: inherit; 
        }

        .backButton:hover, .queryButton:hover {
            background-color: #9b6b43; 
        }

        #queryResult {
            flex: 1; 
        }

        table {
            border-collapse: collapse;
            border: 1px solid #E7AD99;
            width: 100%; 
            font-family: sans-serif; 
        }

        th {
            background-color: #E7AD99; 
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-family: sans-serif; 
        }

        td {
            border: 1px solid #E7AD99;
            padding: 8px;
            text-align: left;
            font-family: sans-serif; 
        }

    </style>
</head>
<body>
<div class="container">
    <div class="query-container">
        <textarea id="query" class="form-control" rows="4" placeholder="Enter your SQL query here..."></textarea>
        <button id="runQueryButton" class="queryButton" onclick="runQuery()">Run Query</button>
        <button id="backTohome" class="backButton" onclick="backTohome()">Back</button>
    </div>
    <div id="queryResult"></div>
</div>

<script>
    function runQuery() {
        var query = document.getElementById("query").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById("queryResult").innerHTML = xhr.responseText;
                }
            }
        };
        xhr.open("POST", "execute_query.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("query=" + encodeURIComponent(query));
    }

    function backTohome() {
        window.location.href = "homepage.php"; 
    }
</script>

</body>
</html>
