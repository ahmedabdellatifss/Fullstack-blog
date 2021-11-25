<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Full stack blog</title>

        <link rel="stylesheet" href="/css/all.css">

        <script>
            (function () {
                window.laravel = {
                    csrfToken: '{{ csrf_token()}}'
                };
            })();

        </script>


    </head>
    <body>
        <div id="app">
            <mainapp></mainapp>
        </div>
    </body>
    <script src="{{asset('/js/app.js')}}"></script>
</html>
