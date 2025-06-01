@extends('layouts.app')

@section('content')
<!-- Main Content -->
<main class="container py-4">

  <!-- Top Action Bar -->
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-success" id="submitOrderBtn" onclick="openSubmitModal()">Submit Order</button>
      <!-- <span class="fw-bold">Add Order +</span> -->
    </div>
    <div class="d-flex align-items-center gap-4 me-4">
      <label class="fw-bold mb-0">Table:</label>
      <input type="text" class="form-control form-control" style="width: 8rem;">
      <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#cartModal">Cart <i class="bi bi-cart"></i></button>      
    </div>
  </div>
  
    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-4 rounded-4">
            <div class="modal-header d-flex justify-content-between align-items-start border-0">
                <h4 class="modal-title fw-bold">Cart</h4>
                <button type="button" class="btn btn-danger rounded-3 px-3 py-1 fw-bold" data-bs-dismiss="modal">X</button>
            </div>
            <div class="modal-body">
                <div id="cartList"></div>
                <!-- Possible Cart Items here -->
                @foreach ($baskets as $index => $rock)
                    <div class="col">
                    <div class="card text-center shadow-sm" style="width: 18rem;">
                        <!-- <img src="" class="img-box bg-light d-flex justify-content-center align-rocks-center rounded-image-menu" style="height: 200px;" alt="{{ $rock->name }}"> -->
                        <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="fw-bold">{{ $rock->name }}</h6>
                            <p class="text-muted mb-2">Rp.{{ number_format($rock->price, 0, ',', '.') }},00</p>
                        </div>
                        
                        </div>
                    </div>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between align-items-center fw-bold">
                <span>Subtotal</span>
                <span id="subtotal">Rp. 0</span>
                </div>
            </div>
            </div>
        </div>
    </div>
    <hr>

  <!-- Menu Cards -->
  @foreach ($groupedItems as $category => $items)
    <h2 class="fw-bold mb-3">{{ $category }}</h2>
    <div class="row row-cols-md-4 g-3  mb-5">
        @foreach ($items as $index => $item)
        <div class="col">
          <div class="card text-center shadow-sm" style="width: 18rem;">
            <img src="{{ $item->img_url }}" class="img-box bg-light d-flex justify-content-center align-items-center rounded-image-menu" style="height: 200px;" alt="{{ $item->name }}">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h6 class="fw-bold">{{ $item->name }}</h6>
                <p class="text-muted mb-2">Rp.{{ number_format($item->price, 0, ',', '.') }},00</p>
              </div>
              
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <hr>
  @endforeach

</main>

<!-- Submit Confirmation Modal -->
<div class="modal fade" id="submitOrderModal" tabindex="-1" aria-labelledby="submitOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 p-4">
      <h4 class="fw-bold mb-4">Cart</h4>

      <div class="mb-4" id="cart-summary-preview">
        
      </div>

      <hr class="my-3">

      <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
        <span>Subtotal</span>
        <span id="finalSubtotal">Rp. 0,00</span>
      </div>

      <div class="d-flex justify-content-end gap-3">
        <button class="btn btn-danger px-4 py-2 rounded-pill fw-bold" data-bs-dismiss="modal">Batal</button>
        <button id="confirmSubmitOrder" class="btn btn-primary px-4 py-2 rounded-pill fw-bold" onclick="submitFinalOrder()">Continue</button>
      </div>
    </div>
  </div>
</div>


<!-- Drink Detail Modal -->
<div class="modal fade" id="drinkDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="drinkDetailForm" class="modal-content p-4 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="drinkDetailTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label class="fw-bold">Choose Variant</label>
        <select class="form-select mb-4" name="variant">
          <option value="Cold">Cold</option>
          <option value="Hot">Hot</option>
        </select>

        <label class="fw-bold">Size</label>
        <div class="row row-cols-2 g-3 mb-2">
          <div class="form-check ms-3">
            <input class="form-check-input border-dark" type="radio" name="size" value="Small" id="size-Small">
            <label class="form-check-label" for="size-Small">Small</label>
          </div>
          <div class="form-check ms-3">
            <input class="form-check-input border-dark" type="radio" name="size" value="Reguler" id="size-reguler" checked>
            <label class="form-check-label" for="size-reguler">Regular</label>
          </div>
          <div class="form-check ms-3">
            <input class="form-check-input border-dark" type="radio" name="size" value="Large" id="size-large">
            <label class="form-check-label" for="size-large">Large</label>
          </div>
        </div>

        <div id="ice-options">
            <label class="fw-bold">Ice</label>
            <div class="row row-cols-2 g-3 mb-2">
                <div class="form-check ms-3">
                    <input class="form-check-input border-dark" type="radio" name="ice" value="Less Ice" id="ice-less">
                    <label class="form-check-label" for="ice-less">Less Ice</label>
                </div>
                <div class="form-check ms-3">
                    <input class="form-check-input border-dark" type="radio" name="ice" value="Normal Ice" id="ice-normal" checked>
                    <label class="form-check-label" for="ice-normal">Normal Ice</label>
                </div>
            </div>
        </div>

        <label class="fw-bold">Sweetness</label>
        <div class="row row-cols-2 g-3">
          <div class="form-check ms-3">
            <input class="form-check-input border-dark" type="radio" name="sugar" value="No Sugar" id="sugar-no">
            <label class="form-check-label" for="sugar-no">No Sugar</label>
          </div>
          <div class="form-check ms-3">
            <input class="form-check-input border-dark" type="radio" name="sugar" value="Less Sugar" id="sugar-less">
            <label class="form-check-label" for="sugar-less">Less Sugar</label>
          </div>
          <div class="form-check ms-3">
            <input class="form-check-input border-dark" type="radio" name="sugar" value="Normal Sugar" id="sugar-normal" checked>
            <label class="form-check-label" for="sugar-normal">Normal Sugar</label>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 justify-content-end">
        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold d-flex align-items-center gap-2">
          SUBMIT <i class="bi bi-send"></i>
        </button>
      </div>
    </form>
  </div>
</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
  <div id="toastSuccess" class="toast align-items-center text-bg-dark border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toast-message">Berhasil</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<!-- Modal Payment Method -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentMethodModalLabel">Payment Method</h5>
      </div>
      <div class="modal-body">
        <button class="btn btn-block btn-payment btn-tunai w-100 mb-3" onclick="selectPayment('cash')">
          <i class="bi bi-cash-stack me-2"></i> Tunai
        </button>
        <button class="btn btn-block btn-payment btn-qris w-100" onclick="selectPayment('qris')">
          <i class="bi bi-qr-code-scan me-2"></i> Qris
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cashPaymentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran Tunai</h5>
      </div>
      <div class="modal-body">
      <form id="cashPaymentForm">
        <div class="mb-3">
            <h5>Total yang harus dibayar: <span id="cashTotalDisplay" class="fw-bold text-primary">Rp0</span></h5>
        </div>
        <div class="mb-3">
            <label for="cashAmount" class="form-label">Masukkan jumlah uang:</label>
            <input type="number" class="form-control" id="cashAmount" placeholder="0" required>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-success">Cetak Struk</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="qrisPaymentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran Qris</h5>
      </div>
      <div class="modal-body text-center">
        <img src="/images/dummy-qr.png" alt="QRIS" class="img-fluid mb-3" width="200">
        <p>Total yang harus dibayar:</p>
        <h4 class="fw-bold text-primary" id="qrisTotalDisplay">Rp 0</h4>
        <button class="btn btn-dark w-100 mt-3" onclick="handleQrisSubmit()">Submit & Cetak Struk</button>
      </div>
    </div>
  </div>
</div>
@endsection
