<!DOCTYPE html>
<html>
<head>
    <title>Teachers List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Teacher List</h2>
    <table>
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Teacher Name</th>
                <th>Email</th>
                <th>NIC</th>
                <th>Address</th>
                <th>Phone No</th>
                
                <th>Subjects</th>
                <th>Grades</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->reg_no}}</td>
                    <td>{{ $teacher->teacher_name }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->nic }}</td>
                    <td>{{ $teacher->address }}</td>
                    <td>{{ $teacher->phone_no }}</td>
                    <td>
                        @forelse($teacher->subjects as $subject)
                            <span>{{ $subject->subject_name }}</span>
                        @empty
                            <span class="text-danger">No Subject Assigned</span>
                        @endforelse
                    </td>
                    <td>
                        @foreach($teacher->grades as $grade)
                            <span >{{ $grade->grade_name }}</span>
                        @endforeach
                    </td>


                    
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
