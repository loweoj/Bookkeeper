<tr data-id="{{{ $stream->id }}}" data-json="{{{ $stream->toJson() }}}">
    <td colspan="5">
        {{ $stream->name }}
    </td>

    <td colspan="12">
        {{ $stream->description }}
    </td>

    <td colspan="3" class="align-right">
        <a href="#" data-toggle="modal" data-target="#editModal" class="btn  btn--transaction  js-modal-edit">Edit</a>
        <a href="#" class="btn  btn--transaction  js-modal-delete" data-toggle="modal" data-target="#deleteModal"><i class="glyphicon-remove"></i></a>
    </td>
</tr>