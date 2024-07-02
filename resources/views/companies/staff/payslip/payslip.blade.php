@php
    use App\Models\EmployeePayslip;
    $total_allowance = 0;
    $total_benefit = 0;
    $total_stat = 0;
    $total_nonstat = 0;

@endphp

@extends('companies.staff.layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Pay Slip</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                

                <form action="#" method="POST">
                    @csrf
                <h4 class="payslip-title">{{$employee->name}}</h4>
                <h4 class="payslip-title">{{$employee->staff_no}}</h4>
                <div class="row">
                    <input disabled hidden name="employee_id" value="{{$employee->id}}">
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><div class="row">
                                            <div class="col-md-6">
                                                <h5 class="m-b-10"><strong>BASIC SALARY</strong></h5>
                                            </div>
                                            <div class="col-md-6">
                                                <input disabled class="form-control w-50 pull-right" type="number" step="0.01" value="{{$basic_salary}}"  name="basic_salary" required>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>ALLOWANCES</strong></h5></td>
                                    </tr>
                                    @foreach ($allowance as $item)
                                        @php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','allowance')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_allowance += $itemVal;
                                            
                                        @endphp
                                        <input disabled hidden name="allowance_key[]" value="{{$item->id}}">
                                        <tr >
                                            <td><div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="m-b-10"><strong>{{$item->name}}</strong></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <input disabled class="form-control w-50 pull-right" type="number" value="{{$itemVal}}" name="allowance_value[]" required>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td><strong>TOTAL CASH ALLOWANCES </strong> <span class="float-right"><strong>{{$total_allowance}}</strong></span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>TOTAL CASH EMOLUMENT </strong> <span class="float-right"><strong>{{$basic_salary+$total_allowance}}</strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>BENEFITS IN KIND</strong></h5></td>
                                    </tr>
                                    @foreach ($benefit as $item)
                                        @php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','benefit')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_benefit += $itemVal;
                                            
                                        @endphp
                                        <input disabled hidden name="benefit_key[]" value="{{$item->id}}">
                                        <tr >
                                            <td><div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="m-b-10"><strong>{{$item->name}}</strong></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <input disabled class="form-control w-50 pull-right" type="number" value="{{$itemVal}}" name="benefit_value[]" required>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td><strong>TOTAL BENEFITS IN KIND </strong> <span class="float-right"><strong>{{$total_benefit}}</strong></span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>TOTAL CASH EMOLUMENT </strong> <span class="float-right"><strong>{{$basic_salary + $total_allowance + $total_benefit}}</strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>STATUTORY DEDUCTIONS</strong></h5></td>
                                    </tr>
                                    @foreach ($statutoryDed as $item)
                                        @php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','statutory_ded')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_stat += $itemVal;
                                            
                                        @endphp
                                        <input disabled hidden name="statutory_key[]" value="{{$item->id}}">
                                        <tr >
                                            <td><div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="m-b-10"><strong>{{$item->name}}</strong></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <input disabled class="form-control w-50 pull-right" type="number" value="{{$itemVal}}" name="statutory_value[]" required>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td><strong>TOTAL STATUTORY DEDUCTIONS </strong> <span class="float-right"><strong>{{$total_stat}}</strong></span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>TOTAL TAXABLE INCOME </strong> <span class="float-right"><strong>{{$basic_salary + $total_allowance + $total_benefit - $total_stat}}</strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @php
                        $salary = $basic_salary + $total_allowance + $total_benefit - $total_stat; 
                        $total_tax = App\Models\TaxCalculator::calculateTax($salary);
                    @endphp


                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tfoot class="table-danger">
                                    <tr class="table-secondary">
                                        <td><strong>PAYE </strong> <span class="float-right">{{$total_tax}}</span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>INCOME AFTER TAX</strong> <span class="float-right"><strong>{{$salary-$total_tax}}</strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>NON STATUTORY DEDUCTIONS</strong></h5></td>
                                    </tr>
                                    @foreach ($non_statutoryded as $item)
                                        @php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','nonstatutory_ded')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_nonstat += $itemVal;
                                            
                                        @endphp
                                        <input disabled hidden name="nonstatutory_key[]" value="{{$item->id}}">
                                        <tr >
                                            <td><div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="m-b-10"><strong>{{$item->name}}</strong></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <input disabled class="form-control w-50 pull-right" type="number" value="{{$itemVal}}" name="nonstatutory_value[]" required>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td><strong>TOTAL OTHER DEDUCTIONS </strong> <span class="float-right"><strong>{{$total_nonstat}}</strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tfoot class="table-danger">
                                    <tr class="table-secondary">
                                        <td><strong>NET PAY </strong> <span class="float-right">{{$salary-$total_tax-$total_nonstat}}</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
