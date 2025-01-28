<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="HTML5 Template" />
<meta name="description" content="Webmin - Bootstrap 4 & Angular 5 Admin Dashboard Template" />
<meta name="author" content="potenzaglobalsolutions.com" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ URL::asset('Web/Dashboard/assets/images/favicon.ico') }}" type="image/x-icon" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
{{--  <link href="{{ URL::asset('Web/Dashboard/assets/css/style.css') }}" rel="stylesheet">  --}}
<link href="{{ URL::asset('Web/Dashboard/assets/css/ltr.css') }}" rel="stylesheet">

{{--  Adding Styles  --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    a:hover {
        color: blue;
      }

    label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

    input,
    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input.is-invalid {
        border-color: red;
    }

    .error-message {
        color: red;
        font-size: 0.9rem;
        margin-top: -10px;
        margin-bottom: 15px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
    .AddButtonC{
        margin-left: 2%;
        width:10%;
    }
    .tableC {
        text-align: center;
    }
    .EnableC {
        color: green;
    }

    .DisableC {
        color: red;
    }
    .dropdownMenuC {
        background-color: #acadaf;
    }

    .formC {
        margin-bottom: -10px;
    }

    .modalTitleC {
        font-family: 'Cairo', sans-serif;
    }
    .closeButtonC {
        border: 1px solid #fdfcfc;
        border-radius: 5px;
        color: white !important;
    }
    .submitButtonC {
        color: white;width: auto;
        margin-bottom: 0;
    }

    .modelFooterC {
        padding-bottom: 0;
    }

    .price-container {
        font-family: Arial, sans-serif;
        display: inline-flex;
        align-items: baseline;
        gap: 4px;
        font-size: 24px;
        color: #333;
    }

    .currency-symbol {
        font-size: 16px;
        color: #666;
    }

    .price-amount {
        font-size: 16px;
        font-weight: bold;
        color: #1f16a5;
    }
</style>
