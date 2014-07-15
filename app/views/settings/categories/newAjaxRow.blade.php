<tr>
    <td colspan="4">
        {{ $category->code }}
    </td>

    <td colspan="6">
        {{ $category->name }}
    </td>

    <td colspan="6">
        {{ $category->description }}
    </td>

    <td colspan="2">
        {{ $category->type }}
    </td>

    <td colspan="4" class="transaction-utils">
        <a href="{{ URL::action('CategoriesController@edit', ['id' => $category->id]) }}" class="btn  btn--transaction">Edit</a>
        <a href="#" class="btn  btn--transaction  js-delete"><i class="glyphicon-remove"></i></a>
    </td>
</tr>