<div>
    <form wire:submit.prevent="filter" action="javascript:void(0)" id="filter-form">
        <table class="table">
            <thead>
                @foreach ($filters as $key => $value)
                    <tr>
                        <th>
                            {{ $value }}
                        </th>
                        <th>
                            <input type="text" wire:model.lazy="filters.{{ $value }}" name="{{ $value }}" placeholder="{{ $value }}">
                        </th>
                    </tr>
                @endforeach
            </thead>
            <tbody>
                <tr>
                    <td colspan="{{ count($filters) }}">
                        <button type="submit" onclick="filter()">Filter</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
