<div>
    <form wire:submit.prevent="filter">
        <label for="type">نوع مرکز:</label>
        <select wire:model="type" id="type">
            <option value="type1">نوع ۱</option>
            <option value="type2">نوع ۲</option>
            <option value="type3">نوع ۳</option>
        </select>
        <button type="submit">فیلتر</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>نام</th>
                <th>آدرس</th>
                <th>تلفن</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($centers as $center)
                <tr wire:click.prevent="openModal({{ $center->id }})">
                    <td>{{ $center->Name }}</td>
                    <td>{{ $center->Address }}</td>
                    <td>{{ $center->Tel }}</td>
                    <td><button>ویرایش</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
