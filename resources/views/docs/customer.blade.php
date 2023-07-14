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
                <td>/api/v1/customer</td>
                <td>customer.index</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td></td>
                <td>
                </td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>View customers</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/customer/<span class="fw-bold">{id}</span></td>
                <td>customer.show</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>
            
                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Get customer details</td>
            </tr>
            <tr>
                <td><span class="badge bg-warning">PUT</span></td>
                <td>/api/v1/customer/<span class="fw-bold">{id}</span></td>
                <td>customer.update</td>
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
                <td>/api/v1/customer/<span class="fw-bold">{id}</span></td>
                <td>customer.destroy</td>
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
                <td>customer.bid</td>
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
                <td>/api/v1/customer/auction/<span class="fw-bold">{product_slug}</span></td>
                <td>auction.show</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>
                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Get vendor auction item details</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/customer/bid/history/<span class="fw-bold">{customer_id}</span></td>
                <td>customer.bid.history</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>
                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Get customer bid history for specific auction item</td>
            </tr>
        </tbody>
  </table>
</div>
@endsection