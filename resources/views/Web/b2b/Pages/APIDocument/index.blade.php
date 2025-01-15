<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Usage Package Endpoint</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding-top: 20px;
            padding-left: 20px;
            padding-right: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar h2 {
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            margin: 10px 0;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            display: block;
            padding: 5px 0;
        }
        .sidebar a:hover {
            color: #4CAF50;
        }
        /* Main content */
        .content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
        }
        h1, h2 {
            color: #4CAF50;
        }
        .endpoint {
            margin-bottom: 20px;
        }
        .code-block {
            background-color: #f4f4f4;
            border-left: 3px solid #4CAF50;
            padding: 10px;
            font-family: monospace;
            white-space: pre-wrap;
        }
        .response {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
        }
        .response h3 {
            color: #d9534f;
        }
        .section-header {
            font-size: 1.5rem;
            color: #127be4;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>API Docs</h2>
        <ul>
            <li><a href="#environments">Environments</a></li>
            <li><a href="#usage-package">Usage Package</a></li>
            <li><a href="#other-endpoints">Other Endpoints</a></li>
            <li><a href="#add-more">Add More APIs</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="content">
        <h1>API Documentation - Environments</h1>
        <br /><br />

        <div id="environments" class="section-card">
            <h2 class="section-header">Environments</h2>

                <h4"> <strong  style="color: #0da326"> Version : </strong> v1 </h4>
                <br /><br />

                <h4 style="color: #0da326"> <strong> Sandbox : </strong></h4>
                <div class="input-group">
                    <input value="https://sandbox-partners-api.airalo.com" type="hidden" class="form-control" id="Sandbox"  readonly>
                    <h3>https://sandbox-partners-api.airalo.com
                    <button class="btn btn-outline-secondary" onclick="copyToClipboard('Sandbox')">
                        <i class="bi bi-clipboard"></i>
                    </button>
                    </h3>
                </div>

                <br /><br />

                <h4 style="color: #0da326"> <strong> Production : </strong></h4>
                <div class="input-group">
                    <input value="https://partners-api.airalo.com" type="hidden" class="form-control" id="Production"  readonly>
                    <h3>https://partners-api.airalo.com
                    <button class="btn btn-outline-secondary" onclick="copyToClipboard('Production')">
                        <i class="bi bi-clipboard"></i>
                    </button>
                    </h3>
                </div>

        </div>
        <br /><br />


        <div class="endpoint" id="usage-package">
        <h2 class="section-header">Usage Package</h2>
            <h4 style="color: #0da326">Endpoint: POST /user/order/packages/usage</h4>
            <p>This endpoint is used to request and manage the usage of a package based on the provided ICCID.</p>

            <h3>Request Example:</h3>
            <div class="code-block">
                POST `{BASE_URL}`/`{Version}`/user/order/packages/usage
            </div>

            <h3>Request Headers:</h3>
            <div class="code-block">
                Accept: application/json<br>
                Content-Type: application/json<br>
                lang: `{Lang}`<br>
                Authorization: Bearer `{Token}`
            </div>

            <h3>Request Body:</h3>
            <div class="code-block">
                {
                    "iccid": "894000000000039200"
                }
            </div>
        </div>

        <h2>Responses</h2>

        <div class="response">
            <h3>1. ICCID is Required (Status Code: 422)</h3>
            <p><strong>Error Code:</strong> 4076</p>
            <p><strong>Message:</strong> ICCID_REQUIRED_CODE</p>
            <p><strong>Description:</strong> The request failed because the ICCID was missing or invalid.</p>
            <div class="code-block">
                {
                    "success": false,
                    "error": {
                        "message": "ICCID_REQUIRED_CODE",
                        "code": 4076
                    },
                    "validator": {
                        "iccid": [
                            "ICCID_REQUIRED_CODE"
                        ]
                    }
                }
            </div>
        </div>

        <div class="response">
            <h3>2. ICCID is Not Found (Status Code: 422)</h3>
            <p><strong>Error Code:</strong> 4075</p>
            <p><strong>Message:</strong> ICCID_EXISTS_CODE</p>
            <p><strong>Description:</strong> The ICCID provided does not exist in the system.</p>
            <div class="code-block">
                {
                    "success": false,
                    "error": {
                        "message": "ICCID_EXISTS_CODE",
                        "code": 4075
                    },
                    "validator": {
                        "iccid": [
                            "ICCID_EXISTS_CODE"
                        ]
                    }
                }
            </div>
        </div>

        <div class="response">
            <h3>3. Unauthorized (Status Code: 401)</h3>
            <p><strong>Error Code:</strong> 401</p>
            <p><strong>Message:</strong> Unauthorized</p>
            <p><strong>Description:</strong> The request is unauthorized due to missing or invalid authentication.</p>
            <div class="code-block">
                {
                    "success": false,
                    "error": {
                        "message": "Unauthorized",
                        "code": 401
                    }
                }
            </div>
        </div>

        <div class="response">
            <h3>4. Failed (Status Code: 200)</h3>
            <p><strong>Error Code:</strong> 1036</p>
            <p><strong>Message:</strong> USAGE_PACKAGE_FAILED_CODE</p>
            <p><strong>Description:</strong> The package usage request failed for some reason, but the details are not provided.</p>
            <div class="code-block">
                {
                    "success": true,
                    "message": "USAGE_PACKAGE_FAILED_CODE",
                    "code": 1036,
                    "data": ""
                }
            </div>
        </div>

        <div class="response">
            <h3>5. Success (Status Code: 200)</h3>
            <p><strong>Error Code:</strong> 1037</p>
            <p><strong>Message:</strong> Package used successfully.</p>
            <p><strong>Details:</strong></p>
            <ul>
                <li><strong>Remaining Capacity:</strong> 1024 MB (1 GB)</li>
                <li><strong>Total Capacity:</strong> 1024 MB (1 GB)</li>
                <li><strong>Status:</strong> ACTIVE</li>
                <li><strong>Expiration Date:</strong> 2025-01-09</li>
                <li><strong>Plan Type:</strong> Data</li>
                <li><strong>Validity:</strong> 7 Days</li>
                <li><strong>Subcategory Name:</strong> Curaçao</li>
                <li><strong>Networks:</strong> Digicel (CW)</li>
            </ul>
            <div class="code-block">
                {
                    "success": true,
                    "message": "Package used successfully.",
                    "code": 1037,
                    "data": {
                        "remaining": 1024,
                        "total": 1024,
                        "status": "ACTIVE",
                        "expired_at": "2025-01-09",
                        "getItem": {
                            "id": 141,
                            "capacity": "1 GB",
                            "plan_type": "data",
                            "validaty": "7 Days",
                            "sub_category_id": 55,
                            "sub_category_name": "Curaçao",
                            "coverages": [
                                {
                                    "networks": [
                                        {
                                            "name": "Digicel"
                                        }
                                    ],
                                    "country_code": "CW"
                                }
                            ],
                            "created_at": "2025-01-02",
                            "updated_at": "2025-01-02"
                        }
                    }
                }
            </div>
        </div>

        <div id="other-endpoints">
            <h2>Other API Endpoints</h2>
            <p>Details of other API endpoints can be added here.</p>
        </div>

        <div id="add-more">
            <h2>Add More API Documentation</h2>
            <p>To add more APIs, follow the pattern of the Usage Package endpoint.</p>
        </div>
    </div>

</body>
</html>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function copyToClipboard(id) {
        const copyText = document.getElementById(id);
        navigator.clipboard.writeText(copyText.value).then(() => {
            alert('Copied to clipboard!');
        });
    }
</script>
