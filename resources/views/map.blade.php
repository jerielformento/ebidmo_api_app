<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="{{asset('js/app.js')}}"></script>-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"><img class="rounded" style="height:32px; width:32px;" src="images/ebidmo.png" alt=""> eBidmo</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </header>
      
      <div class="container-fluid">
        <div class="row">
          <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="home"></span>
                    API Endpoints
                  </a>
                </li>
              </ul>
            </div>
          </nav>
      
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">API Endpoints</h1>
              <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Code</button>
                </div>
              </div>
            </div>
      
            <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-dark text-white">
                            <th>Method</th>
                            <th>URI</th>
                            <th>Name</th>
                            <th>Headers</th>
                            <th>Request Payload</th>
                            <th>Response</th>
                            <th>Authentication</th>
                            <th>Description</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/</td>
                                <td>home</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td></td>
                                <td></td>
                                <td><span class="badge bg-primary">GUEST</span></td>
                                <td>Home Page</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td>/api/register</td>
                                <td>auth.register</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "username": "string",
    "email": "email",
    "password": "string",
    "password_confirmation": "string",
    "role": "integer",
    "firstname": "string",
    "lastname": "string",
    "middlename": "string",
    "phone": "number"
}
</pre>
                                </td>
                                <td></td>
                                <td><span class="badge bg-primary">GUEST</span></td>
                                <td>Customer registration</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td>/api/login</td>
                                <td>auth.login</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "username": "string",
    "password": "string"
}
</pre>
                                </td>
                                <td>
<pre class="text-left text-primary">
{ 
    "user": "object",
    "token": "string"
}
</pre>

                                </td>
                                <td><span class="badge bg-primary">GUEST</span></td>
                                <td>Login</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/customers</td>
                                <td>customers.index</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td></td>
                                <td>
                                </td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>View customers</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/customers/<span class="fw-bold">{id}</span></td>
                                <td>customers.show</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>

                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Get customer details</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">PUT</span></td>
                                <td>/api/v1/customers/<span class="fw-bold">{id}</span></td>
                                <td>customers.update</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "email": "email",
    "firstname": "string",
    "lastname": "string",
    "middlename": "string",
    "phone": "number",
    "password": "string",
    "password_confirmation": "string"
}
</pre>
                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Update customer information</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">DELETE</span></td>
                                <td>/api/v1/customers/<span class="fw-bold">{id}</span></td>
                                <td>customers.destroy</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>

                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Delete customer</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td>/api/v1/customer/bid</td>
                                <td>customers.store</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "bid_id": "integer",
    "price": "integer"
}
</pre>
                                    </td>
                                    <td></td>
                                    <td><span class="badge bg-success">AUTH</span></td>
                                <td>Customer bid</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/stores</td>
                                <td>stores.index</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>

                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>View stores</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td>/api/v1/stores</td>
                                <td>stores.store</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "store_name": "string"
}
</pre>
                                    </td>
                                    <td></td>
                                    <td><span class="badge bg-success">AUTH</span></td>
                                <td>Create new store</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/stores/<span class="fw-bold">{customer_id}</span></td>
                                <td>stores.show</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "customer_id": "integer"
}
</pre>
                                    </td>
                                    <td></td>
                                    <td><span class="badge bg-success">AUTH</span></td>
                                <td>Get customer store details</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">PUT</span></td>
                                <td>/api/v1/stores/<span class="fw-bold">{customer_id}</span></td>
                                <td>stores.update</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "store_name": "string"
}
</pre>
                                    </td>
                                    <td></td>
                                    <td><span class="badge bg-success">AUTH</span></td>
                                <td>Update store information</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">DELETE</span></td>
                                <td>/api/v1/stores/<span class="fw-bold">{customer_id}</span></td>
                                <td>stores.destroy</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>

                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Delete customer store</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td>/api/v1/logout</td>
                                <td>logout</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
                                   
                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Logout auth user</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/products</td>
                                <td>products.index</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
                                    
                                </td>
                                <td></td>
                                <td><span class="badge bg-primary">GUEST</span></td>
                                <td>View all products</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td>/api/v1/products</td>
                                <td>products.store</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "name": "string",
    "details": "text",
    "condition": "integer",
    "brand": "integer",
    "quantity": "integer",
    "images"[]: "files"
}
</pre>
                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Add new product</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/products/<span class="fw-bold">{id}</span></td>
                                <td>products.show</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
                                </td>
                                <td></td>
                                <td><span class="badge bg-primary">GUEST</span> <span class="badge bg-success">AUTH</span></td>
                                <td>Get product details</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">PUT</span></td>
                                <td>/api/v1/products/<span class="fw-bold">{id}</span></td>
                                <td>products.update</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
<pre class="text-left text-primary">
{ 
    "name": "string",
    "details": "text",
    "condition": "integer",
    "brand": "integer",
    "quantity": "integer",
    "images"[]: "files"
}
</pre>
                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Update product information</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">DELETE</span></td>
                                <td>/api/v1/products/<span class="fw-bold">{id}</span></td>
                                <td>products.destroy</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
                                    
                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Delete product</td>
                            </tr>
                        </tbody>
                  </table>
            </div>
          </main>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>