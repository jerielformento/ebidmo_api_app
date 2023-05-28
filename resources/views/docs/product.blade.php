@extends('docs.template.layout')
@section('content')     
<div class="table-responsive">
    <table class="table table-condensed table-bordered">
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
                <td>/api/v1/products</td>
                <td>products.index</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>
                    
                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>View all products (store owner)</td>
            </tr>
            <tr>
                <td><span class="badge bg-primary">POST</span></td>
                <td>/api/v1/product</td>
                <td>product.store</td>
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
                <td>/api/v1/product/<span class="fw-bold">{id}</span></td>
                <td>product.show</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>
                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Get product details</td>
            </tr>
            <tr>
                <td><span class="badge bg-warning">PUT</span></td>
                <td>/api/v1/product/<span class="fw-bold">{id}</span></td>
                <td>product.update</td>
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
                <td>/api/v1/product/<span class="fw-bold">{id}</span></td>
                <td>product.destroy</td>
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
@endsection