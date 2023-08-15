@extends('docs.template.layout')
@section('content')      
            <div class="table-responsive">
                    <table class="table table-condensed table-bordered">
                        <thead class="bg-dark text-white">
                            <th>Method</th>
                            <th>URI</th>
                            <th>Name</th>
                            <th>Headers</th>
                            <th>Query String</th>
                            <th>Request Payload</th>
                            <th>Response</th>
                            <th>Authentication</th>
                            <th>Description</th>
                        </thead>
                        <tbody>
                            @foreach ($result as $data)
                            <tr>
                                <td><span class="badge bg-@php echo App\Http\Controllers\DocsController::get_method_status($data->method) @endphp">{{ $data->method }}</span></td>
                                <td>{{ $data->uri }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->headers }}</td>
                                <td>
                                @if(!empty($data->query))
                                <pre class="text-left text-primary">{{ $data->query }}</pre>
                                @endif
                                </td>
                                <td>  
                                @if(!empty($data->payload))
                                <pre class="text-left text-primary">{{ json_encode(json_decode($data->payload),JSON_PRETTY_PRINT) }}</pre>
                                @endif
                                </td>
                                <td>
                                @if(!empty($data->response))
                                <pre class="text-left text-primary">{{ json_encode(json_decode($data->response),JSON_PRETTY_PRINT) }}</pre>
                                @endif
                                </td>
                                <td><span class="badge bg-@php echo App\Http\Controllers\DocsController::get_auth_status($data->auth_type) @endphp">{{ $data->auth_type }}</span></td>
                                <td>{{ $data->description }}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                  </table>
            </div>
@endsection