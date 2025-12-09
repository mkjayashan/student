<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Classes List</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Classes List</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Grade</th>
                <th>Class Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $index => $class)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $class->grade ? $class->grade->grade_name : 'N/A' }}</td>
                    <td>{{ $class->class_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
