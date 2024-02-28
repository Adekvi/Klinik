<div class="card-header">
  <div class="row">
    <div class="col-3">
        @yield('title')
    </div>
    <div class="col-9">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}" id="home-tab" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Landing</a>
            </li>
            <li class="nav-item" role="presentation">
              <a href="{{ url('/home') }}" class="nav-link {{ Request::is('/home') ? 'active' : '' }}" id="home-tab" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Pasien</a>
            </li>
            <li class="nav-item" role="presentation">
              <a href="{{ url('perawat/index') }}" class="nav-link {{ Request::is('perawat/index') ? 'active' : '' }}" id="profile-tab" type="button" role="tab" aria-controls="perawat-tab-pane" aria-selected="true">Perawat</a>
            </li>
            <li class="nav-item" role="presentation">
              <a href="{{ url('dokter/index') }}" class="nav-link {{ Request::is('dokter/index') ? 'active' : '' }}" id="contact-tab"  type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Dokter</a>
            </li>
        </ul>
    </div>
  </div>
</div>

