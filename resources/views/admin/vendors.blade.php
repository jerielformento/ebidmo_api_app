@extends('admin.template.layout')
@section('content')     
<div class="table-responsive">
    <h4>Store Applications</h4>
    <table class="table table-condensed table-bordered">
        <thead class="bg-dark text-white">
            <th>Store Name</th>
            <th>Slug</th>
            <th>Verification</th>
            <th>Owner</th>
            <th>Application</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($data as $vendor)
            <tr>
                <td>{{ $vendor->name }}</td>
                <td>{{ $vendor->slug }}</td>
                <td>
                    @if($vendor->verified === 1)
                        <span class="badge bg-success">Verified</span>
                    @else 
                        <span class="badge bg-info">For approval</span>
                    @endif
                </td>
                <td>{{ $vendor->customer->username }}</td>
                <td>
                    <ul>
                        <li>Store Link: <a href="{{$vendor->verification->social_store_link}}" target="_blank">{!! $vendor->verification->social_store_link !!}</a></li>
                        <li>Ownership Proof: <a href="{{$vendor->verification->ownership_proof_image}}" target="_blank">View attachment</a></li>
                    </ul>
                </td>
                <td>
                    @if($vendor->verified === 0)
                    <button type="button" class="btn btn-sm btn-primary btn-approval" data-bs-toggle="modal" data-bs-target="#staticBackdrop" sid="{{ $vendor->verification->store_id }}">
                        Approval
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
  </table>

  <!-- Modal Approve -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Store Approval</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Approve this application? 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="store_approval">Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

    $(function(){
        let selected_id = 0;

        $('button.btn-approval').on('click', function(e) {
            e.preventDefault();
            selected_id = $(this).attr('sid');
        });

        $('#store_approval').on('click', function() {
            $(this).attr('disabled', true);
            $.ajax({
                url: "/ebidmo-admin/vendors/approval",
                type: "POST",
                data: { id: selected_id },
                success: function(data) {
                    $('#staticBackdrop').modal('hide');
                    $(this).attr('disabled', false);
                    location.reload();
                }
            });
        });
    });
</script>
@endsection