<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklists</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>

        .container {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            margin-top: 50px;
        }

        #query {
            width: 300px;
            height: 500px;
            resize: none;
        }

        #runButton {
            background-color: #CA9880; /* Change the background color of the button */
            color: white; /* Change the text color of the button */
            border: none; /* Remove button border */
            padding: 10px 20px; /* Adjust button padding */
        }

        #runButton:hover {
            background-color: #CA9880; /* Change the hover color of the button */
        }

        #queryResult {
            margin-left: 20px;
            table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #CA9880; /* Header background color */
        }

        tr:nth-child(even) {
            background-color: #D1A7A0; /* Even row background color */
        }

        tr:hover {
            background-color: #D1A7A0; /* Hovered row background color */
        }
    </style>
</head>
<body>

<div class="container">
    <div>
        <textarea id="query" class="form-control" rows="4" placeholder="Enter your SQL query here..."></textarea>
        <br>
        <button onclick="runQuery()" id="runButton" class="btn btn-primary">Run Query</button>
    </div>
    <div id="queryResult"></div>
</div>

<script>
function runQuery() {
    var query = document.getElementById("query").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("queryResult").innerHTML = xhr.responseText;
        }
    };
    xhr.open("POST", "execute_query.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("query=" + encodeURIComponent(query));
}
</script>

</body>
</html>
