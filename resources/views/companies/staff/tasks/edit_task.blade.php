<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Task</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="edit_task_form" action="{{ url('staff/updateTask', [$task->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Project</label>
                    <select class="form-control select" name="project_id">
                        <@foreach($projects as $key)
                        <option value="{{$key->id}}" {{ $key->id === $task->project_id ? 'selected' : '' }}>{{$key->title}}</option>
                        @endforeach
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Task Name</label>
                    <input type="text" name="title" value="{{$task->title}}" class="form-control">
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Assigned To</label>
                    <select class="form-control select" name="assigned_to">
                        <@foreach($employees as $key)
                        <option value="{{$key->id}}" {{ $key->id === $task->assigned_to ? 'selected' : '' }}>{{$key->name}}</option>
                        @endforeach
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Task Priority</label>
                    <select class="form-control select" name="priority">
                        <option>Select</option>
                        <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control select" name="status">
                        <option value="">Select</option>
                        <option value="complete" {{ $task->status === 'complete' ? 'selected' : '' }}>Complete</option>
                        <option value="inprogress" {{ $task->status === 'inprogress' ? 'selected' : '' }}>Inprogress</option>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" id="" cols="30" rows="4">{{$task->notes}}</textarea>
                </div>
                <div class="submit-section text-center">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_task_form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                //packages_table.ajax.reload();
                //$('#edit_modal').modal('hide');
                window.location.reload(); // Reload the page
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log(xhr.responseText);
            }
        });
    });
    
</script>