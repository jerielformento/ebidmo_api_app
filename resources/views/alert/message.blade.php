@if ($message = Session::get('success'))  
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $message }}
</div>
@endif  
  
@if ($message = Session::get('danger'))  
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
</div>
@endif  
  
@if ($message = Session::get('warning'))  
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ $message }}
</div>
@endif  
  
@if ($message = Session::get('info'))  
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ $message }}
</div>
@endif  
  
@if ($errors->any())  
<div class="alert alert-error alert-dismissible fade show" role="alert">
    Error!
</div>
@endif  