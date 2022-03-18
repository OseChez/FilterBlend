
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
       
         <script src="{{ asset('js/scripts/jquery.Jcrop.min.js') }}" defer></script>
       
        <!-- main css -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/all.css')}}">
    </head>
    <body>
     
        <h2>Image Cropping con Laravel y Jcrop</h2>
        <img src="<?php echo $image?>" id="cropimage"/>
        {!! Form::open() !!}
            {!! Form::hidden('image',$image) !!}
            {!! Form::hidden('x','',['id'=> 'x']) !!}
            {!! Form::hidden('y','',['id'=> 'y']) !!}
            {!! Form::hidden('w','',['id'=> 'w']) !!}
            {!! Form::hidden('h','',['id'=> 'h']) !!}
        <br>
        {!! Form::submit('Crop it') !!}
        {!! Form::close() !!}
    
       
    </body>
</html>