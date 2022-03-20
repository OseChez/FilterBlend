
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="img/favicon.png" type="image/png">
        <title>Learn IT Education</title>
           <!-- Scripts -->
        <script src=" {{ asset('js/scripts/jquery.min.js') }}"></script>
        <script src="{{ asset('js/scripts/jquery-ui.min.js') }}" defer></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/linericon/style.css') }}">
  
        
        <!-- main css -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/all.css')}}">
    </head>
    <body>
        
    <!--================ Blog Area =================-->
      <section class="blog_area">
          <div id="app" class="container">
            <div class="row">
              <app-component></app-component>
            </div>
        </div>
      </section>
   
   
       
    </body>
</html>
