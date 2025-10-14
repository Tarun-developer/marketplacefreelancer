<div class="row">
    <!-- Left Column -->
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gateway Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $paymentGateway->name ?? '') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $paymentGateway->slug ?? '') }}" required>
                        <small class="text-muted">Unique identifier (e.g., stripe, paypal)</small>
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="fiat" {{ old('type', $paymentGateway->type ?? '') == 'fiat' ? 'selected' : '' }}>Fiat Currency</option>
                            <option value="crypto" {{ old('type', $paymentGateway->type ?? '') == 'crypto' ? 'selected' : '' }}>Cryptocurrency</option>
                            <option value="wallet" {{ old('type', $paymentGateway->type ?? '') == 'wallet' ? 'selected' : '' }}>Internal Wallet</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo URL</label>
                        <input type="text" name="logo" class="form-control @error('logo') is-invalid @enderror"
                               value="{{ old('logo', $paymentGateway->logo ?? '') }}" placeholder="gateway-logo.png">
                        @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="3">{{ old('description', $paymentGateway->description ?? '') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Fee Configuration -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Fee Configuration</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Percentage Fee (%)</label>
                        <input type="number" name="transaction_fee_percentage" step="0.01" min="0" max="100"
                               class="form-control @error('transaction_fee_percentage') is-invalid @enderror"
                               value="{{ old('transaction_fee_percentage', $paymentGateway->transaction_fee_percentage ?? 0) }}">
                        @error('transaction_fee_percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fixed Fee</label>
                        <input type="number" name="transaction_fee_fixed" step="0.01" min="0"
                               class="form-control @error('transaction_fee_fixed') is-invalid @enderror"
                               value="{{ old('transaction_fee_fixed', $paymentGateway->transaction_fee_fixed ?? 0) }}">
                        @error('transaction_fee_fixed')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fee Currency</label>
                        <input type="text" name="transaction_fee_currency" maxlength="3"
                               class="form-control @error('transaction_fee_currency') is-invalid @enderror"
                               value="{{ old('transaction_fee_currency', $paymentGateway->transaction_fee_currency ?? 'USD') }}" placeholder="USD">
                        @error('transaction_fee_currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Minimum Amount</label>
                        <input type="number" name="min_amount" step="0.01" min="0"
                               class="form-control @error('min_amount') is-invalid @enderror"
                               value="{{ old('min_amount', $paymentGateway->min_amount ?? '') }}" placeholder="0.50">
                        @error('min_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Maximum Amount</label>
                        <input type="number" name="max_amount" step="0.01" min="0"
                               class="form-control @error('max_amount') is-invalid @enderror"
                               value="{{ old('max_amount', $paymentGateway->max_amount ?? '') }}" placeholder="10000.00">
                        @error('max_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Gateway Configuration -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Gateway Configuration</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Webhook URL</label>
                    <input type="url" name="webhook_url" class="form-control @error('webhook_url') is-invalid @enderror"
                           value="{{ old('webhook_url', $paymentGateway->webhook_url ?? '') }}" placeholder="/webhooks/gateway-slug">
                    @error('webhook_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Webhook Secret</label>
                    <input type="text" name="webhook_secret" class="form-control @error('webhook_secret') is-invalid @enderror"
                           value="{{ old('webhook_secret', $paymentGateway->webhook_secret ?? '') }}">
                    <small class="text-muted">Secret key for webhook signature verification</small>
                    @error('webhook_secret')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Processing Time (minutes)</label>
                    <input type="number" name="processing_time_minutes" min="0"
                           class="form-control @error('processing_time_minutes') is-invalid @enderror"
                           value="{{ old('processing_time_minutes', $paymentGateway->processing_time_minutes ?? 1) }}">
                    @error('processing_time_minutes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- API Configuration -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">API Credentials</h5>
                <small class="text-muted">Encrypted storage</small>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="live-tab" data-bs-toggle="tab" data-bs-target="#live" type="button" role="tab">
                            <i class="fas fa-bolt me-1"></i>Live Credentials
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sandbox-tab" data-bs-toggle="tab" data-bs-target="#sandbox" type="button" role="tab">
                            <i class="fas fa-flask me-1"></i>Sandbox/Test
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Live Credentials -->
                    <div class="tab-pane fade show active" id="live" role="tabpanel">
                        <div id="live-config-fields">
                            @php
                            $liveConfig = old('config', $paymentGateway->config ?? []);
                            @endphp
                            @if(is_array($liveConfig) && count($liveConfig) > 0)
                                @foreach($liveConfig as $key => $value)
                                <div class="mb-3 config-field">
                                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                    <div class="input-group">
                                        <input type="text" name="config[{{ $key }}]" class="form-control" value="{{ $value }}">
                                        <button type="button" class="btn btn-outline-danger remove-config-field"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="mb-3 config-field">
                                    <label class="form-label">API Key</label>
                                    <div class="input-group">
                                        <input type="text" name="config[api_key]" class="form-control" placeholder="Enter API key">
                                        <button type="button" class="btn btn-outline-danger remove-config-field"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-config-field" data-target="live">
                            <i class="fas fa-plus me-1"></i>Add Field
                        </button>
                    </div>

                    <!-- Sandbox Credentials -->
                    <div class="tab-pane fade" id="sandbox" role="tabpanel">
                        <div id="sandbox-config-fields">
                            @php
                            $sandboxConfig = old('sandbox_config', $paymentGateway->sandbox_config ?? []);
                            @endphp
                            @if(is_array($sandboxConfig) && count($sandboxConfig) > 0)
                                @foreach($sandboxConfig as $key => $value)
                                <div class="mb-3 config-field">
                                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                    <div class="input-group">
                                        <input type="text" name="sandbox_config[{{ $key }}]" class="form-control" value="{{ $value }}">
                                        <button type="button" class="btn btn-outline-danger remove-config-field"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="mb-3 config-field">
                                    <label class="form-label">Test API Key</label>
                                    <div class="input-group">
                                        <input type="text" name="sandbox_config[test_api_key]" class="form-control" placeholder="Enter test API key">
                                        <button type="button" class="btn btn-outline-danger remove-config-field"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-config-field" data-target="sandbox">
                            <i class="fas fa-plus me-1"></i>Add Field
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Instructions & Notes</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">User Instructions</label>
                    <textarea name="user_instructions" class="form-control @error('user_instructions') is-invalid @enderror"
                              rows="3" placeholder="Instructions shown to users during checkout">{{ old('user_instructions', $paymentGateway->user_instructions ?? '') }}</textarea>
                    @error('user_instructions')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Admin Notes</label>
                    <textarea name="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror"
                              rows="3" placeholder="Private notes for admins only">{{ old('admin_notes', $paymentGateway->admin_notes ?? '') }}</textarea>
                    @error('admin_notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Status & Settings -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Status & Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                               value="1" {{ old('is_active', $paymentGateway->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            <strong>Active</strong>
                            <small class="d-block text-muted">Make this gateway available for transactions</small>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="test_mode" id="test_mode"
                               value="1" {{ old('test_mode', $paymentGateway->test_mode ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="test_mode">
                            <strong>Test Mode</strong>
                            <small class="d-block text-muted">Use sandbox credentials for testing</small>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                           value="{{ old('sort_order', $paymentGateway->sort_order ?? 0) }}" min="0">
                    <small class="text-muted">Display order (lower numbers appear first)</small>
                    @error('sort_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Supported Currencies -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Supported Currencies</h5>
            </div>
            <div class="card-body">
                <div id="currencies-container">
                    @php
                    $currencies = old('supported_currencies', $paymentGateway->supported_currencies ?? ['USD']);
                    @endphp
                    @foreach($currencies as $currency)
                    <div class="input-group mb-2 currency-field">
                        <input type="text" name="supported_currencies[]" class="form-control" value="{{ $currency }}" placeholder="USD">
                        <button type="button" class="btn btn-outline-danger remove-currency"><i class="fas fa-times"></i></button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-currency">
                    <i class="fas fa-plus me-1"></i>Add Currency
                </button>
            </div>
        </div>

        <!-- Supported Countries -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Supported Countries</h5>
            </div>
            <div class="card-body">
                <div id="countries-container">
                    @php
                    $countries = old('supported_countries', $paymentGateway->supported_countries ?? []);
                    @endphp
                    @foreach($countries as $country)
                    <div class="input-group mb-2 country-field">
                        <input type="text" name="supported_countries[]" class="form-control" value="{{ $country }}" placeholder="US">
                        <button type="button" class="btn btn-outline-danger remove-country"><i class="fas fa-times"></i></button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-country">
                    <i class="fas fa-plus me-1"></i>Add Country
                </button>
                <small class="text-muted d-block mt-2">Leave empty to support all countries</small>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-save me-2"></i>{{ isset($paymentGateway) ? 'Update Gateway' : 'Create Gateway' }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Currency
    document.getElementById('add-currency').addEventListener('click', function() {
        const container = document.getElementById('currencies-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 currency-field';
        div.innerHTML = `
            <input type="text" name="supported_currencies[]" class="form-control" placeholder="EUR">
            <button type="button" class="btn btn-outline-danger remove-currency"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(div);
    });

    // Remove Currency
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-currency')) {
            e.target.closest('.currency-field').remove();
        }
    });

    // Add Country
    document.getElementById('add-country').addEventListener('click', function() {
        const container = document.getElementById('countries-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 country-field';
        div.innerHTML = `
            <input type="text" name="supported_countries[]" class="form-control" placeholder="GB">
            <button type="button" class="btn btn-outline-danger remove-country"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(div);
    });

    // Remove Country
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-country')) {
            e.target.closest('.country-field').remove();
        }
    });

    // Add Config Field
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-config-field')) {
            const target = e.target.closest('.add-config-field').dataset.target;
            const container = document.getElementById(`${target}-config-fields`);
            const fieldName = prompt('Enter field name (e.g., api_secret):');

            if (fieldName) {
                const div = document.createElement('div');
                div.className = 'mb-3 config-field';
                div.innerHTML = `
                    <label class="form-label">${fieldName.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</label>
                    <div class="input-group">
                        <input type="text" name="${target === 'live' ? 'config' : 'sandbox_config'}[${fieldName}]" class="form-control" placeholder="Enter ${fieldName}">
                        <button type="button" class="btn btn-outline-danger remove-config-field"><i class="fas fa-times"></i></button>
                    </div>
                `;
                container.appendChild(div);
            }
        }
    });

    // Remove Config Field
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-config-field')) {
            e.target.closest('.config-field').remove();
        }
    });
});
</script>
@endpush
