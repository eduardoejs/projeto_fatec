<div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h1 class="card-title mb-4">Website Audience Metrics</h1>
          <div class="row">
            <div class="col-5 col-md-5">
              <div class="wrapper border-bottom mb-2 pb-2">
                <h4 class="font-weight-semibold mb-0">523,200</h4>
                <div class="d-flex align-items-center">
                  <p class="mb-0">Page Views</p>
                  <div class="dot-indicator bg-secondary ml-auto"></div>
                </div>
              </div>
              <div class="wrapper">
                <h4 class="font-weight-semibold mb-0">753,098</h4>
                <div class="d-flex align-items-center">
                  <p class="mb-0">Bounce Rate</p>
                  <div class="dot-indicator bg-primary ml-auto"></div>
                </div>
              </div>
            </div>
            <div class="col-5 col-md-7 d-flex pl-4">
              <div class="ml-auto">
                <canvas height="100" id="realtime-statistics"></canvas>
              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-6">
              <div class="d-flex align-items-center mb-2">
                <div class="icon-holder bg-primary text-white py-1 px-3 rounded mr-2">
                  <i class="icon ion-logo-buffer icon-sm"></i>
                </div>
                <h2 class="font-weight-semibold mb-0">3,605</h2>
              </div>
              <p>Since last week</p>
              <p><span class="font-weight-medium">0.51%</span> (30 days)</p>
            </div>
            <div class="col-6">
              <div class="mt-n3 ml-auto" id="dashboard-guage-chart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">World sellings</h4>
          <div id="dashboard-vmap" class="vector-map"></div>
          <div class="wrapper">
            <div class="d-flex w-100 pt-2 mt-4">
              <p class="mb-0 font-weight-semibold">California</p>
              <div class="wrapper ml-auto d-flex align-items-center">
                <p class="font-weight-semibold mb-0">26,437</p>
                <p class="ml-1 mb-0">26%</p>
              </div>
            </div>
            <div class="d-flex w-100 pt-2">
              <p class="mb-0 font-weight-semibold">Washington</p>
              <div class="wrapper ml-auto d-flex align-items-center">
                <p class="font-weight-semibold mb-0">3252</p>
                <p class="ml-1 mb-0">64%</p>
              </div>
            </div>
            <div class="d-flex w-100 pt-2">
              <p class="mb-0 font-weight-semibold">Michigan</p>
              <div class="wrapper ml-auto d-flex align-items-center">
                <p class="font-weight-semibold mb-0">4,987</p>
                <p class="ml-1 mb-0">30%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-0">Top Performer</h4>
          <div class="d-flex mt-3 py-2 border-bottom">
            <img class="img-sm rounded-circle" src="{{ asset('assets/images/faces/face3.jpg') }}" alt="profile image">
            <div class="wrapper ml-2">
              <p class="mb-n1 font-weight-semibold">Ray Douglas</p>
              <small>162543</small>
            </div>
            <small class="text-muted ml-auto">1 Hours ago</small>
          </div>
          <div class="d-flex py-2 border-bottom">
            <span class="img-sm rounded-circle bg-warning text-white text-avatar">OH</span>
            <div class="wrapper ml-2">
              <p class="mb-n1 font-weight-semibold">Ora Hill</p>
              <small>162543</small>
            </div>
            <small class="text-muted ml-auto">4 Hours ago</small>
          </div>
          <div class="d-flex py-2 border-bottom">
            <img class="img-sm rounded-circle" src="{{ asset('assets/images/faces/face4.jpg') }}" alt="profile image">
            <div class="wrapper ml-2">
              <p class="mb-n1 font-weight-semibold">Brian Dean</p>
              <small>162543</small>
            </div>
            <small class="text-muted ml-auto">4 Hours ago</small>
          </div>
          <div class="d-flex pt-2">
            <span class="img-sm rounded-circle bg-success text-white text-avatar">OB</span>
            <div class="wrapper ml-2">
              <p class="mb-n1 font-weight-semibold">Olive Bridges</p>
              <small>162543</small>
            </div>
            <small class="text-muted ml-auto">7 Hours ago</small>
          </div>
        </div>
      </div>
    </div>
  </div>