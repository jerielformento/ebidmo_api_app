@extends('docs.template.layout')
@section('content')      
    <section class="py-5 text-left border bg-white rounded">
    <div class="row">
      <div class="col-lg-6 col-md-8 mx-5">
        <h3 class="fw-dark">API Endpoints</h3>
        <p class="text-muted">All requests to the <a href="#">ebidmo.net</a> API are sent via the HTTP Request method to one of our endpoint URLs.</p>
        <p>
          <a href="/api-docs/auth" class="btn btn-warning my-2">Get Started</a>
        </p>
      </div>
    </div>
  </section>
@endsection