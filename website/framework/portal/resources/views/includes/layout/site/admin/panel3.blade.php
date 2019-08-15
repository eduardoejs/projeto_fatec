<div class="col-md-8">
    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Total Revenue</h4>
              <p class="font-weight-semibold mb-0">+1.37%</p>
            </div>
            <h3 class="font-weight-medium mb-4">184.42K</h3>
          </div>
          <canvas class="mt-n4" height="90" id="total-revenue"></canva>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Transaction</h4>
              <p class="font-weight-semibold mb-0">-2.87%</p>
            </div>
            <h3 class="font-weight-medium">147.7K</h3>
          </div>
          <canvas class="mt-n3" height="90" id="total-transaction"></canva>
        </div>
      </div>
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-0">Market Overview</h4>
            <div class="d-flex align-items-center justify-content-between w-100">
              <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dateSorter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This Month</button>
                <div class="dropdown-menu" aria-labelledby="dateSorter">
                  <div class="dropdown-item" id="market-overview_1">Daily</div>
                  <div class="dropdown-item" id="market-overview_2">Weekly</div>
                  <div class="dropdown-item" id="market-overview_3">Monthly</div>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-end">
              <h3 class="mb-0 font-weight-semibold">$36,2531.00</h3>
              <p class="mb-0 font-weight-medium mr-2 ml-2 mb-1">USD</p>
              <p class="mb-0 text-success font-weight-semibold mb-1">(+1.37%)</p>
            </div>
            <canvas class="mt-4" height="100" id="market-overview-chart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Invoice</h4>
              <a href="#"><small>Show All</small></a>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est quod cupiditate esse fuga</p>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Invoice ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>INV-87239</td>
                    <td>Viola Ford</td>
                    <td>Paid</td>
                    <td>20 Jan 2019</td>
                    <td>$755</td>
                  </tr>
                  <tr>
                    <td>INV-87239</td>
                    <td>Dylan Waters</td>
                    <td>Unpaid</td>
                    <td>23 Feb 2019</td>
                    <td>$800</td>
                  </tr>
                  <tr>
                    <td>INV-87239</td>
                    <td>Louis Poole</td>
                    <td>Unpaid</td>
                    <td>25 Mar 2019</td>
                    <td>$463</td>
                  </tr>
                  <tr>
                    <td>INV-87239</td>
                    <td>Vera Howell</td>
                    <td>Paid</td>
                    <td>27 Mar 2019</td>
                    <td>$235</td>
                  </tr>
                  <tr>
                    <td>INV-87239</td>
                    <td>Allie Goodman</td>
                    <td>Unpaid</td>
                    <td>1 Apr 2019</td>
                    <td>$657</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex align-items-center pb-2">
                  <div class="dot-indicator bg-danger mr-2"></div>
                  <p class="mb-0">Total Sales</p>
                </div>
                <h4 class="font-weight-semibold">$7,590</h4>
                <div class="progress progress-md">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                </div>
              </div>
              <div class="col-md-6 mt-4 mt-md-0">
                <div class="d-flex align-items-center pb-2">
                  <div class="dot-indicator bg-success mr-2"></div>
                  <p class="mb-0">Active Users</p>
                </div>
                <h4 class="font-weight-semibold">$5,460</h4>
                <div class="progress progress-md">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card average-price-card">
        <div class="card text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between pb-2 align-items-center">
              <h2 class="font-weight-semibold mb-0">4,624</h2>
              <div class="icon-holder">
                <i class="mdi mdi-briefcase-outline"></i>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <h5 class="font-weight-semibold mb-0">Average Price</h5>
              <p class="text-white mb-0">Since last month</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>