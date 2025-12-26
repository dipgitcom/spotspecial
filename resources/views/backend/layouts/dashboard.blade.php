@extends('backend.master')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e9f7 100%); min-height:100vh;">
  <div class="row mb-4">
    <div class="col-lg-12">
      <div class="d-flex align-items-center justify-content-between rounded-3 p-4 mb-3 card-custom" style="box-shadow: 0 4px 24px rgba(36,46,63,0.09); background: #fff;">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-circle bg-indigo text-white shadow-sm">
            <i class="bi bi-rocket" style="font-size: 1.5rem;"></i>
          </div>
          <div>
            <h2 class="mb-0 fw-bold text-primary">Welcome, <span class="text-dark">{{ Auth::user()->name }}</span></h2>
            <div class="text-muted">Your professional admin dashboard overview</div>
          </div>
        </div>
        <div>
          <div id="digitalClock" class="digitalClock"></div>
        </div>
      </div>
    </div>
  </div>
  {{-- <!-- Analytic Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm card-custom border-0">
        <div class="card-body d-flex flex-column align-items-center text-center">
          <i class="bi bi-bar-chart-line text-info mb-4" style="font-size:2rem;"></i>
          <h4 class="fw-bold">Løsninger & priser</h4>
          <div class="row w-100 g-2 mt-2">
            <div class="col-6">
              <div class="border rounded p-2 bg-light">
                <div class="fs-2 fw-bold text-info">124</div>
                <small class="text-muted">Today</small>
              </div>
            </div>
            <div class="col-6">
              <div class="border rounded p-2 bg-light">
                <div class="fs-2 fw-bold text-secondary">984</div>
                <small class="text-muted">Previous</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Repeat for more cards ... -->
    <div class="col-md-4">
      <div class="card h-100 shadow-sm card-custom border-0">
        <div class="card-body d-flex flex-column align-items-center text-center">
          <i class="bi bi-person-badge text-success mb-4" style="font-size:2rem;"></i>
          <h4 class="fw-bold">Kontakt</h4>
          <div class="fs-2 fw-bold text-success">689</div>
          <small class="text-muted">Registered</small>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm card-custom border-0">
        <div class="card-body d-flex flex-column align-items-center text-center">
          <i class="bi bi-cash-coin text-warning mb-4" style="font-size:2rem;"></i>
          <h4 class="fw-bold">Diskret, varm belysning med høj CRi</h4>
          <div class="fs-2 fw-bold text-warning">৳ 1,02,400</div>
          <small class="text-muted">This Month</small>
        </div>
      </div>
    </div>
  </div> --}}
 
</div>
@endsection

@push('scripts')
<script>
  function updateClock() {
    var clock = document.getElementById('digitalClock');
    if (!clock) return;
    var now = new Date();
    var h = String(now.getHours()).padStart(2, '0');
    var m = String(now.getMinutes()).padStart(2, '0');
    var s = String(now.getSeconds()).padStart(2, '0');
    clock.textContent = `${h}:${m}:${s}`;
  }
  setInterval(updateClock, 1000);
  updateClock();
</script>
@endpush

@push('styles')
<style>
.card-custom {
  background: #fff;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 8px rgb(0 0 0 / 0.05);
  border-radius: 18px;
  transition: box-shadow 0.3s;
}
.card-custom:hover {
  box-shadow: 0 8px 20px rgb(0 0 0 / 0.12);
}
.icon-circle {
  width: 56px;
  height: 56px;
  background: #e0e7ff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: inset 0 0 6px #c7d2fe;
}
.digitalClock {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-weight: 700;
  font-size: 1.5rem;
  color: #2563eb;
  user-select: none;
  min-width: 100px;
  text-align: center;
}
.bg-success-soft {
  background: #def7ec !important;
}
</style>
@endpush
