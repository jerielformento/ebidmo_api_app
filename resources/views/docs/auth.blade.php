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
                        </tbody>
                  </table>
            </div>
@endsection