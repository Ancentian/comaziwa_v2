<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                <li class="breadcrumb-item active">Company Settings</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="container">
        <div class="row">
          <div class="col-md-3">
            <!-- Vertical Tabs -->
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

              <a class="nav-link" id="v-pills-allowances-tab" data-toggle="pill" 
                href="#v-pills-allowances" role="tab" aria-controls="v-pills-allowances"
                 aria-selected="false">Allowances</a>

                 <a class="nav-link" id="v-pills-benefits-in-kind-tab" data-toggle="pill"
                 href="#v-pills-benefits-in-kind" role="tab" aria-controls="v-pills-benefits-in-kind"
                  aria-selected="false">Benefits in Kind</a>

                  <a class="nav-link" id="v-pills-statutory-deductions-tab" data-toggle="pill"
                 href="#v-pills-statutory-deductions" role="tab" aria-controls="v-pills-statutory-deductions"
                  aria-selected="false">Statutory Deductions</a>

                  <a class="nav-link" id="v-pills-non-statutory-deductions-tab" data-toggle="pill"
                 href="#v-pills-non-statutory-deductions" role="tab" aria-controls="v-pills-non-statutory-deductions"
                  aria-selected="false">Non Statutory Deductions</a> 
                  <a class="nav-link" id="v-pills-expense-type-tab" data-toggle="pill"
                 href="#v-pills-expense-type" role="tab" aria-controls="v-pills-expense-type"
                  aria-selected="false">Expense Types</a>  
                  
                  <a class="nav-link" id="v-pills-departments-tab" data-toggle="pill"
                 href="#v-pills-departments" role="tab" aria-controls="v-pills-departments"
                  aria-selected="false">Departments</a> 
                  
                <a class="nav-link" id="v-pills-leave-types-tab" data-toggle="pill"
                 href="#v-pills-leave-types" role="tab" aria-controls="v-pills-leave-types"
                  aria-selected="false">Leave Types</a> 

            </div>
          </div>
          <div class="col-md-9">
            <!-- Tab Content -->
            <div class="tab-content" id="v-pills-tabContent">
              
              

              <div class="tab-pane fade show active" id="v-pills-allowances" role="tabpanel" aria-labelledby="v-pills-allowances-tab">
                    <?php echo $__env->make('companies.partials.allowances.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>

              <div class="tab-pane fade" id="v-pills-benefits-in-kind" role="tabpanel" aria-labelledby="v-pills-benefits-in-kind-tab">
                    <?php echo $__env->make('companies.partials.benefits.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>

              <div class="tab-pane fade" id="v-pills-statutory-deductions" role="tabpanel" aria-labelledby="v-pills-statutory-deductions-tab">
                <?php echo $__env->make('companies.partials.deductions.statutoryDeductions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>

              <div class="tab-pane fade" id="v-pills-non-statutory-deductions" role="tabpanel" aria-labelledby="v-pills-non-statutory-deductions-tab">
                <?php echo $__env->make('companies.partials.deductions.non_statutoryDeductions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>

              <div class="tab-pane fade" id="v-pills-expense-type" role="tabpanel" aria-labelledby="v-pills-expense-type-tab">
                <?php echo $__env->make('companies.partials.expenses.expense_types', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>

              <div class="tab-pane fade" id="v-pills-departments" role="tabpanel" aria-labelledby="v-pills-departments-tab">
                <?php echo $__env->make('companies.partials.contracts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>

            <div class="tab-pane fade" id="v-pills-leave-types" role="tabpanel" aria-labelledby="v-pills-leave-types-tab">
                <?php echo $__env->make('companies.partials.leave_types.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>

              
            </div>
          </div>
        </div>
      </div>
      
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/companies/settings.blade.php ENDPATH**/ ?>