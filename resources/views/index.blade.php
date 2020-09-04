<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
<title>Asteroid data</title>
</head>
<body>

    <div class="container-fluid p-4" id="app">
        <div class="row">
            <div class="col-md-6">
                 <neo-asteroid-component></neo-asteroid-component>
            </div>
            <div class="col-md-6 mx-auto">
                 <h3 class="text-info">NEO Chart</h3>

                <neo-chart-component></neo-chart-component>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/vuejs-datepicker"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> --}}
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
