@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Communications</a></li>
                <li class="breadcrumb-item active">Emails</li>
            </ul>
        </div>
        @if(staffCan("view.emails"))
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#send_mail"><i class="fa fa-plus"></i> Send Mail</a> &nbsp;
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#bulk_send_mail"><i class="fa fa-plus"></i> Send Bulk</a>
            </div>
        @endif
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="outbox_table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Message</th>
                        {{-- <th>Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="send_mail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                    <!--<div class="alert alert-danger alert-dismissible fade show" role="alert">-->
                    <!--    Please add your email settings here <a href="{{url('communications/mailSettings')}}">Communications / Mail Settings</a>-->
                    <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
                    <!--        <span aria-hidden="true">×</span>-->
                    <!--    </button>-->
                    <!--</div>-->
                
                <form id="send_mail_form">
                    @csrf
                    <div class="form-group">
                        <label>Choose From Template:</label>
                        <select class="select" id="template_select">
                            <option value=""></option>
                            @foreach($templates as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email To:</label>
                        <select class="select multiple" name="email[]" multiple required>
                            <option value=""></option>
                            @foreach($employees as $key)
                                <option value="{{ $key->email }}">{{ $key->name }}({{ $key->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Subject" name="subject" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <textarea rows="4" class="form-control" id="message" name="message" placeholder="Enter your message here" required></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <span id="submit_send_email">Send</span> <i class="fa fa-send m-l-5"></i>
                            </button>
                        </div>
                    </div>
                
                    <!-- Hidden input field to hold the template message -->
                    <input type="hidden"  id="template_message" name="template_message" value="">
                </form>
                
                
                
            </div>
        </div>
    </div>
</div>

<div id="bulk_send_mail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                    <!--<div class="alert alert-danger alert-dismissible fade show" role="alert">-->
                    <!--    Please add your email settings here <a href="{{url('communications/mailSettings')}}">Communications / Mail Settings</a>-->
                    <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
                    <!--        <span aria-hidden="true">×</span>-->
                    <!--    </button>-->
                    <!--</div>-->
               
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-4 pull-right">
                            <a href="{{ asset('files/bulk-emails.xlsx') }}" class="btn btn-primary" download><i class="fa fa-download"></i> Download Template</a>
                        </div>
                    </div>
                    <form id="send_bulky_mail_form"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Choose From Template:</label>
                            <select class="select" id="template_selection" >
                                <option value=""></option>
                                @foreach($templates as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="file" name="csv_file" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Subject" name="subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <textarea rows="4" class="form-control" id="template_msg" name="message" required></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><span id="submit_send_email">Send</span> <i class="fa fa-send m-l-5"></i></button>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
    // Add event listener to the template select element
    $('#template_select').on('change', function() {
      var templateId = $(this).val();
  
      $.ajax({
        url: '/communications/fetch-template-message/' + templateId,
        method: 'GET',
        success: function(response) {
          // Update the template message input field
          //$('#template_message').val(response.message);
          var plainTextMessage = $('<div>').html(response.message).text();
          //$('#message').val(response.message);
          $('#template_message').val(plainTextMessage);
          
            $('#message').html(plainTextMessage);
        },
        error: function(xhr, status, error) {
          console.log(error); 
        }
      });
    });
  });

  $(document).ready(function() {
    // Add event listener to the template select element
    $('#template_selection').on('change', function() {
      var templateId = $(this).val();
  
      $.ajax({
        url: '/communications/fetch-template-message/' + templateId,
        method: 'GET',
        success: function(response) {
          // Update the template message input field
          //$('#template').val(response.message);
          var plainTextMessage = $('<div>').html(response.message).text();
          //$('#message').val(response.message);
          
        $('#template_msg').html(plainTextMessage);
        },
        error: function(xhr, status, error) {
          console.log(error); 
        }
      });
    });
  });
 
</script> 
@endsection
