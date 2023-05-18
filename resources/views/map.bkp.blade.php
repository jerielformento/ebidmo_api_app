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
                                <td>/api/v1/stores/<span class="fw-bold">{id}</span></td>
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
                                <td>/api/v1/stores/<span class="fw-bold">{id}</span></td>
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
                                <td>/api/v1/stores/<span class="fw-bold">{id}</span></td>
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
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/bids</td>
                                <td>bids.index</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>
                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>View bid products</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">POST</span></td>
                                <td>/api/v1/bids</td>
                                <td>bids.store</td>
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
                                <td>View bid products</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>/api/v1/bids/<span class="fw-bold">{id}</span></td>
                                <td>bids.show</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>                        
                                </td>
                                <td>
                                </td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>View bid products</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">DELETE</span></td>
                                <td>/api/v1/bids/<span class="fw-bold">{id}</span></td>
                                <td>bids.destroy</td>
                                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                                <td>

                                </td>
                                <td></td>
                                <td><span class="badge bg-success">AUTH</span></td>
                                <td>Delete customer bid</td>
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
                        </tbody>
                  </table>
            </div>
@endsection