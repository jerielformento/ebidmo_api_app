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
                <td>/api/v1/utilities/auth/types</td>
                <td>auth.types</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>List of user authentication type</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/utilities/user/roles</td>
                <td>user.roles</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>List of user role</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/utilities/product/conditions</td>
                <td>product.conditions</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>List of product condition</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/utilities/product/brands</td>
                <td>product.brands</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>List of product brand</td>
            </tr>
            <tr>
                <td><span class="badge bg-success">GET</span></td>
                <td>/api/v1/utilities/currencies</td>
                <td>currencies.list</td>
                <td><p><strong>Accept:</strong> application/json<br/><strong>Content-Type:</strong> application/json</p></td>
                <td>

                </td>
                <td></td>
                <td><span class="badge bg-success">AUTH</span></td>
                <td>List of currencies</td>
            </tr>
        </tbody>
  </table>
</div>
@endsection