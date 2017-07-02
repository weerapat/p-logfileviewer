<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Log File Viewer</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- App css -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container" id="app">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Log File Viewer</h1>
                </div>
            </div>

            <log-viewer-table></log-viewer-table>
        </div><!-- /.container -->

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
