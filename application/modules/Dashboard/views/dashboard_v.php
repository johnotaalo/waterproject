<style type="text/css">
  .info-box-icon
  {
    background: none;
  }

  .info-box-content
  {
    line-height: 30px;
  }
</style>
<div class = "row">
<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="">
    <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Active Customers</span>
      <span class="info-box-number"><?= $customer_numbers; ?></span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="">
    <span class="info-box-icon"><i class="fa fa-money"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Unpaid Bills</span>
      <span class="info-box-number">Ksh. <?= number_format($unpaid_bills); ?></span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="">
    <span class="info-box-icon"><i class="fa fa-dollar"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Total Revenue(LifeTime)</span>
      <span class="info-box-number">Ksh. <?= number_format($total_revenue); ?></span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="">
    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Billing Months</span>
      <span class="info-box-number"><?= $billing_months_numbers; ?></span>
    </div>
    <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
</div>
</div>

<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 180px; width: 511px;" width="511" height="180">The graph comes here</canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>

                 
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">Ksh. <?= number_format($total_revenue); ?></h5>
                    <span class="description-text">TOTAL REVENUE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">Ksh. <?= number_format($unpaid_bills); ?></h5>
                    <span class="description-text">UNPAID BILLS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">Ksh. 0</h5>
                    <span class="description-text">THIS MONTH</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header"><?= $customer_numbers ?></h5>
                    <span class="description-text">CUSTOMERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>