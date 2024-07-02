<table class="table table-striped custom-table table-nowrap mb-0">
    <thead>
        <tr>
            <th>Staff Name</th> <!-- Empty header cell for spacing -->
            @foreach($calendar_days as $day)
                <th>{{$day}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($attendance_array as $user)
            <tr>
                <td>{{$user['name']}}</td>
                @foreach($user['attendance'] as $one)                                
                    <td>
                        @if ($one == 1)
                            <i class="fa fa-check text-success"></i>
                        @else
                            <i class="fa fa-close text-danger"></i>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>