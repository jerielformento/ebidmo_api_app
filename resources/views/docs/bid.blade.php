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
                <td>/api/v1/bid</td>
                <td>bid.index</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>
                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>View list of customer bid products</td>
            </tr>
            <tr>
                <td><span class="badge bg-primary">POST</span></td>
                <td>/api/v1/bid</td>
                <td>bid.store</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>
<pre class="text-left text-primary">
{ 
    "product_id": "integer",
    "min_price": "integer",
    "buy_now_price": "integer",
    "currency": "string(3)"
}
</pre>                                    
                </td>
                <td>
                </td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Publish a product for bidding</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/bid/<span class="fw-bold">{id}</span></td>
                <td>bid.show</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>                        
                </td>
                <td>
                </td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Get specific bid product details</td>
            </tr>
            <tr>
                <td><span class="badge bg-danger">DELETE</span></td>
                <td>/api/v1/bid/<span class="fw-bold">{id}</span></td>
                <td>bid.destroy</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Cancel product for bidding (not finalized yet)</td>
            </tr>
        </tbody>
  </table>
</div>
@endsection