<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel PHP Framework</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab|Roboto' rel='stylesheet' type='text/css'>
    {{ HTML::style('/assets/css/global.css') }}

</head>
    <body>
    @yield('content')

    {{ HTML::script('/assets/js/global.js') }}
    </body>
</html>