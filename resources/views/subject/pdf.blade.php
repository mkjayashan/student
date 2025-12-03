
<!DOCTYPE html>
<html>
<head>
    <title>Course List PDF</title>
    <style>
        table, th, td {
            border:1px solid #000;
            border-collapse: collapse;
            padding:8px;
        }
        table {
            width:100%;
        }
    </style>
</head>
<body>
<h2>Subject List</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
    <tr>
        <th>Subject Code</th>
        <th>Subject Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subjects as $subject)
        <tr>
            <td>{{ $subject->subject_code }}</td>
            <td>{{ $subject->subject_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
