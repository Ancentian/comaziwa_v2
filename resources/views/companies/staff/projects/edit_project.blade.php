<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_project_form" action="{{ url('staff/updateProject', [$project->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" name="title" value="{{$project->title}}" type="text">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Priority</label><br>
                            <select class="select form-control" style="width: 100%;" name="priority">
                                <option>--Choose Here--</option>
                                <option value="high" {{ $project->priority === 'high' ? 'selected' : '' }}>High</option>
                                <option value="medium" {{ $project->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="low" {{ $project->priority === 'low' ? 'selected' : '' }}>Low</option>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="start_date" value="{{$project->start_date}}" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Due Date</label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="due_date" value="{{$project->due_date}}" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Team Leader</label><br>
                            <select class="select form-control w-100 multiple" style="width: 100%;" name="team_leader">
                                <option>--Choose Here--</option>
                                @foreach($employees as $key)
                                <option value="{{$key->id}}" {{ $key->id === $project->team_leader ? 'selected' : '' }}>{{$key->name}}</option>
                                @endforeach
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Project Team</label><br>
                            <select class="select multiple" name="project_team[]" multiple style="width: 100%;">
                                <option>--Choose Here--</option>
                                @foreach($employees as $key)
                                <option value="{{$key->id}}" {{in_array($key->id,json_decode($project->project_team)) ? 'selected' : ''}} >{{$key->name}}</option>
                                @endforeach
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>                                          
                </div>
                <div class="row">     
                    <div class="col-12">
                        <div class="pro-progress">
                            <div class="pro-progress-bar">
                            <h4>Progress</h4>
                            <div class="progress">
                                <input type="range" min="0" max="100" value="{{$project->progress}}" name="progress" class="progress-range progress-input"  style="width: 100%">
                            </div>
                            <span class="progress-value">{{$project->progress}}%</span>
                            </div>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" id="" cols="30" rows="4">{{$project->notes}}</textarea>
                    </div>
                </div>
                
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".select").select2();
    $("#edit_project_form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                projects_table.ajax.reload();
                //$('#edit_modal').modal('hide');
                $("#edit_modal").modal('hide');
                toastr.success(response.message,'Successs');
            },
            error: function(xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        });
    }); 

    $(document).ready(function() {
        $('.progress-input').on('input', function() {
            var value = $(this).val();
            $('.progress-value').text(value + '%');
        });
    });

</script>
