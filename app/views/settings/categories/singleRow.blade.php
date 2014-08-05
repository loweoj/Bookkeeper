<tr data-id="{{{ $category->id }}}" data-json="{{{ $category->toJson() }}}">
    <td colspan="2">
        {{ $category->code }}
    </td>

    <td colspan="5">
        {{ $category->name }}
    </td>

    <td colspan="12">
        {{ $category->description }}
    </td>

    <td colspan="2" class="align-right">
        {{ $category->type }}
    </td>

    <td colspan="3" class="align-right">
        <a href="#" data-toggle="modal" data-target="#editModal" class="btn  btn--util  js-modal-edit">Edit</a>
        <a href="#" class="btn  btn--util  btn--util-icon  js-modal-delete" data-toggle="modal" data-target="#deleteModal"><i class="glyphicon-remove"></i></a>
    </td>
</tr>