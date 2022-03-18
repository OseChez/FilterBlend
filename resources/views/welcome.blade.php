
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
              <div class="col-lg-8">
                  <h2>Laravel AutoComplete</h2>
                  {!! Form::open() !!}
                  {!! Form::label('auto', 'Encontrar un Producto: ') !!}
                  {!! Form::text('auto', '',['id'=>'auto']) !!}
                  </br>
                  {!! Form::label('response', 'Su clave de producto es : ') !!}
                  {!! Form::text('response', '',['id'=>'response','disabled' => 'disabled']) !!}
                  {!! Form::close() !!}
              </div>
            </div>
        </div>
      </section>
   
      <!--================  Area script Jquery =================-->
      <script>
        $(function(){
          $('#auto').autocomplete({
              source:"getdata",
              minLength: 3,
              select: function(event, ui){
                $("#response").val(ui.item.id);
              }
         });
       });
      </script>
       
    </body>
</html>