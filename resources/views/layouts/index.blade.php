<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sarpras')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .content{
        margin-top: 13%;
      }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px 0;
            display: none;
        }
        .footer .btn {
            width: 100%;
            margin: 1%;
        }
        .plus {
            position: fixed;
            bottom: 60px;
            width: 100%;
            padding: 10px 0;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            margin: 10px;
            border-radius: 1000px;
        }
        .plus .bullet {
            font-size: 48px;
            margin: 0 20px 0 0;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 0 10px 0;
        }	

        @media (max-width: 992px) {
            .footer{
              display: block;
            }
            .plus{
              display: flex;
              justify-content: flex-end;
              align-items: flex-end;
              margin: 10px;
              border-radius: 1000px;
            }
        }
    </style>
  </head>

  <body>
    @include('layouts/navbar')

    @yield('content')
    

    @include('layouts/footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  </body>
</html>
