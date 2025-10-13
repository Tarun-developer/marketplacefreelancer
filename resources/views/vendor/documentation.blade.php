@extends('layouts.vendor')

@section('title', 'License Integration Documentation')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">License Integration Documentation</h4>
                    <p class="card-title-desc">How to integrate license validation into your products</p>
                </div>
                <div class="card-body">
                    <!-- Introduction -->
                    <div class="alert alert-info">
                        <h5><i class="bi bi-info-circle"></i> Smart Licensing System</h5>
                        <p>Every product you sell comes with a secure, trackable license key. Our smart license engine ensures your buyers get authentic, protected access with instant activation, renewal, and domain-based validation.</p>
                    </div>

                    <!-- License Types -->
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📋 License Types</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Standard License</h6>
                                    <p>Use for single personal/commercial project.</p>
                                    <ul>
                                        <li>1 domain activation</li>
                                        <li>Basic support</li>
                                        <li>Updates included</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Professional License</h6>
                                    <p>Extended use or multiple installs (non-resale).</p>
                                    <ul>
                                        <li>3 domain activations</li>
                                        <li>Priority support</li>
                                        <li>Extended features</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Ultimate License</h6>
                                    <p>Unlimited or SaaS use.</p>
                                    <ul>
                                        <li>Unlimited activations</li>
                                        <li>Premium support</li>
                                        <li>Can integrate into SaaS apps</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Custom License</h6>
                                    <p>Defined by author (optional).</p>
                                    <ul>
                                        <li>Custom terms</li>
                                        <li>White-label options</li>
                                        <li>Exclusive rights</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- API Integration -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">🔗 API Integration</h5>
                        </div>
                        <div class="card-body">
                            <h6>License Validation Endpoint</h6>
                            <p>Validate licenses using our REST API:</p>

                            <div class="bg-light p-3 rounded mb-3">
                                <code>POST https://{{ request()->getHost() }}/api/validate-license</code>
                            </div>

                            <h6>Request Parameters</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>license_key</td>
                                            <td>string</td>
                                            <td>Yes</td>
                                            <td>The license key (e.g., LIC-1A2B-FE12AB34CD56EF78)</td>
                                        </tr>
                                        <tr>
                                            <td>domain</td>
                                            <td>string</td>
                                            <td>No</td>
                                            <td>Domain where product is installed</td>
                                        </tr>
                                        <tr>
                                            <td>ip</td>
                                            <td>string</td>
                                            <td>No</td>
                                            <td>IP address of the installation</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6>Example Request (PHP/cURL)</h6>
                            <div class="bg-dark text-light p-3 rounded mb-3">
                                <pre><code>$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://{{ request()->getHost() }}/api/validate-license');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'license_key' => 'LIC-XXXX-XXXXXXXXXXXX',
    'domain' => 'example.com',
    'ip' => $_SERVER['REMOTE_ADDR']
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$result = json_decode($response, true);</code></pre>
                            </div>

                            <h6>Response Format</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Success Response</h6>
                                    <div class="bg-success text-light p-3 rounded">
                                        <pre><code>{
    "status": "valid",
    "license_type": "professional",
    "expires_at": "2026-10-13T00:00:00Z",
    "message": "License activated successfully."
}</code></pre>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Error Response</h6>
                                    <div class="bg-danger text-light p-3 rounded">
                                        <pre><code>{
    "status": "invalid",
    "message": "Invalid license key."
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Implementation Examples -->
                    <div class="card border-warning mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">💻 Implementation Examples</h5>
                        </div>
                        <div class="card-body">
                            <h6>PHP Implementation</h6>
                            <div class="bg-dark text-light p-3 rounded mb-3">
                                <pre><code>function validateLicense($licenseKey, $domain) {
    $response = file_get_contents('https://{{ request()->getHost() }}/api/validate-license', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode([
                'license_key' => $licenseKey,
                'domain' => $domain,
                'ip' => $_SERVER['REMOTE_ADDR']
            ])
        ]
    ]));

    $result = json_decode($response, true);

    if ($result['status'] === 'valid') {
        // License is valid, allow access
        return true;
    } else {
        // License invalid, show error
        echo $result['message'];
        return false;
    }
}</code></pre>
                            </div>

                            <h6>WordPress Plugin Example</h6>
                            <div class="bg-dark text-light p-3 rounded mb-3">
                                <pre><code>class MyPlugin_License {
    public function validate() {
        $license_key = get_option('myplugin_license_key');
        $domain = $_SERVER['HTTP_HOST'];

        $response = wp_remote_post('https://{{ request()->getHost() }}/api/validate-license', [
            'body' => json_encode([
                'license_key' => $license_key,
                'domain' => $domain,
                'ip' => $_SERVER['REMOTE_ADDR']
            ]),
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $result = json_decode(wp_remote_retrieve_body($response), true);

        if ($result['status'] === 'valid') {
            update_option('myplugin_license_valid', true);
            return true;
        } else {
            update_option('myplugin_license_valid', false);
            return false;
        }
    }
}</code></pre>
                            </div>

                            <h6>JavaScript Example</h6>
                            <div class="bg-dark text-light p-3 rounded">
                                <pre><code>async function validateLicense(licenseKey, domain) {
    try {
        const response = await fetch('https://{{ request()->getHost() }}/api/validate-license', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                license_key: licenseKey,
                domain: domain,
                ip: await getClientIP()
            })
        });

        const result = await response.json();

        if (result.status === 'valid') {
            // License valid
            return { valid: true, data: result };
        } else {
            // License invalid
            return { valid: false, message: result.message };
        }
    } catch (error) {
        return { valid: false, message: 'Network error' };
    }
}</code></pre>
                            </div>
                        </div>
                    </div>

                    <!-- Best Practices -->
                    <div class="card border-info mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">✅ Best Practices</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Security</h6>
                                    <ul>
                                        <li>Validate licenses on server-side only</li>
                                        <li>Cache validation results (don't check every page load)</li>
                                        <li>Use HTTPS for all API calls</li>
                                        <li>Store license keys securely (encrypted)</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>User Experience</h6>
                                    <ul>
                                        <li>Show clear error messages</li>
                                        <li>Provide license management interface</li>
                                        <li>Allow easy reactivation</li>
                                        <li>Include renewal reminders</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="card border-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">🛠️ Support & Troubleshooting</h5>
                        </div>
                        <div class="card-body">
                            <h6>Common Issues</h6>
                            <div class="accordion" id="troubleshootingAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                            License Key Not Working
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body">
                                            <p>Check that:</p>
                                            <ul>
                                                <li>License key is entered correctly (case-sensitive)</li>
                                                <li>License is active and not expired</li>
                                                <li>Activation limit hasn't been reached</li>
                                                <li>Domain matches the registered domain</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                            API Connection Issues
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#troubleshootingAccordion">
                                        <div class="accordion-body">
                                            <p>Ensure:</p>
                                            <ul>
                                                <li>Correct API endpoint URL</li>
                                                <li>Valid JSON format in requests</li>
                                                <li>HTTPS is used (HTTP may be blocked)</li>
                                                <li>Firewall allows outbound connections</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p><strong>Need Help?</strong> Contact our support team or check the <a href="#" class="text-decoration-none">API Documentation</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection