<!DOCTYPE html>
@include('layouts.lang')
<head>
   @stack('tnscard-head')
   @stack('tnscard-head-end')
</head>
<body>
   @stack('tnscard-body-start')
   <div class="container">
      <div class="row">
         <div class="column" style="margin-top: 5%">
            @stack('tnscard-content')
         </div>
      </div>
   </div>
   @stack('tnscard-body-end')
</body>
</html>