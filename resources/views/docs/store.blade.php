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
                <td>/api/v1/stores</td>
                <td>stores.index</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>View list of store</td>
            </tr>
            <tr>
                <td><span class="badge bg-primary">POST</span></td>
                <td>/api/v1/store</td>
                <td>store.store</td>
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
                <td>Create own store</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/store/<span class="fw-bold">{id}</span></td>
                <td>store.show</td>
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
                <td>Get other customer store details</td>
            </tr>
            <tr>    
                <td><span class="badge bg-warning">PUT</span></td>
                <td>/api/v1/store/<span class="fw-bold">{id}</span></td>
                <td>store.update</td>
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
                <td>Update own store information</td>
            </tr>
            <tr>
                <td><span class="badge bg-danger">DELETE</span></td>
                <td>/api/v1/store/<span class="fw-bold">{id}</span></td>
                <td>store.destroy</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>Deactivate store (not finalized yet)</td>
            </tr>
        </tbody>
  </table>
</div>
@endsection