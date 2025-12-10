<!DOCTYPE html>
<html>
<head>
    <title>Students List</title>
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
    <h2>Students List</h2>
    <table>
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Date of Birth</th>
                <th>Grades</th>
                <th>Courses</th>
                <th scope="col">NIC Front</th>
                                                <th scope="col">NIC Back</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->reg_no }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->ph_no }}</td>
                    <td>{{$student->dob}}</td>
                            <td>
    @if($student->grade)
        {{ $student->grade->grade_name }}
    @else
        <span class="text-danger">No Grade Assigned</span>
    @endif
</td>



                            <td>
                @if($student->courses->count() > 0)
                    @foreach($student->courses as $course)
                       <span style="margin: 5px">{{ $course->course_name }}</span>

                    @endforeach
                @else
                    <span class="text-danger">No Courses Assigned</span>
                @endif
            </td>

            <td>
                          
            
            <img src="{{ asset($student->nic_front) }}" width= '50' height='50' class="img img-responsive" />
</td>
<td>
<img src="{{ asset($student->nic_back) }}" width= '50' height='50' class="img img-responsive" />

</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
