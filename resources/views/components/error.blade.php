@if (session('success'))
    <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
        <div class="d-flex align-items-center gap-2">
            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
            {{ session('success') }}
        </div>
        <button class="remove-button text-success-600 text-xxl line-height-1">
            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-warning bg-warning-100 text-warning-600 border-warning-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
        <div class="d-flex align-items-center gap-2">
            <iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon>
            {{ session('error') }}
        </div>
        <button class="remove-button text-warning-600 text-xxl line-height-1">
            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
        </button>
    </div>
@endif

@if (session('danger'))
    <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
        <div class="d-flex align-items-center gap-2">
            <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl"></iconify-icon>
            {{ session('danger') }}
        </div>
        <button class="remove-button text-danger-600 text-xxl line-height-1">
            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
        </button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info bg-info-100 text-info-600 border-info-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between" role="alert">
        <div class="d-flex align-items-center gap-2">
            <iconify-icon icon="ci:link" class="icon text-xl"></iconify-icon>
            {{ session('info') }}
        </div>
        <button class="remove-button text-info-600 text-xxl line-height-1">
            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
        </button>
    </div>
@endif
