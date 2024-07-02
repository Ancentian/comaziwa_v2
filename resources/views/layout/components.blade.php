<!-- Delete  Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Record</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <input type="hidden" id="modal_delete_action">
                        <div class="col-6">
                            <a href="#" id="modal_delete_button" class="btn btn-primary continue-btn">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

@php
       $allpackages = App\Models\Package::get();
@endphp



<!-- Delete  Modal -->
<div class="modal custom-modal fade" id="welcome_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Welcome on board!</h3>
                    <p>Please choose one package that suits you and enjoy {{env('TRIAL_PERIOD')}} days free trial!</p>
                </div>
                @if (!empty($allpackages))
                <div class="row">
                    @foreach($allpackages as $module)
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{$module->name}}</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Price:</strong> GHS {{number_format($module->price)}}</li>
                                <li class="list-group-item"><strong>No of Staff:</strong> {{number_format($module->staff_no)}}</li>
                              </ul>

                            <div class="d-flex justify-content-center mt-3 mb-2">
                              <a class="btn btn-primary mr-2 try-button btn-sm" data-action="{{ url('dashboard/tryplan',[$module->id]) }}" href="#"><i class="fa fa-pencil"></i> Try it for Free</a>
                            </div>     
                        </div>
                    </div>
                @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<div class="modal custom-modal fade" id="renew_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Choose subscription!</h3>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p>Choose and pay for a subscription!</p>
                    </div>
                </div>
                @if (!empty($allpackages))
                <div class="row">
                    @foreach($allpackages as $module)
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{$module->name}}</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Price:</strong> GHS {{number_format($module->price)}}</li>
                                <li class="list-group-item"><strong>No of Staff:</strong> {{number_format($module->staff_no)}}</li>
                                <?php
                                $moduleString = $module->module;
                                $modules = explode(',', $moduleString);
                                ?>
                                @foreach($modules as $moduleItem)
                                    <?php
                                    $moduleItem = str_replace('_', ' ', $moduleItem);
                                    $moduleItem = ucfirst($moduleItem);
                                    ?>
                                    <li class="list-group-item"> <i class="fa fa-check text-success"></i> {{$moduleItem}}</li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-center mt-3 mb-2">
                                @if($module->price == 0)
                                    <a class="btn btn-success mr-2 try-button btn-sm" data-action="{{ url('dashboard/tryplan',[$module->id]) }}" href="#"><i class="fa fa-pencil"></i> Try it for Free</a>
                                @else
                                <a class="btn btn-primary mr-2 pay-button" onclick="paysubscription({{$module->price}},{{$module->id}},'monthly')" href="#"><i class="fa fa-pencil"></i> Pay {{@num_format($module->price)}} Monthly</a>
                                <a class="btn btn-info mr-2 pay-button" onclick="paysubscription({{$module->annual_price}},{{$module->id}},'annual')" href="#"><i class="fa fa-pencil"></i> Pay {{@num_format($module->annual_price)}} Annually</a>
                                @endif
                              
                            </div>     
                        </div>
                    </div>
                @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete  Modal with Reload -->
<div class="modal custom-modal fade" id="delete_reload_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Record</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <input type="hidden" id="modal_delete_reload_action">
                        <div class="col-6">
                            <a href="#" id="modal_delete_reload_button" class="btn btn-primary continue-btn">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal with reload -->

{{-- Edit Modal --}}
<div id="edit_modal" class="modal custom-modal fade" role="dialog">
</div>
{{-- End Edit Modal --}}