<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'B2B Dashboard')</title>
    <link rel="shortcut icon" href="{{ URL::asset('Web/assets/images/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">
    <link href="{{ URL::asset('Web/Auth/css/styles.css') }}" rel="stylesheet">
</head>

<body>

<div id="container" class="container">
    @yield('content')
</div>

@yield('js')

<script type="text/javascript">
    let container = document.getElementById('container')

    setTimeout(() => {
        container.classList.add('sign-in')
    }, 200)
</script>

<script type="text/javascript">
    const inputs = document.querySelectorAll('.pin-input');

    inputs.forEach((input, index) => {
      input.addEventListener('input', (event) => {
        if (event.inputType === 'deleteContentBackward' && index > 0) {
          inputs[index - 1].focus();
        } else if (index < inputs.length - 1 && event.inputType !== 'deleteContentBackward') {
          inputs[index + 1].focus();
        }
      });
    });
</script>


</body>
</html>
