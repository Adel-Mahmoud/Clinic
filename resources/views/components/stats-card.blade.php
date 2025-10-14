<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
    <div class="card overflow-hidden sales-card {{ $bg }}">
        <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
            <div>
                <h6 class="mb-3 tx-12 text-white">{{ $title }}</h6>
            </div>
            <div class="pb-0 mt-0">
                <div class="d-flex">
                    <div>
                        <h4 class="tx-20 font-weight-bold mb-1 text-white">
                            {{ $value }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart-wrapper">
            <span id="{{ $chartId }}" class="pt-1">
                {{ is_array($value) ? implode(',', $value) : $value }}
            </span>
        </div>
    </div>
</div>