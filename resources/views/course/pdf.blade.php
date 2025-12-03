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

<h2>Course List</h2>

<table>
    <thead>
    <tr>
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Subjects</th>
    </tr>
    </thead>

    <tbody>
    @foreach($courses as $course)
        <tr>
            <td>{{ $course->course_code }}</td>
            <td>{{ $course->course_name }}</td>
            <td>
                @foreach($course->subjects as $sub)
                    {{ $sub->subject_name }},
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
