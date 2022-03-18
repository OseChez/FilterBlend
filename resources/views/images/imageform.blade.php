
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="img/favicon.png" type="image/png">
        <title>Learn IT Education</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/linericon/style.css') }}">
  
         <!-- Scripts -->
         <script src="{{ asset('js/app.js') }}" defer></script>
       
        <!-- main css -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/all.css')}}">
    </head>
    <body>
        <h1>Laravel and JCrop</h1>
        {!! Form::open(['files' => true]) !!}
        {!! Form::label('image','Mi Imagen') !!}
        <br>
        {!! Form::file('image') !!}
        <br>
        {!! Form::submit('Upload') !!}
        {!! Form::close() !!}
       
    </body>
</html>